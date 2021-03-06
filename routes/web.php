<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;

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

# Routes for Library Books

# Routes & Params
Route::get('/', [Controller::class, 'showbooks']);
Route::get('/manage', [Controller::class, 'bookcreate']);

# CRUD
Route::resource('/bookpost', 'App\Http\Controllers\Controller');
Route::get('/manage/{id}', [Controller::class, 'bookupdate'])->name('bookupdate');
Route::get('/delete/{id}', [Controller::class, 'bookdelete'])->name('bookdelete');

# Filter 
Route::get('/books/date/{date}', [Controller::class, 'show_books_by_date'])->name('show_books_by_date');
Route::get('/books/tag/{tag}', [Controller::class, 'show_books_by_category'])->name('show_books_by_category');
Route::get('/books/price/{range}', [Controller::class, 'show_books_by_pricerange'])->name('show_books_by_pricerange');
Route::get('/books/rate/{rate}', [Controller::class, 'show_books_by_rate'])->name('show_books_by_rate');
Route::get('/books/author/{author}', [Controller::class, 'show_books_by_author'])->name('show_books_by_author');
Route::get('/books/distributor/{distributor}', [Controller::class, 'show_books_by_distributor'])->name('show_books_by_distributor');

# Register & Login
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('dashboard', [AuthController::class, 'dashboard']); 
