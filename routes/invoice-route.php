<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController as InvCon;

Route::prefix('invoice')->name('invoice.')->group(function () {
	Route::get('/', [InvCon::class, 'index'])->name('index');
	Route::get('/create', [InvCon::class, 'create'])->name('create')->middleware('can:CreateInvoice');
	Route::put('/store', [InvCon::class, 'store'])->name('store')->middleware('can:CreateInvoice');
	Route::get('/{invoice}/edit', [InvCon::class, 'edit'])->name('edit')->middleware('can:UpdateInvoice');
	Route::put('/{invoice}/update', [InvCon::class, 'update'])->name('update')->middleware('can:UpdateInvoice');
	Route::get('/{invoice}/print', [InvCon::class, 'print'])->name('print');
	Route::delete('/{invoice}/delete', [InvCon::class, 'destroy'])->name('delete')->middleware('can:DeleteInvoice');
});