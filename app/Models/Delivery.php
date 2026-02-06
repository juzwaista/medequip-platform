<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    protected $fillable = [
        'order_id',
        'tracking_number',
        'delivery_address',
        'scheduled_date',
        'actual_delivery_at',
        'driver_name',
        'driver_contact',
        'proof_of_delivery_path',
        'status',
        'notes',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'actual_delivery_at' => 'datetime',
    ];

    /**
     * Get the order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the full URL for proof of delivery
     */
    public function getProofUrlAttribute(): ?string
    {
        return $this->proof_of_delivery_path
            ? asset('storage/' . $this->proof_of_delivery_path)
            : null;
    }

    /**
     * Generate unique tracking number
     */
    public static function generateTrackingNumber(): string
    {
        do {
            $number = 'TRK-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('tracking_number', $number)->exists());

        return $number;
    }
}
