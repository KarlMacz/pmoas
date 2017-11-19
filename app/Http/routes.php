<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['as' => 'home.'], function() {
    Route::group(['as' => 'get.'], function() {
        Route::get('/', ['as' => 'index', 'uses' => 'HomeController@index']);
    });

    Route::group(['as' => 'post.'], function() {
        Route::post('feedbacks/create', ['as' => 'create_feedbacks', 'uses' => 'HomeController@postCreateFeedback']);
    });
});

Route::group(['as' => 'auth.'], function() {
    Route::group(['as' => 'get.'], function() {
        Route::get('login', ['as' => 'login', 'uses' => 'AuthenticationController@login']);
        Route::get('logout', ['as' => 'logout', 'uses' => 'AuthenticationController@logout']);
        Route::get('register', ['as' => 'register', 'uses' => 'AuthenticationController@register']);
        Route::get('change_password', ['as' => 'change_password', 'uses' => 'AuthenticationController@changePassword']);
        Route::get('verification/{code}', ['as' => 'verification', 'uses' => 'AuthenticationController@verification']);
    });

    Route::group(['as' => 'post.'], function() {
        Route::post('login', ['as' => 'login', 'uses' => 'AuthenticationController@postLogin']);
        Route::post('register', ['as' => 'register', 'uses' => 'AuthenticationController@postRegister']);
        Route::post('change_password', ['as' => 'change_password', 'uses' => 'AuthenticationController@postChangePassword']);
    });
});

Route::group(['as' => 'employees.'], function() {
    Route::group(['as' => 'get.'], function() {
        Route::get('dashboard', ['as' => 'index', 'uses' => 'EmployeeController@index']);
        Route::get('employees/view', ['as' => 'employees_view', 'uses' => 'EmployeeController@viewEmployees']);
        Route::get('employees/register', ['as' => 'employees_register', 'uses' => 'EmployeeController@registerEmployee']);
        Route::get('clients/view', ['as' => 'clients_view', 'uses' => 'EmployeeController@viewClients']);
        Route::get('company_clients/register', ['as' => 'company_clients_register', 'uses' => 'EmployeeController@registerCompanyClient']);
    });

    Route::group(['as' => 'post.'], function() {
        Route::post('dashboard', ['as' => 'index', 'uses' => 'EmployeeController@index']);
        Route::post('employees/register', ['as' => 'employees_register', 'uses' => 'EmployeeController@postRegisterEmployee']);
        Route::post('company_clients/register', ['as' => 'company_clients_register', 'uses' => 'EmployeeController@postRegisterCompanyClient']);
    });
});

Route::group(['as' => 'clients.'], function() {
    Route::group(['as' => 'get.'], function() {
        Route::get('home', ['as' => 'index', 'uses' => 'ClientController@index']);
        Route::get('products', ['as' => 'products', 'uses' => 'ClientController@products']);
        Route::get('shopping_cart', ['as' => 'shopping_cart', 'uses' => 'ClientController@shoppingCart']);
        Route::get('billings', ['as' => 'billings', 'uses' => 'ClientController@billings']);
        Route::get('payments', ['as' => 'payments', 'uses' => 'ClientController@payments']);
        Route::get('contracts', ['as' => 'contracts', 'uses' => 'ClientController@contracts']);
    });
});

Route::group(['as' => 'resources.'], function() {
    Route::group(['as' => 'get.'], function() {
        Route::get('resources/date_time', ['as' => 'date_time', 'uses' => 'ResourceController@dateTime']);
    });

    Route::group(['as' => 'post.'], function() {
        Route::post('resources/products', ['as' => 'products', 'uses' => 'ResourceController@postProducts']);
    });
});
