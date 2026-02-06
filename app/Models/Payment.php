<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id',
        'payment_method',
        'amount',
        'reference_number',
        'proof_of_payment_path',
        'status',
        'verified_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the invoice
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the full URL for proof of payment
     */
    public function getProofUrlAttribute(): ?string
    {
        return $this->proof_of_payment_path
            ? asset('storage/' . $this->proof_of_payment_path)
            : null;
    }
}
