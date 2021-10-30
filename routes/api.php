<?php

if (App::environment('production')) {
    URL::forceScheme('https');
}

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('signup', 'App\Http\Controllers\AuthController@signup');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');

});

Route::apiResource('/employee','App\Http\Controllers\Api\EmployeeController');
Route::apiResource('/supplier','App\Http\Controllers\Api\SupplierController');
Route::apiResource('/category','App\Http\Controllers\Api\CategoryController');
Route::apiResource('/product','App\Http\Controllers\Api\ProductController');
Route::apiResource('/reservation','App\Http\Controllers\Api\ReservationController');

Route::apiResource('/expense','App\Http\Controllers\Api\ExpenseController');
Route::Post('/myexpense','App\Http\Controllers\Api\ExpenseController@myExpenses');
Route::Get('/expenseotheruser/{id}','App\Http\Controllers\Api\ExpenseController@OtherUserExpenses');
Route::Post('/cancelexpense/{id}','App\Http\Controllers\Api\ExpenseController@cancelExpense');
Route::Get('/expenseusers/{id}','App\Http\Controllers\Api\PosController@UserExpense');

Route::apiResource('/journal','App\Http\Controllers\Api\JournalController');
Route::Post('/myjournal','App\Http\Controllers\Api\JournalController@myJournal');
Route::Get('/journalotheruser/{id}','App\Http\Controllers\Api\JournalController@OtherUserJournal');
Route::Post('/canceljournal/{id}','App\Http\Controllers\Api\JournalController@cancelJournal');
Route::Get('/journalusers/{id}','App\Http\Controllers\Api\PosController@UserJournal');


Route::apiResource('/customer','App\Http\Controllers\Api\CustomerController');

// pay api route
Route::apiResource('/pay','App\Http\Controllers\Api\PayController');


// payroll api route
Route::Post('/payroll/paid/{id}','App\Http\Controllers\Api\PayrollController@Pay');
Route::Get('/payroll','App\Http\Controllers\Api\PayrollController@AllPay');
Route::Get('/payroll/view/{id}','App\Http\Controllers\Api\PayrollController@ViewPayroll');
Route::Get('/edit/payroll/{id}','App\Http\Controllers\Api\PayrollController@EditPayroll');
Route::Post('/add-payroll','App\Http\Controllers\Api\PayrollController@Pay');
Route::Post('/payroll/update/{id}','App\Http\Controllers\Api\PayrollController@UpdateSalary');
Route::Post('/payroll/transact/{id}','App\Http\Controllers\Api\PayrollController@TransactSalary');
Route::Get('/payroll/status/{id}','App\Http\Controllers\Api\PayController@GetPayStatus');


Route::Post('/stock/update/{id}','App\Http\Controllers\Api\ProductController@StockUpdate');

Route::Get('/retrieve/product/{id}','App\Http\Controllers\Api\PosController@GetProduct');

// Add to cart Routes
//Route::Get('/addtocart/{id}','App\Http\Controllers\Api\CartController@addtocart');
Route::Post('/addtocart/{id}','App\Http\Controllers\Api\CartController@addtocart');

Route::Get('/cart/product/{id}','App\Http\Controllers\Api\CartController@CartProduct');
Route::Post('/remove/cart/{id}','App\Http\Controllers\Api\CartController@removeCart');
Route::Post('/increment/{id}','App\Http\Controllers\Api\CartController@increment');
Route::Post('/decrement/{id}','App\Http\Controllers\Api\CartController@decrement');


// Get settings Route
Route::Get('/settings','App\Http\Controllers\Api\CartController@Settings');
Route::Get('/sysdate/','App\Http\Controllers\Api\CartController@Sysdate');

// Vat Route
Route::Get('/vats','App\Http\Controllers\Api\CartController@Vats');

Route::Post('/saledone','App\Http\Controllers\Api\PosController@saledone');

// Sales Route
Route::Get('/sales','App\Http\Controllers\Api\SaleController@TodaySales');

Route::Get('/sales/summary/{id}','App\Http\Controllers\Api\SaleController@SaleSummary');
Route::Get('/sales/saledetails/{id}','App\Http\Controllers\Api\SaleController@SaleDetails');

Route::Post('/search/sales','App\Http\Controllers\Api\PosController@SearchSalesDate');

//Admin Dashboard Route
Route::Post('/today/sales','App\Http\Controllers\Api\PosController@TodaySales');
Route::Get('/today/income','App\Http\Controllers\Api\PosController@TodayIncome');
Route::Get('/today/due','App\Http\Controllers\Api\PosController@TodayDue');
Route::Get('/today/expense','App\Http\Controllers\Api\PosController@TodayExpense');
Route::Get('/today/stockout','App\Http\Controllers\Api\PosController@TodayStockout');


//Accounting
Route::Post('/income','App\Http\Controllers\Api\JournalController@GenerateIncome');
Route::Post('/balance','App\Http\Controllers\Api\JournalController@GenerateBalance');
Route::Post('/trialbalance','App\Http\Controllers\Api\JournalController@GenerateTrialBalance');

//Accounting Group
Route::apiResource('/acctgroup','App\Http\Controllers\Api\AcctgroupController');
Route::Get('/acctgroupexp','App\Http\Controllers\Api\AcctgroupController@AcctGroupExp');

//Accounting Item
Route::apiResource('/acctitem','App\Http\Controllers\Api\AcctitemController');
Route::Get('/acctitem/group/{id}','App\Http\Controllers\Api\AcctitemController@AcctItemGroup');


//Room Categories
Route::apiResource('/roomcategory','App\Http\Controllers\Api\RoomCategoryController');

//Rooms
Route::apiResource('/room','App\Http\Controllers\Api\RoomController');
Route::Get('/room/categ/{id}','App\Http\Controllers\Api\RoomController@RoomCateg');