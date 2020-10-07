<?php

Route::view('/', 'auth.login')->name('welcome');

Auth::routes();

Route::middleware(['auth'])->group(function() {
  Route::get('/dashboard', 'DashboardController@index')->name('app.dashboard');
  Route::get('/dashboard/general', 'DashboardController@generalDashboard')->name('user.dashboard');
  Route::get('/profile', 'DashboardController@profile')->name('user.profile');
  Route::post('/profile/avatar', 'DashboardController@avatar')->name('user.avatar');
  Route::put('/profile/{id}', 'DashboardController@updateProfile')->name('user.update.profile');

  Route::middleware('can:accountant.viewAny')->group(function() {
    Route::get('/account/ajax/load', 'InvoiceController@ajaxLoad')->name('ajax.accounts');
    Route::get('/account/overdue', 'InvoiceController@overdue')->name('account.overdue');
    Route::post('/account/status', 'InvoiceController@updateStatus')->name('account.update.status');
    Route::resource('/account', 'InvoiceController');
  });
  Route::middleware('can:customer.viewAny')->group(function() {
    Route::get('/customer/new/converted', 'CustomerController@newCustomers')->name('customer.new');
    Route::resource('/customer', 'CustomerController');
    Route::post('/prospect/feedback', 'ProspectController@feedback')->name('prospect.feedback');
    Route::get('/prospect/confirmed/{prospect}', 'ProspectController@confirmed')->name('prospect.confirmed');
    Route::resource('/prospect', 'ProspectController');
  });
  Route::middleware('can:technician.viewAny')->group(function() {
    Route::get('/technician/orders', 'VendorController@orders')->name('technician.orders');
    Route::post('/technician/update/status', 'VendorController@updateStatus')->name('technician.update.status');
    Route::resource('/technician', 'VendorController');
  });
  Route::middleware('can:manage-staff')->group(function() {
    Route::get('/staff/ajax/load', 'StaffController@ajaxLoad')->name('ajax.staff');
    Route::resource('/staff', 'StaffController');
    Route::get('/service/ajax/load', 'ServicesController@ajaxLoad')->name('ajax.services');
    Route::resource('/service', 'ServicesController');
  });
  Route::middleware('can:order.viewAny')->group(function() {
    Route::get('/order/placement/{customer}', 'OrderController@placement')->name('order.placement');
    Route::resource('/order', 'OrderController');
  });
  Route::middleware('can:manage.settings')->group(function() {
    Route::get('/setting/ajax/load', 'SettingController@ajaxLoad')->name('ajax.settings');
    Route::resource('/setting', 'SettingController');
    Route::resource('/payment-gateway', 'PaymentMethodController', ['except' => ['index','create','show','store','delete']]);
    Route::resource('/messaging', 'MessagingController', ['except' => ['index','create','show','store','delete']]);
    Route::get('/report/invoices/{type}/{from}/{to}', 'ReportController@exportInvoice')->name('report.export-invoices');
    Route::get('/report/customers/{from}/{to}', 'ReportController@exportCustomers')->name('report.export-customers');
    Route::get('/report/technicians/{from}/{to}/{name}', 'ReportController@exportVendors')->name('report.export-vendors');
    Route::resource('/report', 'ReportController', ['only' => ['index','store']]);
  });
});
