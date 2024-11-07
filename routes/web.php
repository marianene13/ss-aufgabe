<?php

use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SongController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
    Route::POST('/playlists/add', [PlaylistController::class, 'add'])->name('playlists.add');
    Route::get('/playlists/{id}', [PlaylistController::class, 'show'])->name('playlists.show');
    Route::delete('/playlists/{id}/removeSong', [PlaylistController::class, 'removeSong'])->name('playlists.removeSong');
    Route::post('/playlists/{id}/loadSongs', [PlaylistController::class, 'loadSongs'])->name('playlists.loadSongs');
    Route::get('/songs', [SongController::class, 'index'])->name('songs.index');
    Route::get('/songs/{id}', [SongController::class, 'show'])->name('songs.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
