<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Models\Articles;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/permissions', [PermissionsController::class, 'index'])->name('permission.index');
    Route::get('/permissions/create', [PermissionsController::class, 'create'])->name('permission.create');
    Route::post('/permissions', [PermissionsController::class, 'store'])->name('permission.store');
    Route::get('/permission/{id}/edit', [PermissionsController::class, 'edit'])->name('permission.edit');
    Route::put('/permission/{id}', [PermissionsController::class, 'update'])->name('permission.update');
    Route::delete('/permission/{id}', [PermissionsController::class, 'destroy'])->name('permission.destory');
    //Roles Routes
    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');
    Route::get('/roles/edit/{id}', [RolesController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{id}', [RolesController::class, 'update'])->name('roles.update');
    Route::delete('/roles/delete/{id}', [RolesController::class, 'destroy'])->name('roles.destroy');
    //Articles Routes
    Route::get('/articles', [ArticlesController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [ArticlesController::class, 'create'])->name('articles.create');
    Route::post('/route/create/', [ArticlesController::class, 'store'])->name('articles.store');
    Route::get('/articles/edit/{id}', [ArticlesController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/edit/{id}', [ArticlesController::class, 'update'])->name('articles.update');
    Route::delete('articles/delete/{id}', [ArticlesController::class, 'destroy'])->name('articles.destroy');
    /// Routes For User
    Route::get('/user', [UserController::class, 'index'])->name('users.index');
    Route::get('/user/create/', [UserController::class, 'create'])->name('users.create');
    Route::post('/user', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__ . '/auth.php';
