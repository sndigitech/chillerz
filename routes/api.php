<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIs\UserController;
use App\Http\Controllers\APIs\EventController;
use App\Http\Controllers\APIs\VendorController;
use App\Http\Controllers\APIs\ArtistController;
use App\Http\Controllers\APIs\CategoryController;
use App\Http\Controllers\APIs\CommonController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
| Put is when you update the whole model and use patch when you want to update a portion or single attribute
*/

// common controller


//Route::group(['prefix' => 'event', 'as' =>'event.', "middleware" => ["auth:api"]], function(){


Route::get('/users', [UserController::class, 'getUsers'])->name('list');
// login and register a/c routes
Route::post('/loginregister', [UserController::class, 'loginRegister'])->name('loginregister'); // login and register new user
// verify otp
Route::post('/otpverify', [UserController::class, 'otpVerify'])->name('otpverify'); // login and register new user

// resend otp
Route::post('/resendotp', [UserController::class, 'resendOtp'])->name('otpresend'); // login and register new user
    // registration API / OK
//Route::post('register', [UserController::class, 'register'])->name('register.api');
Route::post('register', [UserController::class, 'register'])->name('register.api');

    // login API /OK
Route::post('/login', [UserController::class, 'getEmailOrMobile'])->name('emailmobile.api'); // login through email or mobile

Route::post('/mobileotp', [UserController::class, 'mobileOtp'])->name('user.mobileotp'); // send OTP at mobile
Route::post('/emailotp', [UserController::class, 'emailOtp'])->name('user.emailotp'); // send OTP at email

    //verify user using token
Route::post('/verifyuser', [UserController::class, 'verifyUser'])->name('user.verifyuser'); // login through email

    //verify otp /OK
Route::post('/verifyotp', [UserController::class, 'verifyOtp'])->name('user.verifyotp'); // login through email or mobile


    // user routes
// Route::group(['prefix' => 'user', 'as' =>'user.', "middleware" => ["auth:api"]], function(){
        // user routes
    Route::post('/logout', [UserController::class, 'logOut'])->name('logout');
    Route::post('upassword', [UserController::class, 'updatePassword'])->name('update');
    Route::get('/users', [UserController::class, 'getUsers'])->name('list');
    Route::get('/user/{id}', [UserController::class, 'getUser'])->name('user');

    Route::post('/userprofile', [UserController::class, 'profileDetail'])->name('profileDetail');
//});

    // Vendors routes
    Route::group(['prefix' => 'vendor', 'as' =>'vendor.'], function(){
        Route::post('/create', [VendorController::class, 'store'])->name('create');
        Route::get('/list', [VendorController::class, 'vendorList'])->name('list');
        Route::get('/list/{id}', [VendorController::class, 'vendorListById'])->name('vendorbyid');
        Route::put('/owner/{id}', [VendorController::class, 'updateVendor'])->name('update');
        Route::delete('/owner/{id}', [VendorController::class, 'deleteVendor'])->name('delete');
    });

        //organizer / not completed
