<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\CounterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CustomerCreateController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserRegistrationController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard'); // Redirect to the dashboard or another authenticated route
    } else {
        return redirect()->route('login'); // Redirect to the login page
    }
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //device function routes
    Route::get('/device', [DeviceController::class, 'index']);
    Route::get('devices/create', [DeviceController::class, 'create']);
    Route::post('devices/store', [DeviceController::class, 'store']);
    Route::put('devices/update/{id}', [DeviceController::class, 'update']);
    Route::delete('devices/delete/{id}', [DeviceController::class, 'delete']);

    //Counter routes
    Route::get('/counter', [CounterController::class, 'index'])->name('counter.index');
    Route::get('session/approve/{id}', [SessionController::class, 'approveSession']);
    Route::get('session/decline/{id}', [SessionController::class, 'declineSession']);
    Route::get('session/stop/{id}', [SessionController::class, 'stopSession']);
    Route::post('/session/table/empty', [SessionController::class, 'emptSessionTable']);

    //QR Routes
    Route::get('/qr/{id}', [QrController::class, 'index'])->name('qr.generator');

    //Bill Routes
    Route::get('/bill', [BillController::class, 'index']);
    Route::post('/save-bill/{id}', [BillController::class, 'store'])->name('bill.store');
    Route::post('/pay-bill', [BillController::class, 'payBill'])->name('payBill');

    //Daily income
    Route::get('/daily/income', [BillController::class, 'indexDailyIncome']);
    Route::post('/store/daily/income', [BillController::class, 'storedailyincome'])->name('income.store');

    //Report Routes
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/reports/filter', [ReportController::class, 'filterReports'])->name('reports.filter');

    //Rate Routes
    Route::resource('rates', RateController::class);

    //Customer Routes
    Route::get('/customer-registration', [CustomerCreateController::class, 'customerRegistration'])->name('customer.customer-registration');
    Route::post('/customers', [CustomerCreateController::class, 'store'])->name('customer.store');
    Route::get('/customers/{id}/edit', [CustomerCreateController::class, 'edit'])->name('customer.edit');
    Route::put('/customers/{id}', [CustomerCreateController::class, 'update'])->name('customer.update');
    Route::delete('/customers/{id}', [CustomerCreateController::class, 'destroy'])->name('customer.destroy');

    //Pyment Routes
    Route::post('/generate-bill', [PaymentController::class, 'index']);


    //Discounts
    Route::put('/discountUpdate/{id}', [RateController::class, 'updateDiscounts'])->name('discount.Update');
    Route::get('/reset-discounts', [RateController::class, 'resetdiscounts'])->name('reset.discounts');

    //User Registration
    Route::get('/user-registration', [UserRegistrationController::class, 'index']);
    Route::post('/user-reg', [UserRegistrationController::class, 'store']);
    Route::put('/user-reg/{id}', [UserRegistrationController::class, 'update']);
    Route::delete('/user-reg/{id}', [UserRegistrationController::class, 'destroy']);

});

Route::get('session/toggle/{id}', [SessionController::class, 'toggleSession']);



