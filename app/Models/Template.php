<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'logo_path',
        'favicon_path',
        'template_name',
        'css_left',
        'css_right',
        'css_top',
        'css_icons',
        'typography',
        'font_size'
    ];
}
