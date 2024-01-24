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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about', [App\Http\Controllers\Jobs\jobsController::class, 'about'])->name('about');
Route::get('/contact', [App\Http\Controllers\Jobs\jobsController::class, 'contact'])->name('contact');

Route::group(['prefix' => 'jobs'], function () {
    Route::get('single/{id}', [App\Http\Controllers\Jobs\jobsController::class, 'single'])->name('single.job');
    Route::post('save', [App\Http\Controllers\Jobs\jobsController::class, 'saveJob'])->name('save.job');
    Route::post('apply', [App\Http\Controllers\Jobs\jobsController::class, 'jobApply'])->name('apply.job');
    Route::any('search', [App\Http\Controllers\Jobs\jobsController::class, 'search'])->name('search.job');
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('single/{name}', [App\Http\Controllers\Categories\categoriesController::class, 'singleCategory'])->name('categories.single');

});

Route::group(['prefix' => 'users'], function () {
    Route::get('profile', [App\Http\Controllers\Users\usersController::class, 'profile'])->name('profile');
    Route::get('applications', [App\Http\Controllers\Users\usersController::class, 'applications'])->name('applications');
    Route::get('savedjobs', [App\Http\Controllers\Users\usersController::class, 'savedJobs'])->name('saved.jobs');


    Route::get('edit-details', [App\Http\Controllers\Users\usersController::class, 'editDetails'])->name('edit.details');
    Route::post('edit-details', [App\Http\Controllers\Users\usersController::class, 'updateDetails'])->name('update.details');


    Route::get('edit-cv', [App\Http\Controllers\Users\usersController::class, 'editCV'])->name('edit.cv');
    Route::post('edit-cv', [App\Http\Controllers\Users\usersController::class, 'updateCV'])->name('update.cv');
});




Route::get('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'viewLogin'])->name('view.login')->middleware('checkforauth');
Route::post('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'checkLogin'])->name('check.login');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/', [App\Http\Controllers\Admins\AdminsController::class, 'index'])->name('admins.dashboard');
    Route::get('/all-admins', [App\Http\Controllers\Admins\AdminsController::class, 'admins'])->name('view.admins');

    Route::get('/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'createAdmins'])->name('create.admins');
    Route::post('/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'storeAdmins'])->name('store.admins');

});


