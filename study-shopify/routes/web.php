<?php

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

$router->get('/', 'ShopifyController@checkUrl');
$router->get('install', 'ShopifyController@install');


$router->get('product/all', 'ProductsController@getProductsList');

$router->get('product/{id:[0-9]+}', 'ProductsController@getProductInfo');
$router->get('product/{id:[0-9]+}/collect', 'ProductsController@getProductCollection');
$router->delete('product/{id:[0-9]+}', 'ProductsController@deleteProduct');
$router->put('product/{id:[0-9]+}', 'ProductsController@productUpdate');
$router->post('product/create', 'ProductsController@postProduct');
$router->get('page/all', 'PagesController@getPagesList');
$router->get('theme/all', 'ThemesController@getThemesList');
$router->get('theme/{id:[0-9]+}/file/', 'ThemesController@getThemesFile');
$router->get('blog/all', 'BlogsController@getBlogsList');
$router->get('blog/{id:[0-9]+}/article', 'ArticlesController@getArticlesList');

