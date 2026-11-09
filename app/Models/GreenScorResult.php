<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GreenScorResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_period',
        'evaluation_date',
        'plan_score',
        'source_score',
        'make_score',
        'deliver_score',
        'return_score',
        'total_index',
        'category',
        'notes',
        'evaluated_by',
    ];

    protected $casts = [
        'evaluation_date' => 'date',
        'plan_score' => 'decimal:4',
        'source_score' => 'decimal:4',
        'make_score' => 'decimal:4',
        'deliver_score' => 'decimal:4',
        'return_score' => 'decimal:4',
        'total_index' => 'decimal:4',
    ];
}

