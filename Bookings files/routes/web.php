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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/date',function(){
    return date('Y-m-d H:i:s');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'TestController@index');

Route::group(['middleware' => ['auth']], function () {
    //Bookings
    Route::get('/bookings', 'BookingController@getBookingsPage');
    Route::get('/bookings/get/user/{user}', 'BookingController@getUserBookings');
    Route::get('/bookings/all', 'BookingController@getAllBookings');
    Route::post('/bookings/create', 'BookingController@createBooking');
    Route::post('/bookings/delete/{booking}', 'BookingController@deleteBooking');
    Route::post('/bookings/status/{booking}', 'BookingController@setBookingStatus');

    //Services
    Route::get('services', 'ServiceController@getServicesPage');
    Route::get('services/all', 'ServiceController@getAllServices');
    Route::post('services/create', 'ServiceController@createService');
    Route::post('services/rename/{service}', 'ServiceController@renameService');
    Route::post('services/delete/{service}', 'ServiceController@deleteService');

    //User Profiles
    Route::get('/profiles', 'UserController@getProfilePage');
    Route::get('/profiles/all', 'UserController@getAllProfiles');
    Route::post('/profiles/update/{user}', 'UserController@updateProfile');

});
