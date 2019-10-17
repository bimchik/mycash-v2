<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunBill extends Model
{
    public $timestamps = true;
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'account_id', 'total_sum', 'status_save','status_pay','created_at', 'monthName'
    ];

    public function billItems()
    {
        return $this->hasMany('App\CommunBillItem' , 'commun_bill_id', 'id');
    }
}
