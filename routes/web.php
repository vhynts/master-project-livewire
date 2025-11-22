<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;
use App\Livewire\Profile;
use App\Livewire\Users\Index as UsersIndex;
use App\Livewire\Users\Create as UsersCreate;
use App\Livewire\Users\Edit as UsersEdit;
use App\Livewire\Roles\Index as RolesIndex;
use App\Livewire\Roles\Create as RolesCreate;
use App\Livewire\Roles\Edit as RolesEdit;


Route::get('/', function () {
    return redirect()->route('dashboard');
});


Route::get('/login', Login::class)
    ->middleware('guest')
    ->name('login');


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', Dashboard::class)
        ->name('dashboard');

    // User Management
    Route::prefix('users')->as('users.')->group(function () {
        Route::get('/', UsersIndex::class)
            ->name('index')
            ->middleware('can:users.index');

        Route::get('/create', UsersCreate::class)
            ->name('create')
            ->middleware('can:users.create');

        Route::get('/{user}/edit', UsersEdit::class)
            ->name('edit')
            ->middleware('can:users.edit');
    });

    // Role Management
    Route::prefix('roles')->as('roles.')->group(function () {
        Route::get('/', RolesIndex::class)
            ->name('index')
            ->middleware('can:roles.index');

        Route::get('/create', RolesCreate::class)
            ->name('create')
            ->middleware('can:roles.create');

        Route::get('/{role}/edit', RolesEdit::class)
            ->name('edit')
            ->middleware('can:roles.edit');
    });

    Route::get('/profile', Profile::class)
        ->name('profile');
});
