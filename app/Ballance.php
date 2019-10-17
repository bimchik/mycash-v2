<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ballance extends Model
{
    protected $fillable = [
        'account_id','ballance_type_id','sum','month_name','month','year'
    ];

    public function ballance_type()
    {
        return $this->belongsTo('App\BallanceType');
    }

    public function account()
    {
        return $this->belongsTo('App\Account');
    }
}
