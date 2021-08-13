<?php

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
Route::apiResource('/expense','App\Http\Controllers\Api\ExpenseController');
Route::apiResource('/customer','App\Http\Controllers\Api\CustomerController');

Route::Post('/payroll/paid/{id}','App\Http\Controllers\Api\PayrollController@Pay');
Route::Get('/payroll','App\Http\Controllers\Api\PayrollController@AllPay');
Route::Get('/payroll/view/{id}','App\Http\Controllers\Api\PayrollController@ViewPayroll');
Route::Get('/edit/payroll/{id}','App\Http\Controllers\Api\PayrollController@EditPayroll');
Route::Post('/payroll/update/{id}','App\Http\Controllers\Api\PayrollController@UpdateSalary');

Route::Post('/stock/update/{id}','App\Http\Controllers\Api\ProductController@StockUpdate');

Route::Get('/retrieve/product/{id}','App\Http\Controllers\Api\PosController@GetProduct');

// Add to cart Routes
Route::Get('/addtocart/{id}','App\Http\Controllers\Api\CartController@addtocart');
Route::Get('/cart/product','App\Http\Controllers\Api\CartController@CartProduct');
Route::Get('/remove/cart/{id}','App\Http\Controllers\Api\CartController@removeCart');
Route::Get('/increment/{id}','App\Http\Controllers\Api\CartController@increment');
Route::Get('/decrement/{id}','App\Http\Controllers\Api\CartController@decrement');

// Vat Route
Route::Get('/vats','App\Http\Controllers\Api\CartController@Vats');

Route::Post('/saledone','App\Http\Controllers\Api\PosController@saledone');

// Sales Route
Route::Get('/sales','App\Http\Controllers\Api\SaleController@TodaySales');

Route::Get('/sales/summary/{id}','App\Http\Controllers\Api\SaleController@SaleSummary');
Route::Get('/sales/saledetails/{id}','App\Http\Controllers\Api\SaleController@SaleDetails');

Route::Post('/search/sales','App\Http\Controllers\Api\PosController@SearchSalesDate');

//Admin Dashboard Route
Route::Get('/today/sales','App\Http\Controllers\Api\PosController@TodaySales');
Route::Get('/today/income','App\Http\Controllers\Api\PosController@TodayIncome');
Route::Get('/today/due','App\Http\Controllers\Api\PosController@TodayDue');
Route::Get('/today/expense','App\Http\Controllers\Api\PosController@TodayExpense');
Route::Get('/today/stockout','App\Http\Controllers\Api\PosController@TodayStockout');