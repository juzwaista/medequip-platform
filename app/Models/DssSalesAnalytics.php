<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DssSalesAnalytics extends Model
{
    protected $fillable = [
        'distributor_id',
        'product_id',
        'analysis_date',
        'period_type',
        'total_orders',
        'total_revenue',
        'total_quantity_sold',
        'average_order_value',
        'top_products',
    ];

    protected $casts = [
        'analysis_date' => 'date',
        'total_revenue' => 'decimal:2',
        'average_order_value' => 'decimal:2',
        'top_products' => 'array',
    ];

    /**
     * Get the distributor
     */
    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class);
    }

    /**
     * Get the product (if product-specific analytics)
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
