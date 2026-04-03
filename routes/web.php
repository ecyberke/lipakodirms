<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// General Routes
Route::get('/', 'HomeController@index')->name('home');
Route::get('/layout/side-menu', 'HomeController@side')->name('sidemenu');
//Receipts
Route::get('/receipt/{id}/index', 'ReceiptsController@receipts')->name('receipt.index');

//sms welcome message
Route::get('/tenant/{id}/welcome', 'TenantsController@welcome_sms')->name('sms.welcome');

// Agreements
Route::get('/tenant/{id}/lease', 'InvoicesController@leasepdfInvoice')->name('lease.pdf');

// chats

Route::get('/chat/email-compose', 'MessagesController@create')->name('email.create');
Route::get('/chat/edit', 'MessagesController@edit')->name('email.edit');
Route::post('/chat/store', 'MessagesController@store')->name('email.store');
Route::post('/chat/store-reply', 'MessagesController@storereply')->name('email.store-reply');
Route::get('/chat/email-inbox', 'MessagesController@index')->name('email.inbox');
Route::get('/chat/email-sent', 'MessagesController@sent')->name('email.sent');
Route::get('/chat/email-important', 'MessagesController@important')->name('email.important');
Route::get('/chat/{id}/email-read', 'MessagesController@show')->name('email.show');
Route::get('/chat/{id}/email-read-sent', 'MessagesController@showsent')->name('email.show-sent');
Route::get('/chat/{id}/email-read-reply', 'MessagesController@showreply')->name('email.show-reply');
Route::put('/chat/{id}/update', 'MessagesController@update')->name('email.update');
Route::delete('/chat/{id}/delete', 'MessagesController@delete')->name('email.delete');

//more reports
Route::get('/report/external_owner', 'ReportController@external_owner')->name('report.external_owner');
Route::get('/report/viewing_fee', 'ReportController@viewing_fee')->name('report.viewing_fee');
Route::get('/report/vacant_report', 'ReportController@vacantreport')->name('report.vacant_report');
Route::get('/report/apartmentReportGenerate', 'ReportController@apartmentReportGenerate')->name('report.apartmentReportGenerate');
Route::get('/report/occupied_report', 'ReportController@occupiedreport')->name('report.occupied_report');
Route::get('/report/notice_report', 'ReportController@noticereport')->name('report.notice_report');
Route::get('/report/tenant_balance', 'ReportController@tenantbalance')->name('report.tenant_balance');
Route::get('/report/all_tenants', 'ReportController@alltenants')->name('report.all_tenants');
Route::get('/report/all_owners', 'ReportController@allowners')->name('report.all_owners');
Route::get('/report/all_properties', 'ReportController@allproperties')->name('report.all_properties');
Route::get('/report/all_houses', 'ReportController@allhouses')->name('report.all_houses');
//end more reports

//end chats

Route::get('/report/tenantform', 'ReportController@tenantform')->name('report.tenantform');
Route::get('/report/houses_reports', 'ReportController@houses_reports')->name('report.houses_reports');
Route::get('/report/houses_reports_generate', 'ReportController@houses_reports_generate')->name('report.houses_reports_generate');
Route::get('/report/property_status', 'ReportController@property_status')->name('report.property_status');
Route::get('/report/property_status_report', 'DocController@property_status_report')->name('report.property_status_report');

Route::get('/report/agency_status', 'ReportController@agency_status')->name('report.agency_status');
Route::get('/report/agency_status_report', 'DocController@agency_status_report')->name('report.agency_status_report');


Route::get('/report/prop_income', 'ReportController@prop_income')->name('report.prop_income');
Route::get('/report/prop_income_report', 'DocController@all_property_report')->name('report.prop_income_report');

Route::get('/report/month_income', 'ReportController@month_income')->name('report.month_income');   

Route::get('/report/tenant_income', 'ReportController@tenant_income')->name('report.tenant_income');
Route::get('/report/tenant_income_report', 'DocController@all_tenant_report')->name('report.tenant_income_report');

Route::get('/report/tenant_month_income', 'ReportController@tenant_month_income')->name('report.tenant_month_income'); 

