<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PhotographerManagementController;
use App\Http\Controllers\Photographer\PhotographerController;
use App\Http\Controllers\Photographer\LeadController;
use App\Http\Controllers\Photographer\PhotoUploadController;
use App\Http\Controllers\DownloadController;
use Illuminate\Support\Facades\Route;

// Homepage -> se loggato vai in dashboard, altrimenti login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

// Auth routes - basic authentication
require __DIR__.'/auth.php';

// Dashboard redirect based on role
Route::get('/dashboard', function() {
    $user = auth()->user();
    
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('fotografo')) {
        return redirect()->route('photographer.dashboard');
    }
    
    return redirect('/');
})->middleware('auth')->name('dashboard');

// ==========================
// ROTTE AMMINISTRATORE
// ==========================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestione Eventi
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    
    // Gestione Fotografi
    Route::get('/photographers', [PhotographerManagementController::class, 'index'])->name('photographers.index');
    Route::get('/photographers/create', [PhotographerManagementController::class, 'create'])->name('photographers.create');
    Route::post('/photographers', [PhotographerManagementController::class, 'store'])->name('photographers.store');
    Route::get('/photographers/{photographer}', [PhotographerManagementController::class, 'show'])->name('photographers.show');
    Route::get('/photographers/{photographer}/edit', [PhotographerManagementController::class, 'edit'])->name('photographers.edit');
    Route::put('/photographers/{photographer}', [PhotographerManagementController::class, 'update'])->name('photographers.update');
    Route::delete('/photographers/{photographer}', [PhotographerManagementController::class, 'destroy'])->name('photographers.destroy');
    
    // Gestione Lead
    Route::get('/leads', [AdminController::class, 'leads'])->name('leads.index');
    Route::get('/leads/{lead}/edit', [AdminController::class, 'editLead'])->name('leads.edit');
    Route::put('/leads/{lead}', [AdminController::class, 'updateLead'])->name('leads.update');
    Route::delete('/leads/{lead}', [AdminController::class, 'destroyLead'])->name('leads.destroy');
    Route::get('/leads/{lead}', [AdminController::class, 'leadDetail'])->name('leads.show');
    
    // Gestione Foto
    Route::get('/photos', [AdminController::class, 'photos'])->name('photos.index');
    
    // Gestione Ordini
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/leads/{lead}/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/leads/{lead}/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{order}/mark-paid', [OrderController::class, 'markAsPaid'])->name('orders.mark-paid');
});

// ==========================
// ROTTE FOTOGRAFO
// ==========================
Route::middleware(['auth', 'photographer'])->prefix('fotografo')->name('photographer.')->group(function () {
    // Dashboard
    Route::get('/', [PhotographerController::class, 'dashboard'])->name('dashboard');
    
    // Gestione Eventi
    Route::get('/events', [PhotographerController::class, 'events'])->name('events.index');
    Route::get('/events/{event}', [PhotographerController::class, 'eventDetail'])->name('events.show');
    
    // Gestione Lead
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/create/{event?}', [LeadController::class, 'create'])->name('leads.create');
    Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
    Route::get('/leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
    Route::get('/leads/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit');
    Route::put('/leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
    
    // Upload Foto
    Route::get('/leads/{lead}/photos/upload', [PhotoUploadController::class, 'create'])->name('photos.upload');
    Route::post('/leads/{lead}/photos', [PhotoUploadController::class, 'store'])->name('photos.store');
    Route::post('/leads/{lead}/photos/multiple', [PhotoUploadController::class, 'uploadMultiple'])->name('photos.multiple');
    Route::delete('/leads/{lead}/photos/{photo}', [PhotoUploadController::class, 'destroy'])->name('photos.destroy');
});

// ==========================
// ROTTE DOWNLOAD CLIENTI
// ==========================
Route::prefix('download')->name('download.')->group(function () {
    Route::get('/{token}', [DownloadController::class, 'gallery'])
          ->name('gallery')
          ->middleware('signed');
    
    Route::get('/{token}/photo/{photo}', [DownloadController::class, 'photo'])
          ->name('photo')
          ->middleware('signed');
    
    Route::get('/{token}/all', [DownloadController::class, 'downloadAll'])
          ->name('all')
          ->middleware('signed');
});
