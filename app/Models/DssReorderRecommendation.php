<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DssReorderRecommendation extends Model
{
    protected $fillable = [
        'distributor_id',
        'product_id',
        'branch_id',
        'current_stock',
        'recommended_quantity',
        'avg_daily_sales',
        'days_until_stockout',
        'priority',
        'is_actioned',
    ];

    protected $casts = [
        'avg_daily_sales' => 'decimal:2',
        'is_actioned' => 'boolean',
    ];

    /**
     * Get the distributor
     */
    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class);
    }

    /**
     * Get the product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the branch (if applicable)
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Mark as actioned
     */
    public function markAsActioned(): void
    {
        $this->update(['is_actioned' => true]);
    }

    /**
     * Get priority color
     */
    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            'high' => 'red',
            'medium' => 'yellow',
            'low' => 'green',
            default => 'gray',
        };
    }
}
