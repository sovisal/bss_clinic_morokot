<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController as InvCon;

Route::prefix('service')->name('invoice.service.')->group(function () {
	Route::get('/', [InvCon::class, 'index'])->name('index');
	Route::get('/create', [InvCon::class, 'create'])->name('create')->middleware('can:CreatePrescription');
	Route::post('/store', [InvCon::class, 'store'])->name('store')->middleware('can:CreatePrescription');
	Route::get('/{service}/edit', [InvCon::class, 'edit'])->name('edit')->middleware('can:UpdatePrescription');
	Route::put('/{service}/update', [InvCon::class, 'update'])->name('update')->middleware('can:UpdatePrescription');

});