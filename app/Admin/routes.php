<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.as'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('suppliers', Supplier\SupplierController::class);

    $router->resource('products', Product\ProductController::class);

    $router->resource('sales', Product\SaleController::class);

    $router->get('record-sales', 'Product\ProductController@recordsales');

    $router->get('product-sales-per-day', 'Product\ProductController@salesperday');

    $router->get('product-sales-per-month', 'Product\ProductController@salespermonth');

    $router->get('product-sales-per-product', 'Product\ProductController@salesperproduct');

    $router->get('fetch-product-px', 'Product\ProductController@getpx');

    $router->get('fetch-product-px-from-barcode', 'Product\ProductController@getpxbarcode');

    $router->get('product-confirm-sales', 'Product\ProductController@confirmsales');

    $router->get('add-product-to-sales', 'Product\ProductController@addproducttosales');

    $router->get('del-product-from-sales', 'Product\ProductController@delproductfromsales');

    $router->get('print-sales-report/{billid}', 'Product\ProductController@printbill');

    $router->get('fetch-app-product', 'Product\ProductController@fetchappproduct');

    $router->resource('roles', RoleController::class);

    $router->resource('auth/users', UserController::class);

});
