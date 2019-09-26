<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //
    protected $fillable = ['user_id', 'tariff_id', 'first_day', 'address'];
}
