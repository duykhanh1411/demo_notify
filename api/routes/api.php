<?php

use Illuminate\Http\Request;
//use App\Models\UserInfo;
//use App\Models\UserLogin;

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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();
}); */

/// Route::get('login', array('uses' => 'LoginController@showLogin')) ;
/// Route::post('/login', array('uses' => 'LoginController@doLogin')) ;

/*STR Login controller*/
Route::post('login', 'LoginController@doLogin') ;
/*END Login controller*/

/*STR Company controller*/
Route::post('companyGenerateAction', 'CompanyController@doCompanyGenerateAction') ;
Route::post('company/getCompany', 'CompanyController@getCompany');
Route::get('company/exportExcel', 'CompanyController@exportExcel');
/*END Company controller*/

/*STR Staff controller*/
Route::post('test', 'MyFirstController@doTest') ;
Route::get('test/getAllCompany', 'MyFirstController@getAllCompany');
Route::post('test/uploadFile', 'MyFirstController@uploadFile');
Route::post('test/uploadFileStaff', 'MyFirstController@uploadFileStaff');
Route::post('test/searchStaff', 'MyFirstController@searchStaff');
Route::post('test/exportExcel', 'MyFirstController@exportExcel');
/*End Staff controller*/

/*STR Authenticate controller*/
Route::post('auth/create', 'AuthController@createAuthenticate');
/*END Authenticate controller*/

Route::get('auth/get', 'AuthController@getAuthenticate');//->middleware('auth:api');


Route::get('logout', array('uses' => 'LoginController@doLogout')) ;

Route::get('/shop/show', 'ShopController@Show'); //->middleware('auth:api'); /shop/show
Route::get('/shop/fab_ric/{fab_ric}', 'ShopController@Show_fab_ric'); //->middleware('auth:api');
Route::get('/shop/type/{type}', 'ShopController@Show_type'); //->middleware('auth:api');
Route::get('/shop/show/{fab_ric}/{type}', 'ShopController@Show_fab_ric_and_type'); //->middleware('auth:api');

Route::get('/auth/create/{user_name}/{pass}', 'AuthController@createAuthenticate'); //->middleware('auth:api');

Route::post('notify', 'LoginController@notify') ;