Route::get('/report/landlordform', 'ReportController@landlordform')->name('report.landlordform');
Route::get('/report/agencyform', 'ReportController@agencyform')->name('report.agencyform');
Route::get('/report/preprintedform', 'ReportController@preprintedform')->name('report.preprintedform');
Route::get('tenant_statement', 'DocController@tenant_statement')->name('tenant_statement');
Route::get('/agency_statement', 'DocController@agency_statement')->name('agency_statement');
Route::get('/property_owner_statement', 'DocController@property_owner_statement')->name('property_owner_statement');
Route::get('/all_tenants', 'DocController@all_tenants')->name('all_tenants');

Route::get('/report/tenant', 'ReportController@index')->name('report.tenant');
Route::get('/report/owner', 'ReportController@landlord')->name('report.landlord');
Route::get('/report/tenant_show', 'ReportController@show')->name('report.tenant_show');
//Route::get('/tenant/{idd}/report', 'TenantsController@report')->name('tenant.report');
Route::get('/owner/{id}/report', 'ReportController@report')->name('landlord.report');
Route::get('/servicerequest/{id}/report', 'ServiceRequestsController@report')->name('servicerequests.report');
Route::get('/report/agencyunpaidreport', 'ReportController@unpaid')->name('report.agencyunpaidreport');
Route::get('/report/agencypaidreport', 'ReportController@paid')->name('report.agencypaidreport');
//Tenants Manipulation
Route::get('/houseviewing/create', 'TenantsController@houseview')->name('houseviewing.create');
Route::post('/houseviewing/store', 'TenantsController@houseviewingstore')->name('houseviewing.store');
Route::get('/houseviewing/list', 'TenantsController@houseview_list')->name('houseviewing.list');
Route::get('/tenant/create', 'TenantsController@create')->name('tenant.create');
Route::post('/tenant/store', 'TenantsController@store')->name('tenant.store');
Route::post('/tenant/contract', 'TenantsController@contract')->name('tenant.contract');
Route::get('/tenant/{idd}/show', 'TenantsController@show')->name('tenant.show');
Route::get('/tenant/{idd}/report', 'TenantsController@report')->name('tenant.report');
Route::delete('/tenant/{idd}/delete', 'TenantsController@destroy')->name('tenant.delete');
Route::get('/tenant/{idd}/edit', 'TenantsController@edit')->name('tenant.edit');
Route::get('/tenant/{id}/assignRoomedit', 'TenantsController@assignRoomedit')->name('tenant.assignRoomedit');
Route::put('/tenant/{idd}/update', 'TenantsController@update')->name('tenant.update');
Route::get('/tenant/all', 'TenantsController@list')->name('tenant.all');

Route::get('/tenant/assignroom/{id?}', 'TenantsController@assignRoom')->name('tenant.assign_room');
Route::get('/houseviewing/assignroom/', 'TenantsController@assignp_tenantRoom')->name('houseviewing.assign_room');

Route::get('/tenant/{house_id}/change_room', 'TenantsController@changeRoom')->name('tenant.change_room');
Route::post('/tenant/changehouse', 'TenantsController@changeHouse')->name('tenant.change');

Route::post('/tenant/allocatehouse', 'TenantsController@allocateHouse')->name('tenant.allocate');
Route::post('/houseviewing/allocatehouse', 'TenantsController@allocatep_tenantHouse')->name('p_tenant.allocate');
Route::post('/tenant/{id}/updateallocateHouse', 'TenantsController@updateallocateHouse')->name('tenant.updateallocateHouse');

Route::get('/tenant/{idd}/deposit_refund', 'TenantsController@deposit_refund')->name('tenant.deposit_refund');
Route::post('/tenant/{idd}/deposit_refund_store', 'TenantsController@deposit_refund_store')->name('tenant.deposit_refund_store');
Route::get('/tenant/{id}/pay_bill', 'TenantsController@payBill')->name('tenant.pay');
Route::post('/tenant/{id}/payNowadmin', 'TenantsController@payInvoiceNowadmin')->name('tenant.payNowadmin');
Route::get('/tenant/{id}/tenant_invoice_view/{action?}', 'TenantsController@showBill')->name('tenant.tenant_bill.show');

Route::get('/tenant/{id}/missingInvoices', 'TenantsController@missingInvoices')->name('tenant.missingInvoices');
Route::get('/tenant/{idd}/changepassword', 'TenantsController@showPasswordForm')->name('tenant.changepassword');
Route::put('/tenant/{idd}/updatepassword', 'TenantsController@updatePassword')->name('tenant.updatepassword');
Route::delete('/tenant/{house_id}/vacate', 'TenantsController@vacateHouse')->name('tenant.vacate');

