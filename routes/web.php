<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usercontroller;
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
Route::get('/', function (){
    return view('insert');
});
Route::controller(usercontroller::class)->group(function(){
Route::post('/insert','insert');
Route::get('/delete/{id}','delete');
Route::get('/userdata','display');
Route::get('/edit/{id}','edit');
Route::post('/update/{id}','update')->name('update');
Route::get("/users", "index");
});

