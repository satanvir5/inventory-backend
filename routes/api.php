<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\SupplierController;


Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});


Route::prefix('suppliers')->group(function () {
    Route::get('/', [SupplierController::class, 'index']); // List suppliers
    Route::post('/', [SupplierController::class, 'store']); // Create new supplier
    Route::get('{id}', [SupplierController::class, 'show']); // Get single supplier
    Route::put('{id}', [SupplierController::class, 'update']); // Update supplier
    Route::delete('{id}', [SupplierController::class, 'destroy']); // Delete supplier
});


Route::prefix('purchases')->group(function () {
    Route::post('/', [PurchaseController::class, 'store']);
    Route::get('/', [PurchaseController::class, 'index']);
});
