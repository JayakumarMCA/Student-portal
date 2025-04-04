<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CourseMasterController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\BatchDetailController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/eventhtml', function () {
    return view('admin.eventhtml');
});
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/dashboard', function () {
    return view('admin.dashboard');
});
Route::get('/pagehtml', function () {
    return view('admin.pagehtml');
});
Route::get('/check-mail', function () {
    try {
        Mail::raw('This is a test email to check SMTP configuration.', function ($message) {
            $message->to('your@email.com') // 👈 replace with your email
                    ->subject('SMTP Test - Laravel');
        });

        return '✅ Test email sent successfully!';
    } catch (\Exception $e) {
        return '❌ Error sending email: ' . $e->getMessage();
    }
});
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [RegisterController::class, 'create'])->name('register');
Route::get('/events', [HomeController::class, 'getEvent']);
Route::get('/profile', [HomeController::class, 'profile'])->name('user.profile');
Route::get('/change-password', [HomeController::class, 'changePassword'])->name('user.changePassword');
Route::post('/update-password', [HomeController::class, 'updatePassword'])->name('user.updatePassword');
Route::put('/update-profile/{id}', [HomeController::class, 'updateProfile'])->name('user.updateProfile');
Route::get('/fetch-events', [HomeController::class, 'getFetchEvents'])->name('fetch.events');
Route::get('/get-assets', [HomeController::class, 'getAssetLists']);
Route::get('/fetch-assets', [HomeController::class, 'getAssetDetails'])->name('fetch.asset');
Route::get('/fetch-asset', [HomeController::class, 'fetchDownload'])->name('fetch.downloadasset');
Route::post('/bulk-download', [HomeController::class, 'bulkDownload'])->name('bulk.download.asset');
Route::resource('/enquiries', EnquiryController::class);
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::resource('roles', RolePermissionController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('batches', BatchController::class);
    Route::resource('batch-details', BatchDetailController::class);
    Route::resource('course_master', CourseMasterController::class);
    Route::resource('questions', QuestionController::class);
    Route::get('questions/getOptions/{id}', [QuestionController::class, 'getOptions'])->name('get_options');
    Route::get('questions/mcq-option-html/{count}', [QuestionController::class, 'mcqOptionHtml'])->name('mcq/questions/mcq-option-html');
    Route::resource('users', UserController::class);
    Route::resource('campaigns', CampaignController::class);
});