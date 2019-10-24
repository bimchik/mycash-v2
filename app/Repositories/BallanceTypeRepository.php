<?php
namespace App\Repositories;

use App\Repositories\Interfaces\BallanceTypeInterface;
use App\BallanceType;

class BallanceTypeRepository implements BallanceTypeInterface
{
    public function getBallanceTypesArrByAccount($account)
    {
        return BallanceType::where('account_id',$account->id)->get()->toArray();
    }

    public function getBallanceTypesWithContacts($account)
    {
        return BallanceType::where('account_id',$account->id)->with('shareContacts.user','shareContacts')->get();
    }

}