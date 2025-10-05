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

use App\Http\Controllers\VerifyController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// use mikehaertl\pdftk\Pdf;
// use FPDM;

// ** INIT BOOKING ** //

Route::get('/', 'UserBookingController@loadBooking')->name('index');
Route::get('/ajax_package_info', 'UserBookingController@ajaxPackageInfo');

// Language Changes
Route::get('/lang/{lang}', function ($lang) {

    \Request::session()->put('lang', $lang);

    return redirect()->back();
})->name('lang');

Auth::routes(['verify' => true]);


// ** DASHBOARD ROUTE ** //

Route::get('/home', 'HomeController@index')->name('home');

// data privacy policy route
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

// ** AJAX REQUESTS ** //
Route::post('/get_packages', 'UserBookingController@getPackages')->name('packages');
Route::post('/get_timing_slots', 'UserBookingController@getTimingSlots')->name('slots');
Route::post('/get_update_slots', 'UserBookingController@getUpdateSlots')->name('updateSlots');
Route::post('/remove_session_addon', 'UserBookingController@removeFromList');

// route for postalcodes
Route::get('/postal-codes', 'PostalCodeController@postalCodeList')->name('postal-codes.list');

// ** USER ROLE ADMIN ROUTES ** //

Route::group(['middleware' => ['admin', 'verified']], function () {

    Route::get('/users/d-table', 'AdminUsersController@dataTable')->name('users.data');
    Route::get('/users/verify/{user}', 'AdminUsersController@verify')->name('users.manualVerify');
    Route::get('/users/reset/{user}', 'AdminUsersController@reset')->name('users.reset');
    Route::post('/users/roles/assign/{role}', 'RolesController@assign')->name('roles.assign');
    Route::delete('/users/roles/revoke/{role}', 'RolesController@revoke')->name('roles.revoke');
    Route::resource('/users/roles', 'RolesController');
    Route::resource('/users', 'AdminUsersController');

    Route::get('/postal/d-table', 'Post\PostalPackageController@dataTable')->name('postal.data');
    Route::get('/postal/new/{type}{model}', 'Post\PostalPackageController@new')->name('postal.new');
    Route::get('/postal/import/{booking}', 'Post\PostalPackageController@import')->name('postal.import');
    Route::post('/postal/reject/{postal}', 'Post\PostalPackageController@reject')->name('postal.reject');
    Route::get('/postal/existing/{type}{model}', 'Post\PostalPackageController@existing')->name('postal.existing');
    Route::resource('/postal', 'Post\PostalPackageController');

    Route::resource('/categories', 'AdminCategoriesController');
    Route::resource('/packages', 'AdminPackagesController');
    Route::get('/packages/{package}/pdf', 'AdminPackagesController@pdf')->name('packages.pdf');
    Route::resource('/addons', 'AdminAddonsController');
    Route::resource('/settings', 'AdminSettingsController');
    Route::resource('/booking-times', 'AdminBookingTimesController');

    Route::get('/bookings/d-table', 'AdminBookingsController@dataTable')->name('bookings.data');
    Route::resource('/bookings', 'AdminBookingsController');
    Route::resource('/invoice', 'AdminInvoicesController');
    Route::resource('/cancel-requests', 'CancelRequestController');
    Route::post('/cancel-booking/{id}', 'AdminBookingsController@cancel')->name('cancelBooking');
    Route::patch('/updateBooking/{id}', 'AdminBookingsController@update_booking_time')->name('updateBookingTime');

    //database update controller

    Route::get('/update-database', 'DatabaseUpdateController@update');
    Route::get('/unpaid-invoices', 'OfflinePaymentController@index')->name('unpaidInvoices');

    Route::resource('/holidays', 'HolidaysController');

    Route::group(['prefix' => 'tracing'], function () {
        Route::get('/docs/table', 'Tracing\DocumentController@dataTable')->name('docs.data');
        Route::resource('/docs', 'Tracing\DocumentController');

        Route::get('/passport/import', 'Tracing\PassportController@import')->name('passport.import');
        Route::get('/passport/filter', 'Tracing\PassportController@filter')->name('passport.filter');
        Route::get('/passport/import-progress', function () {
            return response()->json([
                'status' => session('progressCount') > 0 ? 'Importing Excel' : 'Uploading File',
                'importedCount' => session('progressCount'),
                'importedTotalCount' => session('totalCount'),
            ]);
        })->name('passport.import-progress');
        // Route::get('/passport/import-progress', 'Tracing\PassportController@impProgressStatus')->name('passport.import-progress');
        Route::get('/passport/table', 'Tracing\PassportController@dataTable')->name('passport.data');
        Route::resource('/passport', 'Tracing\PassportController');

        //Miscellaneous routes
        Route::get('/misc/import/{booking}', 'Tracing\MiscellaneousController@import')->name('misc.import');
        Route::resource('/misc/misc-types', 'Tracing\MiscTypeController');
        Route::get('/misc/table', 'Tracing\MiscellaneousController@dataTable')->name('misc.data');
        Route::get('/misc/status/{misc}', 'Tracing\MiscellaneousController@changeStatus')->name('misc.status');
        Route::post('/misc/status/{misc}', 'Tracing\MiscellaneousController@status')->name('misc.changeStatus');
        Route::resource('/misc', 'Tracing\MiscellaneousController');
    });

    Route::group(['prefix' => 'visa'], function () {

        Route::post('/approve/{visa_form}', 'Visa\VisaFormController@approve')->name('visa.approve');
        Route::post('/reject/{visa_form}', 'Visa\VisaFormController@reject')->name('visa.reject');
        Route::get('/visa-form/d-table', 'Visa\VisaFormController@dataTable')->name('visa-form.data');
        Route::resource('/visa-form', 'Visa\VisaFormController');
    });
});

