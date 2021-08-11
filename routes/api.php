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