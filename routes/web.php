<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// 公开画廊路由
Route::prefix('gallery')->name('gallery.')->group(function () {
    Route::get('/{token}', [GalleryController::class, 'show'])->name('show');
    Route::get('/{token}/photo/{photo}', [GalleryController::class, 'downloadPhoto'])->name('photo.download');
    Route::get('/{token}/download-all', [GalleryController::class, 'downloadAll'])->name('download.all');
    Route::post('/{token}/download-selected', [GalleryController::class, 'downloadSelected'])->name('download.selected');
});
