<?php
namespace App\Repositories;

use App\Spending;
use App\Repositories\Interfaces\SpendingsInterface;

class SpendingsRepository implements SpendingsInterface
{
    public function allByAccount($account)
    {
        return Spending::where('account_id',$account->id)->get();
    }
}