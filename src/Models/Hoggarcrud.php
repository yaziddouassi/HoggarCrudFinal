<?php

namespace Hoggarcrud\Hoggar\Models;

use Illuminate\Database\Eloquent\Model;

class Hoggarcrud extends Model
{

    protected $fillable = [
        'model',
        'label',
        'route',
        'icon',
        'active',
    ];
    
    protected $casts = [
        'active' => 'boolean',
    ];
}