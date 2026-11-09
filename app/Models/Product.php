<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'motif_type',
        'size',
        'cost_price',
        'selling_price',
        'stock',
        'min_stock',
        'image_path',
        'description',
        'is_active',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'stock' => 'integer',
        'min_stock' => 'integer',
        'is_active' => 'boolean',
    ];

    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function productionOrders(): HasMany
    {
        return $this->hasMany(ProductionOrder::class, 'target_product_id');
    }

    public function isLowStock(): bool
    {
        return $this->stock <= $this->min_stock;
    }
}