// ** USER ROLE CUSTOMER ROUTES ** //

Route::group(['middleware' => ['customer', 'verified']], function () {

    Route::get('/customer/bookings', 'UserBookingController@index')->name('customerBookings');
    Route::get('/customer/booking/{id}', 'UserBookingController@show')->name('showBooking');
    Route::get('/customer/invoices', 'CustomerInvoiceController@index')->name('customerInvoices');
    Route::get('/customer/invoice/{id}', 'CustomerInvoiceController@show')->name('showInvoice');
    Route::get('/customer/profile', 'CustomerProfileController@index')->name('customerProfile');
    Route::patch('/customer/{id}', 'CustomerProfileController@update')->name('customerUpdate');
    Route::post('/cancel-request', 'CancelRequestController@store')->name('cancelRequest');
    Route::get('/update-booking/{id}', 'UserBookingController@update')->name('updateBooking');
    Route::patch('/booking/{id}', 'UserBookingController@update_booking')->name('postUpdateBooking');
});

// ** COMMON ROUTES FOR AUTHENTICATED USERS ** //

Route::group(['middleware' => ['authenticated', 'verified']], function () {

    // ** BOOKING FORM ROUTES ** //

    Route::post('/postStep1', 'UserBookingController@postStep1')->name('postStep1');
    Route::get('/select-booking-time', 'UserBookingController@loadStep2')->name('loadStep2');
    Route::post('/postStep2', 'UserBookingController@postStep2')->name('postStep2');
    Route::get('/select-extra-services', 'UserBookingController@loadStep3')->name('loadStep3');
    Route::post('/postStep3', 'UserBookingController@postStep3')->name('postStep3');
    Route::get('/finalize-booking', 'UserBookingController@loadFinalStep')->name('loadFinalStep');

    //PAYMENT GATEWAYS

    Route::post('/payWithStripe', 'StripeController@payWithStripe')->name('payWithStripe');
    Route::get('/payWithPaypal', 'PaypalController@payWithPaypal')->name('payWithPaypal');
    Route::get('/pay-after-service', 'OfflinePaymentController@payOffline')->name('payOffline');
    Route::get('/paymentSuccessful', 'PaypalController@paymentSuccessful')->name('paymentSuccessful');
    Route::get('/paymentFailed', 'PaypalController@paymentFailed')->name('paymentFailed');

    // ** BOOKING COMPLETE OR FAILED ROUTES ** //

    Route::get('/thank-you', 'UserBookingController@thankYou')->name('thankYou');
    Route::get('/payment-failed', 'UserBookingController@paymentFailed')->name('paymentFailed');

    // ** AUXILIARY ROUTES  ** //

    Route::resource('/session_addons', 'SessionAddonsController');
    Route::get('/account-disabled', function () {
        return view('errors.accountDisabled');
    });

    Route::get('/print-ticket/{bookingId}/pdf', 'UserBookingController@printPdf')->name('printPdf');
    Route::get('/print-ticket/{bookingId}', 'UserBookingController@print')->name('printNow');
    // ** PASSWORD CHANGE ROUTES ** //

    Route::get('/password/update', 'UserPasswordController@index')->name('changePassword');
    Route::patch('/password/update/{id}', 'UserPasswordController@update')->name('postChangePassword');
});

Route::group(['prefix' => 'verification'], function () {
    Route::get('/tazkira', 'Verification\TazkiraController@fillForm')->name('verfiy.tazkira');
    Route::post('/tazkira', 'Verification\TazkiraController@store')->name('verfiy.tazkira.store');
});

Route::group(['prefix' => 'visa'], function () {
    Route::get('/visaform', 'Visa\VisaFormController@fillForm')->name('visa-form.fill');
    Route::get('/check-visa-status', 'Visa\VisaFormController@checkStatus')->name('check-status');
    Route::post('/check-visa-status', 'Visa\VisaFormController@doCheckStatus')->name('do-check-status');
    Route::post('/visaform', 'Visa\VisaFormController@store')->name('visa-form.fill.store');
    Route::get('/print/{visa_form}', 'Visa\VisaFormController@print')->name('visa.print');
    Route::get('/visa-completion/{visa_form}', 'Visa\VisaFormController@visaComplete')->name('visa.complete');
});

