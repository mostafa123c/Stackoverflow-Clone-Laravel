<?php

use App\Http\Controllers\AnswersController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::get('/dashboard', [DashboardController::class , 'index'] )
    ->middleware(['auth', 'verified' ])
    ->name('dashboard');

Route::get('/dashboard/chart', [DashboardController::class , 'chart'] )
    ->middleware(['auth' ])
    ->name('dashboard.chart');

Route::get('/dashboard/chart/tags', [DashboardController::class , 'tagsChart'] )
    ->middleware(['auth' ])
    ->name('dashboard.chart.donut');


Route::group(['middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'] , 'prefix' => LaravelLocalization::setLocale()], function () {

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });


    Route::group(['middleware' => ['auth' , 'user.type:admin,super-admin'] , 'prefix' => 'tags' , 'as' => 'tags.'] , function () {

        Route::get('',[TagsController::class , 'index'])
            ->name('index');
        Route::get('/create',[TagsController::class , 'create'])
            ->name('create');
        Route::post('',[TagsController::class , 'store'])
            ->name('tags.store');
        Route::get('/{id}/edit',[TagsController::class , 'edit'])
            ->name('edit');
        Route::put('/{id}',[TagsController::class , 'update'])
            ->name('update');
        Route::delete('/{id}',[TagsController::class , 'destroy'])
            ->name('destroy');
    });


    Route::resource('roles',RolesController::class)
            ->middleware(['auth' , 'user.type:admin,super-admin']);


    Route::resource('questions',QuestionsController::class);


    Route::group(['middleware' => 'auth'] , function (){

    //Notifications
    Route::get('notifications' , [NotificationsController::class , 'index'])
        ->name('notifications');

    //Profile
    Route::get('profile' , [UserProfileController::class , 'edit'])
        ->name('profile');
    Route::put('profile' , [UserProfileController::class , 'update']);

    //Change Password
    Route::get('password/change' , [ChangePasswordController::class , 'create'])
        ->name('password.change');
    Route::post('password/change' , [ChangePasswordController::class , 'store']);


    //Answers
    Route::post('answers' , [AnswersController::class , 'store'])
        ->name('answers.store');

    Route::put('answers/{id}/best' , [AnswersController::class , 'best'])
        ->name('answers.best');

    });


});


require __DIR__.'/auth.php';

