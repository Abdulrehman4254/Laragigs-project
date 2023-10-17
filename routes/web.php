<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//All Listings
Route::get('/',[ListingController::class,'index'] );


//create form
Route::get('/Listings/create',[ListingController::class,'create'] )->middleware('auth');

//store data
Route::post('/Listings',[ListingController::class,'store'])->middleware('auth');

//show edit form
Route::get('/Listings/{listingsmain}/edit',[ListingController::class,'edit'] )->middleware('auth');

//Update Listings
Route::put('/Listings/{listingsmain}',[ListingController::class,'update'] )->middleware('auth');

//Delete Listings
Route::delete('/Listings/{listingsmain}',[ListingController::class,'destroy'] )->middleware('auth');

//Manage Listings
Route::get('/Listings/manage',[ListingController::class,'manage'] )->middleware('auth');

//single Listings
Route::get('/Listings/{listingsmain}',[ListingController::class,'show'] );

//Show Register Create Form
Route::get('/register',[UserController::class,'register'] )->middleware('guest');

//Create New User
Route::post('/Users',[UserController::class,'store'] );

//Logout USer
Route::post('/logout',[UserController::class,'logout'] )->middleware('auth');

//show login Form
Route::get('/login',[UserController::class,'login'] )->name('login')->middleware('guest');

// Login user
Route::post('/Users/authenticate',[UserController::class,'authenticate'] );


