<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunBillItem extends Model
{
    protected $fillable = [
        'commun_bill_id', 'commun_field_id', 'last_val', 'next_val', 'sum', 'status_save', 'status_pay'
    ];

    public function field()
    {
        return $this->hasOne('App\CommunField' , 'id', 'commun_field_id');
    }
}
