<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    //
    protected $casts = [
        'days' => 'array',
    ];
}
