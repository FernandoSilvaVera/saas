<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
	    'email',
	    'palabras_maximas',
	    'numero_editores',
	    'numero_preguntas',
	    'numero_resumenes',
	    'locucion_en_linea',
	    'otros_usuarios',
	    'plan_contratado',
    ];

}
