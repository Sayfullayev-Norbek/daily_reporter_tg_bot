<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;


Route::get('/', [CompanyController::class, 'index'])->name('index');

Route::post('/', [CompanyController::class, 'tariffStore'])->name('tariffStore');
