<?php

use App\Http\Controllers\ClientsContoller;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use \App\Models\Clients;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/clients', function () {
        return Inertia::render('Clients',[
            'clients' => Clients::all()
        ]);
    })->name('clients');

    Route::get('/clients/create', function () {
        return Inertia::render('ClientForm',[
            'formUrl' => '/clients/create',
             'csrfToken' => csrf_token(),
        ]);
    })->name('clients.create');
    Route::post('/clients/create', [ClientsContoller::class, 'store'])->name('clients.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