Route::get('/tenant/{house_id}/vacate1', 'TenantsController@vacateHouse')->name('tenant.vacate1');
Route::get('/doc/preprinted', 'DocController@preprinted')->name('doc.preprinted');

//Income Manipulation
Route::get('/income/index', 'IncomesController@index')->name('incomes.index');
Route::get('/income/create', 'IncomesController@create')->name('incomes.create');
Route::post('/income/store', 'IncomesController@store')->name('incomes.store');

//Service Requests Manipulation

Route::get('/servicerequest/index', 'ServiceRequestsController@index')->name('servicerequests.index');
Route::get('/servicerequest/create', 'ServiceRequestsController@create')->name('servicerequests.create');
Route::get('/servicerequest/{id}/edit', 'ServiceRequestsController@edit')->name('servicerequests.edit');
Route::get('/servicerequest/{id}/show', 'ServiceRequestsController@show')->name('servicerequests.show');
Route::put('/servicerequest/{id}/update', 'ServiceRequestsController@update')->name('servicerequests.update');
Route::post('/servicerequest/store', 'ServiceRequestsController@store')->name('servicerequests.store');
Route::delete('/servicerequest/{id}/delete', 'ServiceRequestsController@delete')->name('servicerequests.delete');

//Expenses Manipulation

// Route::get('/expense/index', 'ExpensesController@index')->name('expenses.index');
Route::get('/expense/property', 'ExpensesController@property')->name('expenses.property');
Route::get('/expense/agency', 'ExpensesController@agency')->name('expenses.agency');
Route::get('/expense/bills', 'ExpensesController@index')->name('expenses.bills');


//demo request
Route::get('/demo_request', 'DemoController@create')->name('demo.create');
Route::post('/demo_request/store', 'DemoController@store')->name('demo.store');

// Route::get('/expense/{request_id}/edit', 'ExpensesController@edit')->name('expenses.edit');
// Route::put('/expense/{request_id}/update', 'ExpensesController@update')->name('expenses.update');
// Route::post('/expense/store', 'ExpensesController@store')->name('expenses.store');
// Route::get('/expense/{request_id}/delete', 'ExpensesController@delete')->name('expenses.delete');

//Agency Expenses Manipulation

// Route::get('/agencyexpense/index', 'AgencyExpensesController@index')->name('agencyexpenses.index');
// Route::get('/agencyexpense/create', 'AgencyExpensesController@create')->name('agencyexpenses.create');
// Route::get('/agencyexpense/{id}/edit', 'AgencyExpensesController@edit')->name('agencyexpenses.edit');
// Route::put('/agencyexpense/{id}/update', 'AgencyExpensesController@update')->name('agencyexpenses.update');
// Route::post('/agencyexpense/store', 'AgencyExpensesController@store')->name('agencyexpenses.store');
// Route::delete('/agencyexpense/{id}/delete', 'AgencyExpensesController@delete')->name('agencyexpenses.delete');
Route::post('/expense/agency', 'AgencyExpensesController@create')->name('expenses.create');
Route::post('/expense/store', 'AgencyExpensesController@store')->name('expenses.store');
Route::get('/expense/list', 'AgencyExpensesController@index')->name('expenses.list');
Route::get('/expense/{id}/edit', 'AgencyExpensesController@edit')->name('expenses.edit');
Route::put('/expense/{id}/update', 'AgencyExpensesController@update')->name('expenses.update');
Route::delete('/expense/{id}/delete', 'AgencyExpensesController@delete')->name('expenses.delete');
//LandLords manipulation
Route::get('/owner/create', 'LandLordsController@create')->name('landlord.create');
Route::get('/owner/list', 'LandLordsController@index')->name('landlord.index');
Route::get('/owner/client', 'clientController@index')->name('client.index');
Route::post('/owner/store', 'LandLordsController@store')->name('landlord.store');
Route::get('/owner/{id}/show', 'LandLordsController@show')->name('landlord.show');
Route::get('/owner/{id}/edit', 'LandLordsController@edit')->name('landlord.edit');
Route::put('/owner/{id}/update', 'LandLordsController@update')->name('landlord.update');
Route::get('/owner/{id}/changepassword', 'LandLordsController@showPasswordForm')->name('landlord.changepassword');
Route::put('/owner/{id}/updatepassword', 'LandLordsController@updatePassword')->name('landlord.updatepassword');
Route::delete('/owner/{id}/delete', 'LandLordsController@delete')->name('landlord.delete');

