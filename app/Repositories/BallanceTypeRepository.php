<?php
namespace App\Repositories;

use App\Account;
use App\Repositories\Interfaces\BallanceTypeInterface;

class BallanceTypeRepository implements BallanceTypeInterface
{
    public function getBallanceTypeArrByAccount(Account $account)
    {
        return BallanceType::where('account_id',$this->acc_id)->get()->toArray();
    }
}