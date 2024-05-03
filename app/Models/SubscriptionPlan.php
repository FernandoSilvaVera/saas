<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'name',
        'word_limit',
        'test_questions_count',
        'summaries',
        'voiceover',
        'editors_count',
        'monthly_price',
        'annual_price',
        'description',
        'stripe_product_id',
        'stripe_monthly_price_id',
        'stripe_annual_price_id'
    ];
}
