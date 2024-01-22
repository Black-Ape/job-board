<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Jobs\jobsController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/jobs/single/{id}', [App\Http\Controllers\Jobs\jobsController::class, 'single'])->name('single.job');
Route::post('/jobs/save', [App\Http\Controllers\Jobs\jobsController::class, 'saveJob'])->name('save.job');
Route::post('/jobs/apply', [App\Http\Controllers\Jobs\jobsController::class, 'jobApply'])->name('apply.job');

Route::get('/categories/single/{name}', [App\Http\Controllers\Categories\categoriesController::class, 'singleCategory'])->name('categories.single');

Route::get('/users/profile', [App\Http\Controllers\Users\usersController::class, 'profile'])->name('profile');
Route::get('/users/applications', [App\Http\Controllers\Users\usersController::class, 'applications'])->name('applications');
Route::get('/users/savedjobs', [App\Http\Controllers\Users\usersController::class, 'savedJobs'])->name('saved.jobs');
