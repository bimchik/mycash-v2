<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'account_id', 'from_ballance_id', 'to_ballance_id','from_ballance_type_id', 'to_ballance_type_id', 'sum','operation_type'
    ];

    public function from_ball()
    {
        return $this->hasOne('App\Ballance', 'id', 'from_ballance_id');
    }

    public function to_ball()
    {
        return $this->hasOne('App\Ballance', 'id', 'to_ballance_id');
    }
}
