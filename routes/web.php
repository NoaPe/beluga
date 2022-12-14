<?php

use Illuminate\Support\Facades\Route;
use NoaPe\Beluga\Beluga;
use NoaPe\Beluga\Http\Controllers\SchemaController;
use NoaPe\Beluga\Http\Models\Data;
use NoaPe\Beluga\Http\Models\Group;
use NoaPe\Beluga\Http\Models\Table;

Route::get('/', [SchemaController::class, 'index'])->name('beluga.index');
Route::get('/edit/{name}', [SchemaController::class, 'edit'])->name('beluga.edit');
Route::get('/create', [SchemaController::class, 'create'])->name('beluga.create');
Route::get('/show/{name}', [SchemaController::class, 'name'])->name('beluga.show');
Route::get('/export/{name}', [SchemaController::class, 'export'])->name('beluga.export');

Beluga::createResource(Table::class, false, ['groups', 'datas']);
Beluga::createResource(Group::class, true, ['groups', 'datas']);
Beluga::createResource(Data::class, true);