//Apartments Manipulation
Route::get('/apartment/create/{id?}', 'ApartmentsController@create')->name('apartment.create');
Route::post('/apartment/store', 'ApartmentsController@store')->name('apartment.store');
Route::get('/apartment/list', 'ApartmentsController@list')->name('apartment.list');
Route::get('/apartment/{id}/show', 'ApartmentsController@show')->name('apartment.show');
Route::get('/apartment/{id}/edit', 'ApartmentsController@edit')->name('apartment.edit');
Route::put('/apartment/{id}/update', 'ApartmentsController@update')->name('apartment.update');
Route::delete('/apartment/{id}/delete', 'ApartmentsController@delete')->name('apartment.delete');

//House Manipulation
Route::get('/house/create/{id?}', 'HousesController@create')->name('apartment.add_unit');
Route::post('/house/store', 'HousesController@store')->name('apartment.store_unit');
Route::post('/filemanager/store', 'FileManagerController@store')->name('filemanager.store');
Route::get('/house/list', 'HousesController@index')->name('house.list');
Route::get('/house/vacant', 'HousesController@listVacant')->name('house.vacant');
Route::get('/house/occupied', 'HousesController@listOccupied')->name('house.occupied');
Route::get('/house/{id}/edit', 'HousesController@edit')->name('house.edit');
Route::put('/house/{id}/update', 'HousesController@update')->name('house.update');
Route::delete('/house/{id}/delete', 'HousesController@destroy')->name('house.delete');
Route::get('/house/unpaid', 'HousesController@listUnpaid')->name('house.unpaid');
Route::get('/house/{id}/show', 'HousesController@show')->name('house.show');

//Deposits Manipulation
Route::get('/deposit/list', 'DepositsController@index')->name('deposit.list');
Route::get('/deposit/apartment', 'DepositsController@sumByApartments')->name('deposit.apartment');
Route::get('/deposit/sort_apartment', 'DepositsController@sortByApartments')->name('deposit.sort');
Route::get('/deposit/{id}/edit', 'DepositsController@edit')->name('deposit.edit');
Route::put('/deposit/{id}/update', 'DepositsController@update')->name('deposit.update');
Route::delete('/deposit/{id}/delete', 'DepositsController@delete')->name('deposit.delete');

//Placement Fees Manipulation
Route::get('/placementfee/apartment', 'PlacementFeesController@sumByApartments')->name('placementfee.apartment');
Route::get('/placementfee/sort_apartment', 'PlacementFeesController@sortByApartments')->name('placementfee.sort');
Route::get('/placementfee/{id}/edit', 'PlacementFeesController@edit')->name('placementfee.edit');
Route::put('/placementfee/{id}/update', 'PlacementFeesController@update')->name('placementfee.update');
Route::delete('/placementfee/{id}/delete', 'PlacementFeesController@delete')->name('placementfee.delete');

//Overpayment Manipulation
Route::get('overpayment/{id}/edit', 'OverpaymentController@edit')->name('overpayment.edit');
Route::put('overpayment/{id}/update', 'OverpaymentController@update')->name('overpayment.update');
Route::delete('overpayment/{id}/delete', 'OverpaymentController@delete')->name('overpayment.delete');

