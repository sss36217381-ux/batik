<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_order_id',
        'raw_material_id',
        'planned_qty',
        'actual_qty',
        'unit_cost',
        'subtotal_cost',
        'notes',
    ];

    protected $casts = [
        'planned_qty' => 'decimal:2',
        'actual_qty' => 'decimal:2',
        'unit_cost' => 'decimal:2',
        'subtotal_cost' => 'decimal:2',
    ];

    public function productionOrder(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function rawMaterial(): BelongsTo
    {
        return $this->belongsTo(RawMaterial::class);
    }
}

