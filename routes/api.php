<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', 'AuthController@register');
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
});

Route::get('/user', 'AuthController@user')->middleware('auth:api');
Route::apiResource('/roles', 'RoleController')->middleware('auth:api');
Route::apiResource('/bills', 'BillsController')->middleware('auth:api');
Route::post('/bill_cart', 'BillsController@billCart')->middleware('auth:api');
Route::get('/clear_all_bills', 'BillsController@clearAllBills')->middleware('auth:api');
Route::post('/change_product_qty', 'BillsController@changeProductQty')->middleware('auth:api');
Route::post('/delete_single_bill', 'BillsController@deleteSingleBill')->middleware('auth:api');
Route::post('/delete_single_product', 'BillsController@deleteSingleProduct')->middleware('auth:api');
Route::post('/put_bill_onhold', 'BillsController@putBillOnhold')->middleware('auth:api');
Route::post('/remove_bill_onhold', 'BillsController@removeBillOnhold')->middleware('auth:api');

Route::get('/carts', 'BillsController@carts')->middleware('auth:api');
Route::get('/carts_onhold', 'BillsController@cartsOnhold')->middleware('auth:api');

Route::apiResource('/product_categories', 'ProductCategoriesController')->middleware('auth:api');
Route::apiResource('/products', 'ProductsController')->middleware('auth:api');
Route::get('/get_stocks', 'ProductsController@getStocks')->middleware('auth:api');
Route::post('/create_stocks', 'ProductsController@createStocks')->middleware('auth:api');
Route::post('/stocks_date', 'ProductsController@stocksDate')->middleware('auth:api');
Route::delete('/remove_stock/{id}', 'ProductsController@removeStock')->middleware('auth:api');

Route::apiResource('/payments', 'PaymentsController')->middleware('auth:api');
Route::apiResource('/sales', 'SalesController')->middleware('auth:api');
Route::get('/sales_today', 'SalesController@salesToday')->middleware('auth:api');
Route::get('/sales_today_cash', 'SalesController@salesTodayCash')->middleware('auth:api');
Route::get('/sales_today_mpesa', 'SalesController@salesTodayMpesa')->middleware('auth:api');
Route::get('/sales_today_credit', 'SalesController@salesTodayCredit')->middleware('auth:api');
Route::get('/sales_product_cost', 'SalesController@salesProductCost')->middleware('auth:api');
Route::get('/sales_today_data', 'SalesController@salesTodayData')->middleware('auth:api');

Route::apiResource('/expense_categories', 'ExpenseCategoryController')->middleware('auth:api');
Route::apiResource('/expenses', 'ExpenseController')->middleware('auth:api');
Route::get('/expenses_today_data', 'ExpenseController@expenses_today_data')->middleware('auth:api');
Route::post('/reports_date', 'ExpenseController@reportsData')->middleware('auth:api');

Route::get('/purchases', 'PurchasesController@purchases')->middleware('auth:api');
Route::post('/save_purchase', 'PurchasesController@savePurchase')->middleware('auth:api');
Route::get('/expenses_today', 'PurchasesController@expensesToday')->middleware('auth:api');
Route::get('/purchases_today', 'PurchasesController@purchasesToday')->middleware('auth:api');