//Invoices Synch
Route::get('/make-synch', function () {Artisan::call('invoices:synchronize');
    //return redirect()->route('house.list')->with('success', '');
    // return back()->with('success', 'Invoice is successfully generated');
});
//Invoices Manipulation
Route::get('/make-invoice', function () {Artisan::call('invoice:initialize');
    //return redirect()->route('house.list')->with('success', '');
    return back()->with('success', 'Invoice is successfully generated');
});
//SMS TEST
Route::get('/send-sms', function () {Artisan::call('sms:test');
    //return redirect()->route('house.list')->with('success', '');
    return back()->with('success', 'Sms sent successfully');
});
Route::get('/update_collection', function () {Artisan::call('invoices:updaterentcollection');
    //return redirect()->route('house.list')->with('success', '');
    return back()->with('success', 'Rent Collection updated successfully');
});
Route::get('/rent-collection', function () {Artisan::call('owner:pay');
    //return redirect()->route('house.list')->with('success', '');
    return back()->with('success', 'Rent Collections are successfully generated');
});
Route::get('penalize-invoice', function () {Artisan::call('invoice:penalize');
    return redirect()->route('invoice.all')->with('success', 'Unpaid Invoices Penalized');
//  return back()->with('success', 'Invoice has been deleted');
});
Route::get('/payowner/{id}/pay', 'PayOwnersController@payowners')->name('payowner.pay');
Route::delete('/payowner/{id}/delete', 'PayOwnersController@destroy')->name('payowner.delete');
Route::post('/payowner/{id}/update', 'PayOwnersController@update')->name('payowner.update');
Route::get('/payowner/{id}/show', 'PayOwnersController@show')->name('payowner.show');
Route::get('/payowner/{id}/edit', 'PayOwnersController@edit')->name('payowner.edit');
Route::get('/invoice/{id}/edit', 'InvoicesController@edit')->name('invoice.edit');
Route::get('/manualinvoice/{id}/paymentedit', 'ManualInvoiceController@paymentedit')->name('managerpayment.edit');
Route::get('/manualinvoice/{id}/rerouting', 'ManualInvoiceController@accountedit')->name('invoice.accountedit');
Route::post('/manualinvoice/{id}/accountupdate', 'ManualInvoiceController@accountupdate')->name('invoice.accountupdate');
Route::post('/invoice/{id}/update', 'InvoicesController@update')->name('invoice.update');
Route::get('/invoice/prepare', 'InvoicesController@prepare')->name('invoice.prepare');
Route::get('/invoice/create', 'InvoicesController@create')->name('invoice.create');
Route::post('/mothlybills/store', 'InvoicesController@storeMonthlyBilling')->name('monthlybills.store');
Route::post('/invoice/store', 'InvoicesController@store')->name('invoice.store');
Route::delete('/monthlybill/delete', 'InvoicesController@deleteMonthlyBill')->name('monthlybills.delete');
Route::get('/invoice/{month}/initialize', 'InvoicesController@initializeInvoice')->name('invoice.initialize');
Route::get('/invoice/all', 'InvoicesController@listAll')->name('invoice.all');
Route::get('/invoice/{month}/all', 'InvoicesController@showForSpecificMonth')->name('invoice.month');
Route::get('/invoice/{month}/penalize', 'InvoicesController@incurPenaltyCharges')->name('invoice.penalize');
Route::get('/invoice/unpaid', 'InvoicesController@listUnpaid')->name('invoice.unpaid');
Route::get('/invoice/paid', 'InvoicesController@listpaid')->name('invoice.paid');
Route::get('/invoice/{id}/pay', 'InvoicesController@payInvoice')->name('invoice.pay');
Route::post('/invoice/payNow', 'InvoicesController@payInvoiceNow')->name('invoice.payNow');
Route::post('/invoice/payNowadmin', 'InvoicesController@payInvoiceNowadmin')->name('invoice.payNowadmin');

Route::post('/manualinvoice/{id}/payInvoiceNowupdate', 'InvoicesController@payInvoiceNowupdate')->name('invoice.payInvoiceNowupdate');
Route::post('/bill/payNow', 'BillsController@payNow')->name('bill.payNow');
Route::post('/bill/payManagerNow', 'BillsController@payManagerNow')->name('bill.payManagerNow');
Route::post('/payowner/{id}/payNowUpdate', 'BillsController@payNowUpdate')->name('payowner.payNowUpdate');
Route::get('/payowner/{id}/paymentedit', 'BillsController@paymentedit')->name('managerbillpayment.edit');
Route::post('/invoice/reconcile', 'InvoicesController@reconcileInvoicePayment')->name('invoice.reconcile');
Route::get('/invoice/overpayments', 'InvoicesController@showOverpayments')->name('invoice.overpayments');
Route::get('/invoice/{id}/show/{action?}', 'InvoicesController@showInvoice')->name('invoice.show');
Route::get('/invoice/{id}/pdf', 'InvoicesController@pdfInvoice')->name('invoice.pdf');
Route::delete('/invoice/{id}/delete', 'InvoicesController@delete')->name('invoice.delete');
Route::delete('/manualinvoice/{id}/paymentdelete', 'ManualInvoiceController@paymentdelete')->name('managerpayment.delete');
Route::delete('/bill/{id}/paymentdelete', 'BillsController@paymentdelete')->name('managerbillpayment.delete');




