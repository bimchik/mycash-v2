<?php

namespace App\Repositories\Interfaces;


use App\Account;

interface BallanceTypeInterface
{
    public function getBallanceTypeArrByAccount(Account $account);
}