<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'distributor_id',
        'branch_name',
        'address',
        'contact_number',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the distributor
     */
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    /**
     * Get inventory records for this branch
     */
    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }
}
