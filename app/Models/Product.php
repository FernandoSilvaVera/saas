<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const PALABRAS = 1;
    const PREGUNTAS = 2;
    const RESUMENES = 3;
    const MAPA_CONCEPTUAL = 4;

    protected $fillable = [
	    'name',
	    'type',
	    'quantity',
	    'price',
	    'stripe_product_id',
	    'is_active',
	    'stripe_price_id',
    ];

}