//payowners
Route::get('/payowner/list', 'PayOwnersController@list')->name('payowners.list');
Route::get('/payowner/totals', 'PayOwnersController@totals')->name('payowners.totals');
Route::get('/payowner/{id}/pay', 'PayOwnersController@payowners')->name('payowners.pay');
Route::post('/payowner/payment', 'PayOwnersController@pay')->name('payowners.payment');

//sms
Route::get('/sms/custom', 'SmsController@custom')->name('sms.custom');
Route::get('/sms/sendSms', 'SmsController@sendSms')->name('sms.sendSms');
Route::post('/sms/automatedSms', 'SmsController@automatedSms')->name('sms.automatedSms');
// Route::get('/sms/owners', 'SmsController@owners')->name('sms.owners');
// Route::get('/sms/individual', 'SmsController@individual')->name('sms.individual');
// Route::get('/sms/failed', 'SmsController@failed')->name('sms.failed');
Route::get('/sms/list', 'SmsController@list')->name('sms.list');

//bills
Route::get('/bill/create', 'BillsController@create')->name('bill.create');
Route::get('/bill/pay', 'BillsController@pay')->name('bill.pay');
Route::get('/bill/list', 'BillsController@list')->name('bill.list');
Route::post('/bill/store', 'BillsController@store')->name('bill.store');
Route::get('/bill/pay', 'BillsController@pay')->name('bill.pay');
Route::get('/bill/payments', 'BillsController@payments')->name('bill.payments');
Route::get('/bill/paymentlist', 'BillsController@paymentlist')->name('bill.paymentlist');

//manualinvoice
Route::get('/manualinvoice/create', 'ManualInvoiceController@create')->name('manualinvoice.create');
Route::get('/manualinvoice/pay', 'ManualInvoiceController@pay')->name('manualinvoice.pay');
Route::get('/manualinvoice/payments', 'ManualInvoiceController@payments')->name('manualinvoice.payments');
Route::get('/manualinvoice/paymentlist', 'ManualInvoiceController@paymentlist')->name('manualinvoice.paymentlist');
Route::delete('/manualinvoice/{id}/delete', 'ManualInvoiceController@destroy')->name('manualinvoice.delete');
Route::get('/manualinvoice/list', 'ManualInvoiceController@list')->name('manualinvoice.list');
Route::post('/manualinvoice/store', 'ManualInvoiceController@store')->name('manualinvoice.store');

//filemanager
Route::get('/filemanager/index', 'FileManagerController@index')->name('filemanager.index');
Route::get('/filemanager/recent', 'FileManagerController@recent')->name('filemanager.recent');
Route::get('/filemanager/images', 'FileManagerController@images')->name('filemanager.images');
Route::get('/filemanager/contract', 'FileManagerController@contract')->name('filemanager.contract');
Route::get('/filemanager/download', 'FileManagerController@download')->name('filemanager.download');
Route::post('/filemanager/delete_file/{id?}/{file?}', 'FileManagerController@delete_file')->name('filemanager.delete_file');

//softdeletes
Route::get('/softdeletes/index', 'UtilController@softdeletes')->name('softdeletes.index');
Route::delete('/softdeletes/delete/{table}/{id}', 'UtilController@delete_soft')->name('softdeletes.delete');
Route::get('/softdeletes/restore/{table}/{id}', 'UtilController@restore_soft')->name('softdeletes.restore');


//logs
Route::get('/logs/index', 'UtilController@logs')->name('logs.index');

//Incomes
Route::get('/income/company', 'IncomeController@companyIncome')->name('income.company');
Route::get('/income/landlord', 'IncomeController@landlordIncome')->name('income.landlord');
Route::post('/incomes/company', 'IncomeController@getAllIncomes')->name('income.all');
Route::post('/incomes/landlord', 'IncomeController@computeLandlordIncome')->name('incomes.landlord');

