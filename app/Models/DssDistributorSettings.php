<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DssDistributorSettings extends Model
{
    protected $fillable = [
        'distributor_id',
        'low_stock_threshold_days',
        'expiry_warning_days',
        'dead_stock_days',
        'enable_auto_alerts',
        'custom_rules',
    ];

    protected $casts = [
        'enable_auto_alerts' => 'boolean',
        'custom_rules' => 'array',
    ];

    /**
     * Get the distributor
     */
    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class);
    }
}
