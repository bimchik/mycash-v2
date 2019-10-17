<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocTag extends Model
{
    protected $table = 'location_tag';

    protected $fillable = [
        'tag_id', 'location_id', 'unit_price'
    ];

    public function tag(){
        return $this->hasOne('App\Tag' ,'id', 'tag_id');
    }

    public function location(){
        return $this->hasOne('App\Location','id', 'location_id');
    }
}
