<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'target_product_id',
        'planned_quantity',
        'actual_quantity',
        'start_date',
        'estimated_completion_date',
        'actual_completion_date',
        'stage',
        'status',
        'water_usage_liters',
        'waste_generated_kg',
        'recycled_wax_kg',
        'total_production_cost',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'estimated_completion_date' => 'date',
        'actual_completion_date' => 'date',
        'planned_quantity' => 'integer',
        'actual_quantity' => 'integer',
        'water_usage_liters' => 'decimal:2',
        'waste_generated_kg' => 'decimal:2',
        'recycled_wax_kg' => 'decimal:2',
        'total_production_cost' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'target_product_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(ProductionDetail::class);
    }
}

