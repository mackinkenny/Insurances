<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Administrator;
use App\Http\Middleware\CompanyUser;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Ltm_translation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Jobs\SendSms;


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

Route::get('/', [UserController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');


//Route::get('/test/{id}/{dr}', [CompanyController::class, 'index']);
// Company
Route::middleware(['auth:sanctum', 'verified'])->prefix('/company')->group(function () {
    // GET
    Route::get('/list',                     [CompanyController::class, 'index'])->name( 'company/list')->middleware([Administrator::class]);
    Route::get('/create',                   [CompanyController::class, 'create'])->name('company/create')->middleware([Administrator::class]);
    Route::get('/tokens',                   [CompanyController::class, 'tokens'])->name('company/tokens')->middleware([CompanyUser::class]);
    Route::get('/edit/{id}',                [CompanyController::class, 'edit'])->name('company/edit')->middleware([Administrator::class]);
    Route::get('/contracts',                [CompanyController::class, 'contracts'])->name('company/contracts')->middleware([CompanyUser::class]);
    Route::get('/dashboard',                [CompanyController::class, 'dashboard'])->name('company/dashboard')->middleware([CompanyUser::class]);
    Route::get('/api',                      [CompanyController::class, 'api'])->name('company/api');
    Route::get('/employees',                [CompanyController::class, 'employees'])->name('company/employees');
    Route::get('/getApi',                   [CompanyController::class, 'getApi'])->name('company/getApi');
    // POST
    Route::post('/store',                   [CompanyController::class, 'store'])->name('company/store');
    Route::post('/update',                  [CompanyController::class, 'update'])->name('company/update');
    Route::post('/search',                  [CompanyController::class, 'search'])->name('company/search');
    Route::post('/updateResponsive',        [CompanyController::class, 'updateResponsive'])->name('updateResponsive');
    Route::post('/updatePhone',             [CompanyController::class, 'updatePhone'])->name('updatePhone');
    Route::post('/{id}/contracts/search',   [CompanyController::class, 'searchCompanyContracts'])->name('company/contracts/search');
    Route::post('/addInvite',               [InviteController::class, 'store'])->name('company/addInvite');
    Route::post('/shareTokens',             [CompanyController::class, 'shareTokens'])->name('company/shareTokens');

    Route::prefix('/checkout')->group(function () {
        Route::post('/',                        [CompanyController::class, 'checkout'])->name('company/checkout');
        Route::get('/success/{session_id}',     [CompanyController::class, 'success'])->name('company/checkout/success');
        Route::get('/cancel/{session_id}',      [CompanyController::class, 'cancel'])->name('company/checkout/cancel');
    });
});


Route::middleware(['auth:sanctum', 'verified'])->prefix('/contract/')->group(function () {
    //GET
    Route::get('changelog/list',            [ContractController::class, 'changelog'])->name('changelog/contract/list')->middleware([Administrator::class]);
    Route::get('list',                      [ContractController::class, 'index'])->name('contract/list')->middleware([Administrator::class]);
    Route::get('upload',                    [ContractController::class, 'create'])->name('contract/upload');
    Route::get('upload-success',            [ContractController::class,'uploadSuccess'])->name('contract/upload/success');

    //POST
    Route::post('get-code',                 [UserController::class, 'getCode'])->name('contact/get-code');
    Route::post('verify-code',              [UserController::class, 'verifyCode'])->name('contract/verifyCode');
    Route::post('store',                    [ContractController::class, 'store'])->name('contract/store');
    Route::post('search',                   [ContractController::class, 'search'])->name('contract/search');
});

Route::prefix('tokens/')->group(function () {
    Route::post('history-by-date/{id}',     [TokenController::class, 'history'])->name('history-by-date');
    Route::post('store/{id}',               [TokenController::class, 'store'])->name('tokens/store');
});

Route::prefix('/requests/')->group(function () {
    Route::get('list',                      [SearchController::class, 'index'])->name('requests/list')->middleware([Administrator::class]);;
    Route::post('search',                   [SearchController::class, 'search'])->name('request/search');
});

//GET
Route::get('/how_it_works',                 [UserController::class, 'onboarding'])->name('onboarding');
Route::get('/toExcel/{type}/{id}',          [ReportController::class, 'toExcel'])->name('toExcel');
Route::get('/register/employee/{token}',    [UserController::class, 'register']);
Route::get('/privacy_policy',               [UserController::class, 'privacyPolicy']);

//POST
Route::post('/user/contract/search',        [SearchController::class, 'userSearch'])->name('user/contract/search');
Route::post('/createEmployee',              [UserController::class, 'createEmployee'])->name('createEmployee');
Route::post('/subscribe',                   [UserController::class, 'subscribe'])->name('subscribe');

