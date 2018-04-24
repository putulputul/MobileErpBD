<?php

use Illuminate\Http\Request;

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

Route::post('login', 'API\PassportController@login');
Route::post('register', 'API\PassportController@register');

Route::group(['middleware' => 'auth:api'], function(){

    Route::get('/{table_name}', 'ApiController@unitOfMeasurment');
    Route::post('/item/add', 'ApiController@itemAdd');
    Route::post('/product/add', 'ApiController@productAdd');
    Route::get('/{table_name}/drop_down', 'ApiController@apiDropDown');
    Route::get('fileentry', 'FileEntryController@index');
    Route::get('fileentry/get/{filename}', [
        'as' => 'getentry', 'uses' => 'FileEntryController@get']);
    Route::post('get-details', 'API\PassportController@getDetails');
    Route::post('/stock/edit', 'ApiController@stockEdit');
    Route::post('/sales/add', 'ApiController@saleAdd');
    Route::post('fileentry/add',[
        'as' => 'addentry', 'uses' => 'FileEntryController@add']);




});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});






