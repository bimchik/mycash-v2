<?php

namespace App\Repositories\Interfaces;


use App\Account;

interface BallanceTypeInterface
{
    public function getBallanceTypesArrByAccount(Account $account);
}