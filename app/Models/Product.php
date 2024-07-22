<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
	    'name',
	    'type',
	    'quantity',
	    'price',
	    'stripe_product_id',
	    'is_active',
    ];

}
