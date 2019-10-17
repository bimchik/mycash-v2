<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	    Schema::defaultStringLength(191);

    
        view()->composer('includes.sidebar', function ($view){
            $view->with(
                'inc_cats' , \App\Category::where('section','incomings')->where('account_id', auth()->user()->account->id)->get()->toArray()
            )->with('spend_cats' , \App\Category::where('section','spendings')->where('account_id', auth()->user()->account->id)->get()->toArray());
        });

        view()->composer('includes.top-nav', function ($view){
            $acc_id = auth()->user()->account->id;
            $currentMonth = (int)date('m');
            $currentYear = (int)date('Y');

            $ball_total = \App\Ballance::where('account_id', $acc_id)->where('month',$currentMonth)->where('year',$currentYear)->selectRaw('sum(sum) as sum')->get();

            //dd($ball_total);

            $incomings = \App\Incoming::where('account_id', $acc_id)->with('ballance')->get();

            $inc_sum = 0;
            foreach ($incomings as $inc){

                if($inc->ballance !== null && $inc->ballance->month == $currentMonth && $inc->ballance->year == $currentYear)
                    $inc_sum += $inc->price;
            }

            $spendings = \App\Spending::where('account_id', $acc_id)->whereRaw('MONTH(created_at) = ?',[$currentMonth])->select('total_price')->get();

            $spend_sum = 0;
            foreach ($spendings as $spend){
                $spend_sum += $spend['total_price'];
            }
            $view->with('inc_sum' , $inc_sum)
                ->with('spend_sum' , $spend_sum)
                ->with('ball_total',$ball_total->sum);
        });
    }
}
