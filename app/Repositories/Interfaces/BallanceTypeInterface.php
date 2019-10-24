<?php

namespace App\Repositories\Interfaces;



interface BallanceTypeInterface
{
    public function getBallanceTypesArrByAccount($account);
    public function getBallanceTypesWithContacts($account);
}