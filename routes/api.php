<?php

use App\Http\Controllers\CashierController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get("/cashier", [CashierController::class, "index"]);
Route::post("/cashier", [CashierController::class, "store"]);
Route::post("/cashier/withdraw", [TransactionController::class, "withdraw"]);
