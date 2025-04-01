<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [RegisterController::class, 'create'])->name('register');
Route::get('/events', [HomeController::class, 'getEvent']);
Route::get('/fetch-events', [HomeController::class, 'getFetchEvents'])->name('fetch.events');
Route::get('/get-assets', [HomeController::class, 'getAssetLists']);
Route::get('/fetch-assets', [HomeController::class, 'getAssetDetails'])->name('fetch.asset');
Route::get('/fetch-asset', [HomeController::class, 'fetchDownload'])->name('fetch.downloadasset');
Route::post('/bulk-download', [HomeController::class, 'bulkDownload'])->name('bulk.download.asset');
Route::resource('/enquiries', EnquiryController::class);
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::resource('roles', RolePermissionController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('assetdatas', AssetController::class);
    Route::resource('events', EventController::class);
    Route::resource('users', UserController::class);
    Route::resource('campaigns', CampaignController::class);
});