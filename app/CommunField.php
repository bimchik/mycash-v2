<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunField extends Model
{
    protected $fillable = [
        'account_id', 'name', 'current_count_value', 'tariff_price', 'calcBy', 'people_count','space_count'
    ];
}
