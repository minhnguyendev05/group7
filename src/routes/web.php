<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AdminController;

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
//Route::get('/home', function (){
    //     return view("home");
    // })->name('home');
Route::get('/', function () {
    return view('dashboard');
});
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('dashboard', function () {
//     return view('dashboard'); // Trang dashboard
// })->middleware('auth')->name('dashboard'); // middleware don le

Route::middleware(['auth','verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'render'])->name('dashboard');
    Route::get('home', [DashboardController::class, 'render'])->name('home');
    Route::get('/work/add', [WorkController::class, 'render_add'])->name('add_work');
    Route::post('/work/add', [WorkController::class, 'add']);
    Route::get('/work/view', [WorkController::class, 'view'])->name('view_work');
    Route::get('/work/history', [WorkController::class, 'history'])->name('history_work');
    Route::get('/work/details/{id}', [WorkController::class, 'get_work_id']);
    Route::get('/note', [NoteController::class, 'view'])->name('view_note');
    Route::post('/note/add',[NoteController::class, 'add']);
    Route::get('/review', [NoteController::class, 'review'])->name('view_review');
    Route::post('/review',[NoteController::class, 'add_review']);
    Route::get('/admin/review', [AdminController::class, 'view_review'])->name('admin_view_review');
    Route::get('/admin/user', [AdminController::class, 'view_user'])->name('admin_view_user');
    Route::post('/admin/user/delete', [AdminController::class, 'delete_user']);
}); // them vao group cac route can login



Route::get('verify', [RegisterController::class, 'showverify'])->name('showverify');
Route::post('verify/resend', [RegisterController::class, 'resend']);
Route::get('verify/{token}', [RegisterController::class, 'verify'])->name('verify');
Route::get('/work/get', [WorkController::class, 'get_work']);
Route::post('/work/update',[WorkController::class,'update']);
Route::post('/note/get', [NoteController::class, 'get_note']);
Route::post('/note/bind', [NoteController::class, 'bind_note']);
Route::get('/suspended', [DashboardController::class, 'suspended'])->name('suspended');