// Datatables Listings
Route::get('/tenants/list', 'ApiController@getActiveTenants')->name('tenants.list');
Route::get('/reports/tenant', 'ApiController@getTenantsReport')->name('tenants.report');
Route::get('/landlords/list', 'ApiController@getAllLandlords')->name('api.landlord.list');
Route::get('/reports/landlord', 'ApiController@getAllLandlordsReport')->name('api.landlord.report');
Route::get('/apartments/list', 'ApiController@getAllApartments')->name('api.apartment.list');
Route::get('/houses/list', 'ApiController@getAllApartmentsHouses')->name('api.house.list');
Route::get('/servicerequests/index', 'ApiController@getAllServiceRequests')->name('api.service.request');
Route::get('/expenses/index', 'ApiController@getAllAgencyExpenses')->name('api.expenses.agency');
Route::get('/expenses/bills', 'ApiController@getAllServiceBills')->name('api.bills.list');
Route::get('/chats/email-inbox', 'ApiController@getAllInbox')->name('api.chats.email-inbox');
Route::get('/chats/email-sent', 'ApiController@getAllSent')->name('api.chats.email-sent');
Route::get('/chats/email-important', 'ApiController@getAllImportant')->name('api.chats.email-important');
Route::get('/houses/vacant', 'ApiController@getVacantHouses')->name('api.house.vacant');
Route::get('/houses/occupied', 'ApiController@getOccupiedHouses')->name('api.house.occupied');
Route::get('/houses/occupy', 'ApiController@getOccupiedHousess')->name('api.house.occupiedd');
Route::get('/deposits/list', 'ApiController@getAllDeposits')->name('api.deposits.list');
Route::get('/deposits/sum', 'ApiController@sumApartmentsDepositMonthly')->name('api.deposits.sum');
Route::get('/placementfees/sum', 'ApiController@sumApartmentPlacementFeesByApartment')->name('api.placementfee.sum');
Route::get('/placementfees/sort', 'ApiController@getPlacementFeesPerApartment')->name('api.placementfee.sort');
Route::get('/invoices/list', 'ApiController@getInvoices')->name('api.invoice.list');
Route::get('/houseview/list', 'ApiController@getTemp')->name('api.temp.list');
Route::get('/invoices/paid', 'ApiController@getpaidInvoices')->name('api.invoice.paid');

Route::get('/payowners/list', 'ApiController@getPayowners')->name('api.payowners.list');
Route::get('/manualinvoices/payments', 'ApiController@getAllPayments')->name('api.payments.list');
Route::get('/manualinvoices/paymentlist', 'ApiController@getAllManagerPayments')->name('api.paymentsmanager.list');
Route::get('/bills/payments', 'ApiController@getAllBillPayments')->name('api.billpayments.list');
Route::get('/bills/paymentlist', 'ApiController@getAllManagerBillPayments')->name('api.billpaymentsmanager.list');
Route::get('/payowners/totals', 'ApiController@getPayownerstotals')->name('api.payowners.totals');
Route::get('/invoices/{month}/monthlylist', 'ApiController@getInvoices')->name('api.invoice.monthly');
Route::get('/invoices/listunpaid', 'ApiController@getUnpaidInvoices')->name('api.invoice.unpaid');
Route::get('/invoices/overpayment', 'ApiController@getAllOverpayments')->name('api.invoice.overpayment');
Route::get('/apartment/{id}/houses', 'ApiController@getApartmentHouses')->name('api.apartment.houses');
Route::get('/apartment/houses', 'ApiController@apartmentHouses')->name('api.houses.apartment');
Route::get('/logs/index3', 'ApiController@getApartmentlogs')->name('api.apartments.logs');
Route::get('/logs/index1', 'ApiController@getTenantslogs')->name('api.tenants.logs');
Route::get('/logs/index6', 'ApiController@getServicerequestlogs')->name('api.servicerequests.logs');
Route::get('/logs/index4', 'ApiController@getOwnerslogs')->name('api.owners.logs');
Route::get('/logs/index5', 'ApiController@getHouselogs')->name('api.houses.logs');
Route::get('/logs/index7', 'ApiController@getBillslogs')->name('api.bills.logs');
Route::get('/logs/index8', 'ApiController@getInvoiceslogs')->name('api.invoices.logs');
Route::get('/logs/index9', 'ApiController@getSmslogs')->name('api.sms.logs');
Route::get('/logs/index10', 'ApiController@getUserslogs')->name('api.users.logs');
Route::get('/logs/index2', 'ApiController@getAlllogs')->name('api.alll.logs');
Route::get('/softdeletes/index0', 'ApiController@houses_trashed')->name('api.houses.trashed');
Route::get('/softdeletes/index1', 'ApiController@invoices_trashed')->name('api.invoices.trashed');
Route::get('/softdeletes/index2', 'ApiController@landlord_trashed')->name('api.landlord.trashed');
Route::get('/softdeletes/index3', 'ApiController@apartments_trashed')->name('api.apartments.trashed');
Route::get('/softdeletes/index4', 'ApiController@tenants_trashed')->name('api.tenants.trashed');
Route::get('/softdeletes/index5', 'ApiController@bills_trashed')->name('api.bills.trashed');
Route::get('/softdeletes/index6', 'ApiController@user_trashed')->name('api.systemuser.trashed');

