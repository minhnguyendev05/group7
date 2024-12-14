<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', function () {
    return view('home');
});
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('dashboard', function () {
//     return view('dashboard'); // Trang dashboard
// })->middleware('auth')->name('dashboard'); // middleware don le

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'render'])->name('dashboard');
}); // them vao group cac route can login

Route::get('verify/{token}', [RegisterController::class, 'verify'])->name('verify');
Route::get('verify', [RegisterController::class, 'showverify'])->name('showverify');
Route::get('/home', function (){
    return view("home");
})->name('home');
Route::get('/work/add', [WorkController::class, 'render_add'])->name('add_work');
Route::post('/work/add', [WorkController::class, 'add']);
Route::get('/work/view', [WorkController::class, 'view'])->name('view_work');
Route::get('/work/get', [WorkController::class, 'get_work']);
Route::get('/work/history', [WorkController::class, 'history'])->name('history_work');
Route::get('/work/details/{id}', [WorkController::class, 'get_work_id']);


