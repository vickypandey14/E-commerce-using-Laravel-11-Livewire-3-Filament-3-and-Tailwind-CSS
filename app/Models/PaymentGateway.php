<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $table = 'payment_gateways';

    protected $fillable = [
        'name',
        'code',
        'driver',
        'is_active',
        'environment',
        'priority',
        'is_default',
        'credentials',
        'settings',
        'health_status',
        'last_health_check_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'credentials' => 'encrypted:array',
        'settings' => 'array',
        'last_health_check_at' => 'datetime',
    ];

    /**
     * Scope to only include active gateways.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Set the current gateway as default, unsetting other defaults.
     */
    public function makeDefault()
    {
        self::where('id', '!=', $this->id)->update(['is_default' => false]);
        $this->update(['is_default' => true]);
    }
}
