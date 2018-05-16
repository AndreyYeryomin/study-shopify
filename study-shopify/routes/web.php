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
$router->get('product/{id}', 'ProductsController@getProductInfo');
$router->delete('product/{id}', 'ProductsController@postProduct');
$router->put('product/{id}', 'ProductsController@productUpdate');
$router->post('product/create', 'ProductsController@postProduct');
$router->get('page/all', 'PagesController@getPagesList');
$router->get('theme/all', 'ThemesController@getThemesList');
$router->get('blog/all', 'BlogsController@getBlogsList');
$router->get('blog/{id}/article', 'ArticlesController@getArticlesList');
$router->get('page/all', 'PagesController@getPagesList');