//  Route::group(['prefix' => 'organizer', 'as' =>'organizer.', "middleware" => ["auth:api"]], function(){
//     Route::post('/organizer', [OrganizerController::class, 'createOrganizer'])->name('create');
//     Route::get('/organizers', [OrganizerController::class, 'getOrganizers'])->name('list');
//     Route::post('/organizer/{id}', [OrganizerController::class, 'getOrganizer'])->name('organizer');
//     Route::put('/organizer/{id}', [OrganizerController::class, 'updateOrganizer'])->name('update');
//     Route::delete('/organizer/{id}', [OrganizerController::class, 'deleteOrganizer'])->name('delete');
//     });

            // Artist routes
                // place type APIs /tested
            Route::group(['prefix' => 'artist'], function(){
                Route::post('/artisttype/create', [ArtistController::class, 'createArtistType'])->name('artistype.create');
                Route::get('/artisttype/list', [ArtistController::class, 'listArtistType'])->name('artistype.list');
                Route::post('/artisttype/delete', [ArtistController::class, 'deleteArtistType'])->name('artistype.delete');
            });
                // Artist routes
            //Route::group(['prefix' => 'performer', 'as' =>'performer.', "middleware" => ["auth:api"]], function(){
            Route::group(['prefix' => 'artist', 'as' => 'artist.'], function(){
                Route::post('/create', [ArtistController::class, 'store'])->name('create');
                Route::get('/list', [ArtistController::class, 'artistList'])->name('list');
                Route::get('/list/{id}', [ArtistController::class, 'artistListById'])->name('listbyid');
                Route::put('/update', [ArtistController::class, 'update'])->name('update');
                Route::delete('/delete/{id}', [ArtistController::class, 'delete'])->name('delete');
            });


            Route::group(['prefix' => 'event'], function(){
         //event type APIs /OK
        Route::get('/eventtype/list', [EventController::class, 'eventTypeList'])->name('eventtype.lists');
        Route::post('/eventtype/create', [EventController::class, 'createEventType'])->name('eventtype.create');
        Route::post('/eventtype/delete', [EventController::class, 'deleteEventType'])->name('eventtype.delete');
        });
        // event routes / OK
    Route::group(['prefix' => 'event', 'as' =>'event.'], function(){
        Route::post('/create', [EventController::class, 'createEvent'])->name('create'); // in as case event.create
        Route::get('/lists', [EventController::class, 'index'])->name('lists');
        Route::post('/list/{id}', [EventController::class, 'getEventById'])->name('list');
        Route::post('/delete/{id}', [EventController::class, 'delete'])->name('delete');
        Route::patch('/update/{id}', [EventController::class, 'updateEvent'])->name('update');
    });
        // category/ tested
    Route::group(['prefix' => 'category'], function(){
        Route::post('/create', [CategoryController::class, 'create'])->name('create');
        Route::get('/list', [CategoryController::class, 'list'])->name('list');
        Route::post('/delete',[CategoryController::class, 'deleteCategory'])->name('category.delete');
    });


        // place type APIs /tested
        Route::group(['prefix' => 'vendor'], function(){
            Route::post('/placetype/create', [VendorController::class, 'createPlaceType'])->name('placetype.create');
            Route::get('/placetype/list', [VendorController::class, 'listPlaceType'])->name('placetype.list');
            Route::post('/placetype/delete', [VendorController::class, 'deletePlaceType'])->name('placetype.delete');
        });

        // place type APIs /OK
    //Route::post('/placetype/create', [VendorController::class, 'createPlaceType'])->name('placetype.create');

    // list of status api
    Route::get('/status/list', [CommonController::class, 'statusList'])->name('status.list');

    // Menu Items routes
Route::group(['prefix' => 'menu', 'as' =>'menu.'], function(){
    Route::post('/create', [CommonController::class, 'createMenu'])->name('create');
    Route::get('/list', [CommonController::class, 'menuList'])->name('menus');
    Route::get('/list/{id}', [CommonController::class, 'menuListById'])->name('menubyid');
    Route::put('/update/{id}', [CommonController::class, 'update'])->name('updatemenu');
    Route::post('/delete', [CommonController::class, 'deleteMenu'])->name('delete');
    // menunameupdate
    Route::post('/createmenuname', [CommonController::class, 'createmenuName'])->name('createmenuname');
    Route::get('/menunamelist', [CommonController::class, 'menuNameList'])->name('menunamelist');
    Route::get('/menunamelistbyid/{id}', [CommonController::class, 'menuNameListById'])->name('menunamelistbyid');
    Route::put('/menunameupdate/{id}', [CommonController::class, 'menunameupdate'])->name('menunameupdate');
    Route::put('/menunamedelete/{id}', [CommonController::class, 'menunamedelete'])->name('menunamedelete');
    });

    // Booking API
    Route::group(['prefix' => 'booking', 'as' =>'booking.'], function(){
        Route::post('/create', [BookingController::class, 'createBooking'])->name('booking');
    });



