<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'tracking_number',
        'courier_name',
        'shipping_address',
        'shipping_date',
        'estimated_arrival',
        'actual_arrival',
        'status',
        'is_on_time',
        'delivery_notes',
    ];

    protected $casts = [
        'shipping_date' => 'date',
        'estimated_arrival' => 'date',
        'actual_arrival' => 'date',
        'is_on_time' => 'boolean',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
}

