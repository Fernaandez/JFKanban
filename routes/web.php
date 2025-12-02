<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\UserController;

// Ruta arrel -> Tauler
Route::get('/', [KanbanController::class, 'index'])->name('kanban.index');

// --- RUTES DE GESTIÓ D'USUARIS ---
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
});

// --- RUTES DEL TAULER KANBAN ---
// 1. CREATE
Route::get('/tasks/create', [KanbanController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [KanbanController::class, 'store'])->name('tasks.store');

// 2. READ (Index)
// Ja està definida a dalt, però si vols agrupar-ho tot:
// Route::get('/', [KanbanController::class, 'index'])->name('kanban.index');

// 3. UPDATE (Edició Completa) - AFEGIT ARA
Route::get('/tasks/{task}/edit', [KanbanController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [KanbanController::class, 'update'])->name('tasks.update');

// 4. UPDATE (Només Estat - Drag & Drop o Botons)
Route::patch('/tasks/{task}/status', [KanbanController::class, 'updateStatus'])->name('tasks.update_status');

// 5. DELETE
Route::delete('/tasks/{task}', [KanbanController::class, 'destroy'])->name('tasks.destroy');