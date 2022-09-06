<?php

use Illuminate\Support\Facades\Route;
use NoaPe\Beluga\Http\Controllers\SchemaController;

Route::get('/', [SchemaController::class, 'index'])->name('beluga.index');
Route::get('/edit/{name}', [SchemaController::class, 'edit'])->name('beluga.edit');
Route::get('/show/{name}', [SchemaController::class, 'name'])->name('beluga.show');
Route::get('/export/{name}', [SchemaController::class, 'export'])->name('beluga.export');