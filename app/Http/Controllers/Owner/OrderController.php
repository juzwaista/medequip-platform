<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display orders list
     */
    public function index(Request $request)
    {
        $distributor = auth()->user()->distributor;

        if (!$distributor) {
            return redirect()->route('owner.dashboard')
                ->with('error', 'Please create your distributor profile first');
        }

        $query = Order::with(['customer', 'items'])
            ->where('distributor_id', $distributor->id);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                    ->orWhereHas('customer', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Owner/Orders/Index', [
            'orders' => $orders,
            'filters' => [
                'status' => $request->status ?? '',
                'search' => $request->search ?? '',
            ],
        ]);
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        $distributor = auth()->user()->distributor;

        // Ensure distributor owns this order
        if ($order->distributor_id !== $distributor->id) {
            abort(403);
        }

        $order->load([
            'customer',
            'items.product.images',
            'items.inventory.branch',
            'invoice.payments',
            'delivery'
        ]);

        return Inertia::render('Owner/Orders/Show', [
            'order' => $order,
        ]);
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $distributor = auth()->user()->distributor;

        if ($order->distributor_id !== $distributor->id) {
            \Log::warning('[OrderController] Unauthorized status update attempt', [
                'order_id' => $order->id,
                'distributor_id' => $distributor->id,
                'order_distributor_id' => $order->distributor_id
            ]);
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,approved,rejected,packed,shipped,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        \Log::info('[OrderController] Status update initiated', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'old_status' => $oldStatus,
            'new_status' => $newStatus
        ]);

        // Prevent invalid status transitions
        if ($oldStatus === $newStatus) {
            return back()->with('info', 'Order status is already ' . $oldStatus);
        }

        // If approving order, validate stock and deduct inventory
        if ($newStatus === 'approved' && $oldStatus === 'pending') {
            \Log::info('[OrderController] Approving order, validating stock availability');
            
            // Re-validate stock availability before approval
            foreach ($order->items as $item) {
                if ($item->inventory->quantity < $item->quantity) {
                    \Log::error('[OrderController] Insufficient stock for approval', [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'required' => $item->quantity,
                        'available' => $item->inventory->quantity
                    ]);
                    
                    return back()->withErrors([
                        'error' => "Insufficient stock for {$item->product->name}. Required: {$item->quantity}, Available: {$item->inventory->quantity}"
                    ]);
                }
            }

            // Deduct actual stock and clear reservation
            foreach ($order->items as $item) {
                if (!$item->inventory->deduct($item->quantity)) {
                    \Log::error('[OrderController] Failed to deduct stock', [
                        'inventory_id' => $item->inventory_id,
                        'quantity' => $item->quantity
                    ]);
                    return back()->withErrors(['error' => 'Failed to deduct inventory']);
                }
            }

            \Log::info('[OrderController] Order approved, stock deducted', [
                'order_id' => $order->id
            ]);
        }

        // If rejecting/cancelling, release reserved inventory
        if (in_array($newStatus, ['rejected', 'cancelled'])) {
            \Log::info('[OrderController] Releasing reserved inventory', [
                'order_id' => $order->id,
                'status' => $newStatus
            ]);

            try {
                foreach ($order->items as $item) {
                    $item->inventory->releaseReservation($item->quantity);
                }
                \Log::info('[OrderController] Reserved inventory released successfully');
            } catch (\Exception $e) {
                \Log::error('[OrderController] Failed to release reserved inventory', [
                    'error' => $e->getMessage(),
                    'order_id' => $order->id
                ]);
                return back()->withErrors(['error' => 'Failed to release inventory: ' . $e->getMessage()]);
            }
        }

        // If shipped, create delivery record
        if ($newStatus === 'shipped' && $oldStatus !== 'shipped') {
            \Log::info('[OrderController] Creating delivery record');
            
            Delivery::create([
                'order_id' => $order->id,
                'tracking_number' => 'TRK-' . strtoupper(uniqid()),
                'carrier' => $request->carrier ?? 'Standard Delivery',
                'status' => 'in_transit',
            ]);
        }

        // If delivered, mark delivery completion
        if ($newStatus === 'delivered') {
            \Log::info('[OrderController] Marking order as delivered');
            
            $order->update(['delivered_at' => now()]);
            if ($order->delivery) {
                $order->delivery->update([
                    'status' => 'delivered',
                    'delivered_at' => now(),
                ]);
            }

            // No inventory change here - already deducted at approval
            \Log::info('[OrderController] Order delivered successfully', [
                'order_id' => $order->id,
                'delivered_at' => now()
            ]);
        }

        // Update order status
        $order->update(['status' => $newStatus]);

        \Log::info('[OrderController] Order status updated successfully', [
            'order_id' => $order->id,
            'final_status' => $newStatus
        ]);

        return back()->with('success', "Order status updated to {$newStatus}");
    }

    /**
     * Add order notes
     */
    public function addNote(Request $request, Order $order)
    {
        $distributor = auth()->user()->distributor;

        if ($order->distributor_id !== $distributor->id) {
            abort(403);
        }

        $request->validate([
            'note' => 'required|string|max:1000',
        ]);

        $currentNotes = $order->notes ?? '';
        $timestamp = now()->format('Y-m-d H:i:s');
        $newNote = "[{$timestamp}] " . $request->note;

        $order->update([
            'notes' => $currentNotes ? $currentNotes . "\n\n" . $newNote : $newNote,
        ]);

        return back()->with('success', 'Note added successfully');
    }
}
