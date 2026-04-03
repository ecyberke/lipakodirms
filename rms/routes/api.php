<?php
// use PDF;

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
Route::post('/test', 'TestController@test');

Route::post('/confirm_payment_receipt', 'NotificationsController@confirmPaymentReceipt');
Route::post('/test_sms', 'NotificationsController@testSms');
Route::post('/sendRentDueSms', 'NotificationsController@sendRentDueSms');
Route::post('/carbon_test', 'NotificationsController@carbonTest');
Route::post('/viewpdf/{id}', 'NotificationsController@pdfTest');

//tenant and landlord documents
Route::get('/tenant_statement', 'DocController@tenant_statement');
Route::get('/agency_statement', 'DocController@agency_statement');
Route::get('/property_owner_statement', 'DocController@property_owner_statement');
Route::get('/all_tenants', 'DocController@all_tenants');
Route::post('/testGenerateUserAccountNumber', 'UtilController@testGenerateUserAccountNumber');
Route::post('/testInvoice', 'DocController@testInvoice');
Route::get('/testViewInvoic', 'DocController@testViewInvoicesss');

//mpesa routes
Route::post('/register_urls', 'MpesaController@registerUrl');
Route::post('/confirmation_url', 'MpesaController@confirmationUrl');
Route::post('/validation_url', 'MpesaController@validationUrl');
Route::get('/access', 'MpesaController@access_token');

//mpesa payments updater
Route::post('/sendRentOverdueSms', 'NotificationsController@sendRentOverdueSms');
Route::post('/sendRentAppeal', 'NotificationsController@sendRentAppeal');
Route::get('/text', 'NotificationsController@text');
Route::post('/updateUnpaidInvoices', 'NotificationsController@updateUnpaidInvoices');
Route::post('/correctPayments', 'NotificationsController@correctPayments');


//payment tests
Route::post('/invoice/payNow', 'InvoicesController@payInvoiceNow');
Route::post('/excelProcessor', 'MpesaController@excelProcessor');
