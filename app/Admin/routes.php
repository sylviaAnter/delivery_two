<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('companies', CompanyController::class);
    $router->resource('invoices', InvoiceController::class);
    $router->resource('regions', RegionController::class);
    $router->resource('vehicles', VehiclController::class);
    $router->resource('drivers', DDriverController::class);
});
