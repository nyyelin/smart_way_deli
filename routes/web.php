<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/','Auth\LoginController@showLoginForm');

//language
Route::get('lang/{locale}', 'LocalizationController@index')->name('lang');


Route::middleware('auth')->group(function () {
  Route::get('dashboard','MainController@dashboard')->name('dashboard');
  Route::get('getways', 'MainController@getways')->name('getways');

  Route::prefix('settings')->group(function () {
    // Settings => (cities, townships, statuses, expense_types, payment_types, banks)
    Route::resource('cities','CityController');
    Route::resource('townships','TownshipController');
    Route::resource('statuses','StatusController');
    Route::resource('expense_types','ExpenseTypeController');
    Route::resource('payment_types','PaymentTypeController');
    Route::resource('banks','BankController');
    Route::resource('sendergate','SenderGateController'); 
    Route::resource('senderoffice','SenderOfficeController');
  });

  Route::post('expensebytype','ExpenseController@expensebytype')->name('expensebytype');
  // Success List
  Route::get('success_list','MainController@success_list')->name('success_list');

  // Reject List
  Route::get('reject_list','MainController@reject_list')->name('reject_list');
  Route::post('rejectitem','MainController@rejectitem')->name('rejectitem');

  // Return List
  Route::get('return_list','MainController@return_list')->name('return_list');
  Route::post('returnitem','MainController@returnitem')->name('returnitem');

  // Delay List
  Route::get('delay_list','MainController@delay_list')->name('delay_list');
  Route::get('delaycount','MainController@delaycount')->name('delaycount');

  // Financial Statement
  Route::get('statements','MainController@financial_statements')->name('statements');
  Route::post('successreport','MainController@successreport')->name('successreport');

  // Debt List
  Route::get('debt_list','MainController@debt_list')->name('debt_list');
  Route::get('debt_history','MainController@debt_history')->name('debt_history');

  Route::get('way_history','MainController@way_history')->name('way_history');
  Route::get('pickup_history','MainController@pickup_history')->name('pickup_history');
  Route::get('historydetails/{id}','MainController@historydetails')->name('historydetails');

  Route::get('debit/getdebitlistbyclient/{id}', 'MainController@getdebitlistbyclient')->name('debit.getdebitlistbyclient');
  Route::post('debit/getdebithistorybyclient', 'MainController@getdebithistorybyclient')->name('debit.getdebithistorybyclient');

  Route::post('getwayhistory','MainController@getwayhistory')->name('getwayhistory');
  Route::post('pickupbyclient','MainController@pickupbyclient')->name('pickupbyclient');
  Route::post('fix_debit', 'MainController@fix_debit')->name('fix_debit');

  Route::post('updateincome','MainController@updateincome')->name('updateincome');
  Route::post('incomesearch','MainController@incomesearch')->name('incomesearch');
  Route::post('waysreport','MainController@waysreport')->name('waysreport');
  Route::post('expensesearch','MainController@expensesearch')->name('expensesearch');
  Route::post('profit','MainController@profit')->name('profit');
  Route::get('banktransfer','MainController@banktransfer')->name('banktransfer');
  Route::post('transfer','MainController@transfer')->name('transfer.store');
  //pickupdone by delivery man
  Route::get('pickupdone/{id}/{qty}','MainController@pickupdone')->name('pickupdone');

  //amounta ad qty edit
  Route::post('editamountandqty','MainController@editamountandqty')->name('editamountandqty');

  //normal
  Route::get('normal/{id}','MainController@normal')->name('normal');

  // staff
  Route::resource('staff','StaffController');

  // Pickup Schedule By Staff
  Route::resource('schedules', 'ScheduleController');

  // client
  Route::get('cancel', 'MainController@cancel')->name('cancel.index');

  Route::post('uploadfile', 'ScheduleController@uploadfile')->name('uploadfile');
  Route::post('storeandassignschedule', 'ScheduleController@storeandassignschedule')->name('schedules.storeandassign');

  Route::resource('items', 'ItemController');
  Route::get('items/collectitem/{cid}/{pid}','ItemController@collectitem')->name('items.collect');
  Route::post('itemdetail','ItemController@itemdetail')->name('itemdetail');
  Route::post('wayassign','ItemController@assignWays')->name('wayassign');

  Route::get('checkitem/{pickupid}','ItemController@checkitem')->name('checkitem');
  Route::get('lastitem','ItemController@lastitem')->name('lastitem');
  Route::post('updateamount','ItemController@updateamount')->name('updateamount');
  
  Route::get('rejectnoti','MainController@rejectnoti')->name('rejectnoti');
  Route::get('clearrejectnoti/{id}','MainController@clearrejectnoti')->name('clearrejectnoti');
  Route::get('seennoti','MainController@seennoti')->name('seennoti');
  Route::post('updatewayassign','ItemController@updatewayassign')->name('updatewayassign');
  Route::post('townshipbystatus','ItemController@townshipbystatus')->name('townshipbystatus');
  Route::get('deletewayassign/{id}','ItemController@deletewayassign')->name('deletewayassign');

  Route::resource('clients', 'ClientController');
  Route::resource('delivery_men', 'DeliveryMenController');

  Route::get('incomes', 'MainController@incomes')->name('incomes');
  Route::get('incomes/addincomes', 'MainController@addincomeform')->name('incomes.create');
  Route::get('incomes/getsuccesswaysbydeliveryman/{id}', 'MainController@successways')->name('incomes.successways');
  Route::post('incomes/addincomes', 'MainController@addincomes')->name('incomes.store');
  Route::post('getitembyway', 'MainController@getitembyway')->name('getitembyway');
  Route::resource('expenses','ExpenseController');

  // For Client
  Route::get('pickups','MainController@pickups')->name('pickups');
  Route::post('pickups','MainController@donepickups')->name('donepickups');
  Route::post('delichargebytown','ItemController@delichargebytown')->name('delichargebytown');
  Route::resource('client_items', 'ClientItemController');
  Route::post('client_order','ClientItemController@client_order')->name('client_order');
  Route::get('order_assign\{id}','ClientItemController@order_assign')->name('order_assign');
  Route::post('deliverymanbytownship','ClientItemController@deliverymanbytownship')->name('deliverymanbytownship');
  Route::post('order_assign_store\{id}','ClientItemController@order_assign_store')->name('order_assign_store');


  // For Report
  Route::get('report','MainController@report')->name('report');
  Route::post('report_search','MainController@report_search')->name('report_search');
  Route::get('cleint_daily_report','MainController@cleint_daily_report')->name('cleint_daily_report');
  Route::post('client_report_search','MainController@client_report_search')->name('client_report_search');




  // Route::get('client_item_create','ItemController@client_item_create')->name('client_item_create');
  // Route::post('client_item_edit/{id}','ItemController@client_item_edit')->name('client_item_edit');



  // Route::get('ways','MainController@ways')->name('ways');

  Route::prefix('ways')->group(function () {
    Route::get('pending','MainController@pending_ways')->name('pending_ways');
    Route::get('success','MainController@success_ways')->name('success_ways');
    Route::post('pendingwaysbytownship','MainController@pendingwaysbytownship')->name('pendingwaysbytownship');
    Route::post('pendingwaysbygate','MainController@pendingwaysbygate')->name('pendingwaysbygate');
    Route::post('pendingwaysbyoffice','MainController@pendingwaysbyoffice')->name('pendingwaysbyoffice');
  });



  Route::post('waybydeliveryman','MainController@waybydeliveryman')->name('waybydeliveryman');
  Route::post('/createpdf', 'MainController@createpdf')->name('createpdf');

  Route::post('makeDelivered','MainController@makeDeliver')->name('makeDeliver');
  Route::post('retuenDeliver','MainController@retuenDeliver')->name('retuenDeliver');
  Route::post('rejectDeliver','MainController@rejectDeliver')->name('rejectDeliver');
});

Route::resource('profiles','ProfileController');

Auth::routes(['register'=>false]);

Route::get('/home', 'HomeController@index')->name('home');
