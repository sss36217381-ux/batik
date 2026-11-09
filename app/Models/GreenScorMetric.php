<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GreenScorMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'dimension',
        'metric_name',
        'description',
        'unit',
        'target_value',
        'actual_value',
        'weight',
        'normalized_score',
        'final_score',
    ];

    protected $casts = [
        'target_value' => 'decimal:2',
        'actual_value' => 'decimal:2',
        'weight' => 'decimal:4',
        'normalized_score' => 'decimal:2',
        'final_score' => 'decimal:2',
    ];
}

