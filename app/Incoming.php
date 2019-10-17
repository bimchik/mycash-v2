<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incoming extends Model
{
    protected $fillable = [
        'account_id', 'category_id', 'price','ballance_type_id','ballance_id','day','operation_type'
    ];

    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function ballance()
    {
        return $this->belongsTo('App\Ballance', 'ballance_id', 'id');
    }
}
