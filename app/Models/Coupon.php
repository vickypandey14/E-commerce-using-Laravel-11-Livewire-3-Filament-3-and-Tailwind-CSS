<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_amount',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
        'value' => 'decimal:2',
        'min_amount' => 'decimal:2',
    ];

    /**
     * Check if the coupon is valid.
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Check if coupon can be applied to a specific cart amount.
     */
    public function isValidForAmount($amount): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        return $amount >= $this->min_amount;
    }

    /**
     * Calculate discount amount based on the cart total.
     */
    public function calculateDiscount($total): float
    {
        if ($this->type === 'percent') {
            return round(($total * $this->value) / 100, 2);
        }

        return min($this->value, $total);
    }
}