Route::group(['prefix' => 'check'], function () {
    Route::get('verify', 'VerifyController@check')->name('verify');
    Route::get('/docs', 'Tracing\DocumentController@checkStatus')
        ->name('docs.check')
        ->middleware(['throttle:30,1']);
});

Route::get('ajax-request', 'AjaxController@ajax')->name('ajaxRequest');

Route::group(['middleware' => ['web']], function () {
    Route::get('img/{drive}/{folder}/{filename}', function ($drive, $folder, $filename) {
        // return storage_path() . "\\app\\{$drive}\\{$folder}\\" . $filename;
        return \Image::make(storage_path() . "/app/{$drive}/{$folder}/" . $filename)->response();
    });
});

Route::group(['prefix' => 'tasaadiq', 'middleware' => 'auth'], function () {

    Route::get('/birth/d-table', 'Tasaadiq\BirthCertificateController@dataTable')->name('birth.data');
    Route::get('/birth/print/{birth}', 'Tasaadiq\BirthCertificateController@print')->name('birth.print');
    Route::resource('/birth', 'Tasaadiq\BirthCertificateController');

    Route::get('/marriage/d-table', 'Tasaadiq\MarriageCertificateController@dataTable')->name('marriage.data');
    Route::get('/marriage/print/{marriage}', 'Tasaadiq\MarriageCertificateController@print')->name('marriage.print');
    Route::resource('/marriage', 'Tasaadiq\MarriageCertificateController');

    Route::get('/celibacy/d-table', 'Tasaadiq\CelibacyCertificateController@dataTable')->name('celibacy.data');
    Route::get('/celibacy/print/{celibacy}', 'Tasaadiq\CelibacyCertificateController@print')->name('celibacy.print');
    Route::resource('/celibacy', 'Tasaadiq\CelibacyCertificateController');

    // Route::get('/confirmation/d-table', 'Tasaadiq\ConfirmationCertificateController@dataTable')->name('confirmation.data');
    // Route::get('/confirmation/print/{confirmation}', 'Tasaadiq\ConfirmationCertificateController@print')->name('confirmation.print');
    // Route::resource('/confirmation', 'Tasaadiq\ConfirmationCertificateController');

    // // online forms
    // Route::get('/forms', 'Tasaadiq\OnlineFormController@dataTable')->name('forms.search');
    // Route::get('/forms/import', 'Tasaadiq\OnlineFormController@dataTable')->name('forms.import');

});

// Route::group(['prefix' => 'forms', 'middleware' => ['web']], function () {
//     Route::get('/', 'Forms\OnlineFormController@index');
//     Route::get('/birth-certificate', 'Forms\OnlineFormController@birthCertificate')->name('forms.birth');
//     Route::post('/birth-certificate', 'Forms\OnlineFormController@storeBirth')->name('forms.storeBirth');
//     Route::get('/celibacy-certificate', 'Forms\OnlineFormController@celibacy')->name('forms.celibacy');
//     Route::get('/marriage-certificate', 'Forms\OnlineFormController@marriage')->name('forms.marriage');
//     // Route::put('/store', 'Forms\OnlineFormController@store')->name('forms.store');
// });

Route::group(['prefix' => 'finance', 'middleware' => ['web', 'auth']], function () {

    Route::get('/receipts/dashboard', 'Finance\ReceiptController@dashboard')->name('receipts.dashboard');
    Route::get('/receipts/online', 'Finance\ReceiptController@online')->name('receipts.online');
    Route::get('/receipts/d-table', 'Finance\ReceiptController@dataTable')->name('receipts.data');
    Route::get('/receipts/print/{receipt}', 'Finance\ReceiptController@print')->name('receipts.print');
    Route::resource('/receipts', 'Finance\ReceiptController');

    Route::get('/clearance/dashboard', 'Finance\ClearanceController@dashboard')->name('clearance.dashboard');
    Route::get('/clearance/d-table', 'Finance\ClearanceController@dataTable')->name('clearance.data');
    Route::get('/clearance/print/{clearance}', 'Finance\ClearanceController@print')->name('clearance.print');
    Route::resource('/clearance', 'Finance\ClearanceController');
});

Route::group(['prefix' => 'passport', 'middleware' => ['web', 'auth']], function () {

    // Route::get('/extensions/dashboard', 'Passport\ExtensionController@dashboard')->name('extensions.dashboard');
    Route::get('/extensions/d-table', 'Passport\ExtensionController@dataTable')->name('extensions.data');
    Route::post('/extensions/status/{extension}', 'Passport\ExtensionController@status')->name('extensions.status');
    Route::resource('/extensions', 'Passport\ExtensionController');
});

Route::get('verify/{hashSerialNo}', [VerifyController::class, 'verifyQrCode'])->name('booking.verify');
