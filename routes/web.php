<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Route;

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

// Home page
Route::get('/', [PortfolioController::class, 'index'])->name('home');

// Portfolio routes
Route::get('/portfolio/{id}', [PortfolioController::class, 'show'])->name('portfolio.show');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::post('/portfolio/{id}/comment', [PortfolioController::class, 'addComment'])->name('comment.store');
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [PortfolioController::class, 'admin'])->name('admin.dashboard');
    Route::get('/admin/create', [PortfolioController::class, 'create'])->name('admin.create');
    Route::post('/admin/store', [PortfolioController::class, 'store'])->name('admin.store');
    Route::get('/admin/edit/{id}', [PortfolioController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/update/{id}', [PortfolioController::class, 'update'])->name('admin.update');
    Route::delete('/admin/destroy/{id}', [PortfolioController::class, 'destroy'])->name('admin.destroy');
    
    // Content management
    Route::post('/admin/portfolio/{portfolio}/content', [ContentController::class, 'store'])->name('content.store');
    Route::delete('/admin/content/{id}', [ContentController::class, 'destroy'])->name('content.destroy');
});