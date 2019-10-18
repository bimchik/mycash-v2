<?php
namespace App\Repositories;

use App\Account;
use App\Spending;
use App\Repositories\Interfaces\SpendingsInterface;

class SpendingsRepository implements SpendingsInterface
{
    public function allByAccount(Account $acc)
    {
        return Spending::where('account_id',$acc->id)->get();
    }
}