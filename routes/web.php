<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified' ,'password.confirm'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/tags',[TagsController::class , 'index'])
    ->name('tags.index');
Route::get('/tags/create',[TagsController::class , 'create'])
    ->name('tags.create');
Route::post('/tags',[TagsController::class , 'store'])
    ->name('tags.store');
Route::get('/tags/{id}/edit',[TagsController::class , 'edit'])
    ->name('tags.edit');
Route::put('/tags/{id}',[TagsController::class , 'update'])
    ->name('tags.update');
Route::delete('/tags/{id}',[TagsController::class , 'destroy'])
    ->name('tags.destroy');

Route::resource('/questions',QuestionsController::class);

Route::get('profile' , [UserProfileController::class , 'edit'])
    ->name('profile')
    ->middleware('auth');
Route::put('profile' , [UserProfileController::class , 'update'])
    ->middleware('auth');

