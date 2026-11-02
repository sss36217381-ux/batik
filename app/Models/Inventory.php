<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_type',
        'item_id',
        'current_stock',
        'safety_stock',
        'warehouse_location',
        'last_counted_at',
    ];

    protected $casts = [
        'current_stock' => 'decimal:2',
        'safety_stock' => 'decimal:2',
        'last_counted_at' => 'datetime',
    ];
}
