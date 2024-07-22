<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'history';


    protected $fillable = [
    	'id',
        'name',
	'userId',
        'templateName',
        'pathZip',
	'wordsUsed',
	'conceptualMap',
	'summary',
	'questionsUsed',
	'voiceOver',
	'status',
    ];
}