// Basic Ajax Calls
Route::post('/ajax/houses', 'ApiController@getHouseTypes')->name('ajax.houses.filter');
Route::post('/ajax/tenants', 'ApiController@getTenantsSelect')->name('ajax.tenant.filter');
Route::post('/ajax/occupied', 'ApiController@getOccupied')->name('ajax.houses.occupied');
Route::post('/ajax/house_bills', 'ApiController@getRequiredBills')->name('ajax.house.bills');
Route::post('/ajax/house_tenants', 'ApiController@geTtenantsFromHouse')->name('ajax.house.tenant');
Route::post('/ajax/tenant_id', 'ApiController@getTenantDetails')->name('ajax.tenant.details');
Route::get('/ajax/sort_apartments', 'ApiController@getDepositsPerApartment')->name('ajax.sort.apartment');
Route::post('/ajax/monthly_bills', 'ApiController@getHouseMothlyBills')->name('ajax.house.monthlybills');
Route::post('/ajax/tenant/validate', 'ApiController@validateTenantExistence')->name('ajax.tenant.validate');
Route::post('/invoice/create', 'ApiController@populateTenantInvoice')->name('ajax.invoicepopulate');
Route::post('/ajax/expense/validate', 'ApiController@populatingExpenses')->name('ajax.expense.validate');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//Tenant Logins Routes
Route::get('tenant-login', 'Auth\TenantLoginController@showLoginForm');
Route::post('tenant-login', 'Auth\TenantLoginController@login')->name('tenant.login');
Route::get('tenant-logout', 'Auth\TenantLoginController@logout')->name('tenant.logout');

//Landlord Logins routes
Route::get('landlord-login', 'Auth\LandlordLoginController@showLoginForm');
Route::post('landlord-login', 'Auth\LandlordLoginController@login')->name('landlord.login');
Route::get('landlord-logout', 'Auth\LandlordLoginController@logout')->name('landlord.logout');

//User Tenant
Route::get('tenant', 'UserTenantController@index')->name('tenant-home');

//User Landlord
Route::get('landlord', 'UserLandlordController@index')->name('landlord-home');

//User Administrators
Route::get('/admin', 'UserController@index')->name('admin.index');
Route::get('/admin/notification', 'UserController@notification')->name('admin.notification');
Route::get('/admin/create', 'UserController@create')->name('admin.create');
Route::get('/admin/{id}/edit', 'UserController@edit')->name('admin.edit');
Route::get('/admin/{id}/editpassword', 'UserController@editpassword')->name('admin.editpassword');
Route::put('/admin/{id}/update', 'UserController@update')->name('admin.update');
Route::put('/admin/{id}/updatepass', 'UserController@updatepass')->name('admin.updatepass');
Route::post('/admin/store', 'UserController@store')->name('admin.store');
Route::delete('/admin/{id}/delete', 'UserController@destroy')->name('admin.delete');
Route::post('/admin/{id}/toggle', 'UserController@changeRole')->name('admin.toggleRole');
Route::get('/admin/changepassword', 'UserController@changePassword')->name('admin.changepassword');
Route::put('/admin/updatepassword', 'UserController@updatePassword')->name('admin.updatepassword');

//Sms Test
Route::get('/rent-due', function () {Artisan::call('sms:rentdue');
    //return redirect()->route('house.list')->with('success', '');
    return response(['message'=>'Success rent due'],200);
});
Route::get('/rent-overdue', function () {Artisan::call('sms:rentoverdue');
    //return redirect()->route('house.list')->with('success', '');
    return response(['message'=>'Success rent overdue'],200);
});
