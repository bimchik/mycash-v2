<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/allops/{id}', ['uses'=>'HomeController@allOps'])->name('allops');
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

    Route::get('/category/add/{section}', 'CategoriesController@index')->name('categories.form');
    Route::post('/category/add/cat', ['uses' => 'CategoriesController@store'])->name('categories.add');

    Route::get('/incomings/add/{?id}','IncomingsController@index');
    Route::post('/incomings/store','IncomingsController@store')->name('incomings.add');

    Route::get('/category/incomings/{slug}',['uses'=>'IncomingsController@list'])->name('incomings.list');
    Route::get('/incomings/type/{id}',['uses'=>'IncomingsController@typelist'])->name('incomings.typelist');
    Route::get('/category/incomings',['uses'=>'IncomingsController@list'])->name('incomings.listfull');

    Route::get('/spendings/add','SpendingsController@index');
    Route::post('/spendings/store','SpendingsController@store')->name('spendings.store');
    Route::post('/spendings/fetch','SpendingsController@fetch')->name('spendings.fetch');
    Route::post('/spendings/fetchLoc','SpendingsController@fetchLoc')->name('spendings.fetchLoc');

    Route::get('/category/spendings/{slug}',['uses'=>'SpendingsController@list'])->name('spendings.list');
    Route::get('/spendings/type/{id}',['uses'=>'SpendingsController@typelist'])->name('spendings.typelist');
    Route::get('/category/spendings',['uses'=>'SpendingsController@list'])->name('spendings.listfull');

    Route::get('/commun/fields','CommunFieldsController@index');
    Route::post('/commun/fields/store','CommunFieldsController@store')->name('commun.fields.store');
    Route::delete('/commun/fields/{id}','CommunFieldsController@delete')->name('commun.fields.delete');

    Route::get('/commun/bills','CommunBillsController@index');
    Route::get('/commun/bills/add','CommunBillsController@currMonthBill');
    Route::post('/commun/bills/store','CommunBillsController@store')->name('commun.bills.store');
    Route::get('/commun/bill/{id}',['uses'=>'CommunBillsController@bill'])->name('commun.bill');

    Route::get('/buylists/createlist','BuyListsController@createList');
    Route::post('/buylists/fetch','BuyListsController@fetch')->name('buylists.fetch');
    Route::post('/buylists/add','BuyListsController@store')->name('buylists.add');
    Route::get('/buylists/list/{id}',['uses'=>'BuyListsController@single'])->name('buylists.single');

    Route::get('/settings/ballancetypes','BallanceTypesController@index');
    Route::post('/settings/ballancetypes/add','BallanceTypesController@store')->name('ballancetypes.store');

    Route::get('/archive/transfers','TransfersController@index');
    Route::get('/archive/ballances','BallancesController@index');
    Route::post('/transfers/transfer','TransfersController@transfer')->name('transfers.transfer');

    Route::get('/contacts','ContactController@index');
    Route::get('/contacts/add','ContactController@add')->name('contacts.add');
    Route::post('/contacts/search','ContactController@search')->name('contacts.search');
    Route::post('/contacts/store','ContactController@store')->name('contacts.store');

    Route::get('/requests','ContactController@requests');
    Route::post('/requests/accept','ContactController@accept');
    Route::post('/requests/cancel','ContactController@cancel');

});

