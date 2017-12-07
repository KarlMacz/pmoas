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
        Route::post('feedbacks/create', ['as' => 'feedbacks_create', 'uses' => 'HomeController@postCreateFeedback']);
    });
});

Route::group(['as' => 'auth.'], function() {
    Route::group(['as' => 'get.'], function() {
        Route::get('login', ['as' => 'login', 'uses' => 'AuthenticationController@login']);
        Route::get('logout', ['as' => 'logout', 'uses' => 'AuthenticationController@logout']);
        Route::get('register', ['as' => 'register', 'uses' => 'AuthenticationController@register']);
        Route::get('forgot_password/step_1', ['as' => 'forgot_password_step_one', 'uses' => 'AuthenticationController@forgotPasswordStepOne']);
        Route::get('forgot_password/step_2/{username}', ['as' => 'forgot_password_step_two', 'uses' => 'AuthenticationController@forgotPasswordStepTwo']);
        Route::get('verification/{code}', ['as' => 'verification', 'uses' => 'AuthenticationController@verification']);
    });

    Route::group(['as' => 'post.'], function() {
        Route::post('login', ['as' => 'login', 'uses' => 'AuthenticationController@postLogin']);
        Route::post('register', ['as' => 'register', 'uses' => 'AuthenticationController@postRegister']);
        Route::post('forgot_password/step_1', ['as' => 'forgot_password_step_one', 'uses' => 'AuthenticationController@postForgotPasswordStepOne']);
        Route::post('forgot_password/step_2', ['as' => 'forgot_password_step_two', 'uses' => 'AuthenticationController@postForgotPasswordStepTwo']);
    });
});

Route::group(['as' => 'employees.'], function() {
    Route::group(['as' => 'get.'], function() {
        Route::get('dashboard', ['as' => 'index', 'uses' => 'EmployeeController@index']);
        Route::get('products_catalogue', ['as' => 'products', 'uses' => 'EmployeeController@products']);
        Route::get('products_catalogue/add', ['as' => 'products_add', 'uses' => 'EmployeeController@addProduct']);
        Route::get('products_catalogue/edit/{id}', ['as' => 'products_edit', 'uses' => 'EmployeeController@editProduct']);
        Route::get('enterprise_contracts', ['as' => 'contracts', 'uses' => 'EmployeeController@contracts']);
        Route::get('enterprise_contracts/add', ['as' => 'contracts_add', 'uses' => 'EmployeeController@addContract']);
        Route::get('enterprise_contracts/{id}/document', ['as' => 'contract_documents', 'uses' => 'EmployeeController@document']);
        Route::get('employees', ['as' => 'employees_view', 'uses' => 'EmployeeController@employees']);
        Route::get('employees/register', ['as' => 'employees_register', 'uses' => 'EmployeeController@registerEmployee']);
        Route::get('clients', ['as' => 'clients_view', 'uses' => 'EmployeeController@clients']);
        Route::get('company_clients/register', ['as' => 'company_clients_register', 'uses' => 'EmployeeController@registerCompanyClient']);
    });

    Route::group(['as' => 'post.'], function() {
        Route::post('dashboard', ['as' => 'index', 'uses' => 'EmployeeController@index']);
        Route::post('products_catalogue/add', ['as' => 'products_add', 'uses' => 'EmployeeController@postAddProduct']);
        Route::post('products_catalogue/edit/{id}', ['as' => 'products_edit', 'uses' => 'EmployeeController@postEditProduct']);
        Route::post('products_catalogue/delete', ['as' => 'products_delete', 'uses' => 'EmployeeController@postDeleteProduct']);
        Route::post('enterprise_contracts/add', ['as' => 'contracts_add', 'uses' => 'EmployeeController@postAddContract']);
        Route::post('enterprise_contracts/delete', ['as' => 'contracts_delete', 'uses' => 'EmployeeController@postDeleteContract']);
        Route::post('enterprise_contracts/{id}/document/add', ['as' => 'contract_documents_add', 'uses' => 'EmployeeController@postAddDocument']);
        Route::post('enterprise_contracts/document/delete', ['as' => 'contract_documents_delete', 'uses' => 'EmployeeController@postDeleteDocument']);
        Route::post('employees/register', ['as' => 'employees_register', 'uses' => 'EmployeeController@postRegisterEmployee']);
        Route::post('company_clients/register', ['as' => 'company_clients_register', 'uses' => 'EmployeeController@postRegisterCompanyClient']);
    });
});

Route::group(['as' => 'clients.'], function() {
    Route::group(['as' => 'get.'], function() {
        Route::get('home', ['as' => 'index', 'uses' => 'ClientController@index']);
        Route::get('products', ['as' => 'products', 'uses' => 'ClientController@products']);
        Route::get('orders', ['as' => 'orders', 'uses' => 'ClientController@orders']);
        Route::get('payments', ['as' => 'payments', 'uses' => 'ClientController@payments']);
        Route::get('contracts', ['as' => 'contracts', 'uses' => 'ClientController@contracts']);
        Route::get('contracts/view/{code}', ['as' => 'contracts_view', 'uses' => 'ClientController@viewContract']);
    });
});

Route::group(['as' => 'cart.'], function() {
    Route::group(['as' => 'get.'], function() {
        Route::get('cart', ['as' => 'index', 'uses' => 'CartController@index']);
    });

    Route::group(['as' => 'post.'], function() {
        Route::post('cart/add', ['as' => 'cart_add', 'uses' => 'CartController@postAddItemToCart']);
        Route::post('cart/remove', ['as' => 'cart_remove', 'uses' => 'CartController@postRemoveItemFromCart']);
    });
});

Route::group(['as' => 'maintenance.'], function() {
    Route::group(['as' => 'get.'], function() {
        Route::get('maintenance', ['as' => 'index', 'uses' => 'MaintenanceController@index']);
        Route::get('maintenance/database/{filename}', ['as' => 'database', 'uses' => 'MaintenanceController@downloadBackupDatabase']);
        Route::get('maintenance/files/{filename}', ['as' => 'files', 'uses' => 'MaintenanceController@downloadBackupFile']);
    });

    Route::group(['as' => 'post.'], function() {
        Route::post('maintenance/backup', ['as' => 'backup', 'uses' => 'MaintenanceController@postBackup']);
    });
});

Route::group(['as' => 'resources.'], function() {
    Route::group(['as' => 'get.'], function() {
        Route::get('resources/date_time', ['as' => 'date_time', 'uses' => 'ResourceController@dateTime']);
        Route::get('resources/download/{type}/{file}', ['as' => 'download', 'uses' => 'ResourceController@download']);
    });

    Route::group(['as' => 'post.'], function() {
        Route::post('resources/products', ['as' => 'products', 'uses' => 'ResourceController@postProducts']);
    });
});
