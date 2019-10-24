<?php

namespace App\Helpers;

use Carbon\Carbon;


class MonthHelper
{
    public $currMonth;
    public $currYear;
    public $prevMonth;
    public $prevYear;
    public $prevMonthName;

    public function __construct()
    {
        $this->currMonth = $this->getCurrMonth();
        $this->currYear = $this->getCurrYear();
        $this->prevMonth = $this->getPrevMonth();
    }

    public function getPrevMonthName() : string
    {
        $months = array(1 => 'Январь', 2 => 'Февраль', 3 => 'Март',	4 => 'Апрель',
            5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
            9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь');

        return $months[$this->prevMonth];
    }

    public function getCurrMonth() : int
    {
        $now = Carbon::now();
        return $now->month;
    }

    private function getCurrYear() : int
    {
        $now = Carbon::now();
        return $now->year;
    }

    private function getPrevMonth() : int
    {
        $prevMonth = $this->currMonth - 1;
        if($prevMonth == '0') $prevMonth = '12';
        if($prevMonth == '12') $this->currYear = $this->currYear - 1;

        return $prevMonth;
    }

    private function getPrevYear() : int
    {

    }

}