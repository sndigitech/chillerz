<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\UserController;
//use App\Http\Controllers\Event\CategoryController;
use App\Http\Controllers\Event\SubCategoryController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\Admin\CategoryController;
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


// route for user verify API
//Route::get('/user/verify/{token}', [UserController::class, 'verifyUser']);


Route::get('/', function () {
    //echo 'Hello';
    return view('front-end');
});


//Route::redirect('/', 'login');
//Auth::routes();

// admin authentication routes
Route::get('/demo', [DemoController::class, 'add']);

// put routes in group
//Route::group(['prefix'=>'admin', 'as' => 'admin.'], function(){
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');
    Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('admin.register');
    Route::post('register', [RegisterController::class, 'register'])->name('admin.register');   
 //});

// event related routes
Route::group(['prefix'=>'admin/event', 'middleware'=>'auth'], function(){
    Route::resource('category', CategoryController::class);
    Route::resource('sub_category', SubCategoryController::class);
    Route::resource('event', EventController::class);
});

// Change Password Routes
Route::get('change_password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('auth.change_password');
Route::patch('change_password', [ChangePasswordController::class, 'changePassword'])->name('auth.change_password');

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('auth.password.reset');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('auth.password.reset');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('auth.password.reset');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// place routes


    // common controller
//Route::get('/profile', [UserController::class, 'profile'])->name('admin.profile');


// Admin Panel Routes
// Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
Route::group(['middleware' => ['auth'], 'prefix'=>'admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    Route::get('/bar', [PlaceController::class, 'createBar'])->name('bar');
    Route::get('/club', [PlaceController::class, 'createClub'])->name('club');

    Route::resource('roles', RolesController::class);
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    
    Route::resource('users', UsersController::class);
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    
    Route::resource('events', EventsController::class);
    Route::post('events_mass_destroy', ['uses' => 'Admin\EventsController@massDestroy', 'as' => 'events.mass_destroy']);
    Route::resource('tickets', TicketsController::class);
    Route::post('tickets_mass_destroy', ['uses' => 'Admin\TicketsController@massDestroy', 'as' => 'tickets.mass_destroy']);
    Route::resource('payments', PaymentsController::class);
});


