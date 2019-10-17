<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name', 'unit'
    ];

    public function locations()
    {
        return $this->belongsToMany('App\Location');
    }

    public function loctag()
    {
        return $this->hasOne('App\LocTag');
    }
}
