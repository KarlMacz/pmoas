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
        Route::get('test', ['as' => 'test', 'uses' => 'HomeController@test']);
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
        Route::get('super_search', ['as' => 'search', 'uses' => 'EmployeeController@search']);
        Route::get('dashboard', ['as' => 'index', 'uses' => 'EmployeeController@index']);
        Route::get('client_orders', ['as' => 'orders', 'uses' => 'EmployeeController@orders']);
        Route::get('client_return_products', ['as' => 'products_return', 'uses' => 'EmployeeController@returnProducts']);
        Route::get('products_catalogue', ['as' => 'products', 'uses' => 'EmployeeController@products']);
        Route::get('products_catalogue/add', ['as' => 'products_add', 'uses' => 'EmployeeController@addProduct']);
        Route::get('products_catalogue/edit/{id}', ['as' => 'products_edit', 'uses' => 'EmployeeController@editProduct']);
        Route::get('warehouse_management', ['as' => 'warehouse', 'uses' => 'EmployeeController@warehouse']);
        Route::get('warehouse_management/restock/{id}', ['as' => 'warehouse_restock', 'uses' => 'EmployeeController@warehouseRestock']);
        Route::get('enterprise_contracts', ['as' => 'contracts', 'uses' => 'EmployeeController@contracts']);
        Route::get('enterprise_contracts/add', ['as' => 'contracts_add', 'uses' => 'EmployeeController@addContract']);
        Route::get('enterprise_contracts/{id}/document', ['as' => 'contract_documents', 'uses' => 'EmployeeController@document']);
        Route::get('accounting/sales', ['as' => 'accounting_sales', 'uses' => 'EmployeeController@accountingSales']);
        Route::get('accounting/expenses', ['as' => 'accounting_expenses', 'uses' => 'EmployeeController@accountingExpenses']);
        Route::get('accounting/income', ['as' => 'accounting_income', 'uses' => 'EmployeeController@accountingIncome']);
        Route::get('employees', ['as' => 'employees_view', 'uses' => 'EmployeeController@employees']);
        Route::get('employees/register', ['as' => 'employees_register', 'uses' => 'EmployeeController@registerEmployee']);
        Route::get('clients', ['as' => 'clients_view', 'uses' => 'EmployeeController@clients']);
        Route::get('company_clients/register', ['as' => 'company_clients_register', 'uses' => 'EmployeeController@registerCompanyClient']);
        Route::get('reports/sales', ['as' => 'reports_sales', 'uses' => 'EmployeeController@salesReport']);
        Route::get('reports/inventory', ['as' => 'reports_inventory', 'uses' => 'EmployeeController@inventoryReport']);
        Route::get('reports/delivery', ['as' => 'reports_delivery', 'uses' => 'EmployeeController@deliveryReport']);
        Route::get('reports/supplier', ['as' => 'reports_supplier', 'uses' => 'EmployeeController@supplierReport']);
        Route::get('reports/product_information', ['as' => 'reports_product_information', 'uses' => 'EmployeeController@productInformationReport']);
        Route::get('reports/generate/{type}', ['as' => 'reports_generate', 'uses' => 'EmployeeController@startGeneratingReport']);
        Route::get('reports/view/{type}/{file}', ['as' => 'reports_view', 'uses' => 'EmployeeController@viewReport']);
        Route::get('receipts/view/{id}', ['as' => 'receipts_view', 'uses' => 'EmployeeController@viewReceipt']);
        Route::get('help/employees', ['as' => 'help', 'uses' => 'EmployeeController@help']);
    });

    Route::group(['as' => 'post.'], function() {
        Route::post('dashboard', ['as' => 'index', 'uses' => 'EmployeeController@index']);
        Route::post('client_orders/confirm', ['as' => 'orders_confirm', 'uses' => 'EmployeeController@postConfirmOrder']);
        Route::post('client_orders/mark', ['as' => 'orders_mark', 'uses' => 'EmployeeController@postMarkOrder']);
        Route::post('client_orders/delete', ['as' => 'orders_delete', 'uses' => 'EmployeeController@postDeleteOrder']);
        Route::post('products_catalogue/add', ['as' => 'products_add', 'uses' => 'EmployeeController@postAddProduct']);
        Route::post('products_catalogue/edit/{id}', ['as' => 'products_edit', 'uses' => 'EmployeeController@postEditProduct']);
        Route::post('products_catalogue/delete', ['as' => 'products_delete', 'uses' => 'EmployeeController@postDeleteProduct']);
        Route::post('warehouse_management/restock/{id}', ['as' => 'warehouse_restock', 'uses' => 'EmployeeController@postWarehouseRestock']);
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
        Route::get('search', ['as' => 'search', 'uses' => 'ClientController@search']);
        Route::get('home', ['as' => 'index', 'uses' => 'ClientController@index']);
        Route::get('products', ['as' => 'products', 'uses' => 'ClientController@products']);
        Route::get('orders', ['as' => 'orders', 'uses' => 'ClientController@orders']);
        Route::get('return_products', ['as' => 'products_return', 'uses' => 'ClientController@returnProducts']);
        Route::get('return_products/{id}', ['as' => 'products_return_process', 'uses' => 'ClientController@returnProductsProcess']);
        Route::get('contracts', ['as' => 'contracts', 'uses' => 'ClientController@contracts']);
        Route::get('contracts/view/{code}', ['as' => 'contracts_view', 'uses' => 'ClientController@viewContract']);
        Route::get('help/clients', ['as' => 'help', 'uses' => 'ClientController@help']);
    });

    Route::group(['as' => 'post.'], function() {
        Route::post('orders/add', ['as' => 'orders_add', 'uses' => 'ClientController@postOrder']);
        Route::post('return_products/{id}', ['as' => 'products_return_process', 'uses' => 'ClientController@postReturnProductsProcess']);
    });
});

Route::group(['as' => 'profile.'], function() {
    Route::group(['as' => 'get.'], function() {
        Route::get('profile', ['as' => 'index', 'uses' => 'ProfileController@index']);
    });

    Route::group(['as' => 'post.'], function() {
        Route::post('profile/update/account', ['as' => 'update_account', 'uses' => 'ProfileController@postUpdateAccount']);
        Route::post('profile/update/password', ['as' => 'update_password', 'uses' => 'ProfileController@postUpdatePassword']);
        Route::post('profile/update/info', ['as' => 'update_info', 'uses' => 'ProfileController@postUpdateInfo']);
    });
});

Route::group(['as' => 'payments.'], function() {
    Route::group(['as' => 'get.'], function() {
        Route::get('payment/paypal/status/{tid?}', ['as' => 'paypal_status', 'uses' => 'PaymentController@payPalStatus']);
    });

    Route::group(['as' => 'post.'], function() {
        Route::post('payment/paypal/settle', ['as' => 'paypal_payment', 'uses' => 'PaymentController@postPayPalPayment']);
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
