<?php
use App\Register;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/browserProduct', 'browserProductController@create');
$router->post('/browserProduct1', 'browserProductController@store');
$router->get('/chooseShop', 'chooseShopController@index');
$router->get('/viewProduct', 'viewProductController@create');
$router->post('/viewProduct1', 'viewProductController@store');
$router->get('/getOrder', 'OrderController@getOrder');
$router->get('/viewOrder', 'OrderController@viewOrder');
$router->get('/CartToOrder', 'cartController@CartToOrder');
$router->get('/navSigninCheck', 'SigninCheckController@navSigninCheck');
$router->post('/getcart', 'getCartAmountController@store');
$router->get('/viewOrderDetail', 'cartController@viewOrderDetail');

