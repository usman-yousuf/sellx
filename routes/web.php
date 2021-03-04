<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');

});
Route::get('cms/tos', 'App\Http\Controllers\CMSController@tos_page');
Route::get('cms/privacy', 'App\Http\Controllers\CMSController@privacy_page');


Auth::routes();


Route::group(['middleware' => 'auth'], function () {
	Route::name('admin.')->group(function() {
		
		Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

		//USERS MANAGEMENT ROUTES
	    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('users');
	    Route::get('/admin/users/view/{uuid}', [UserManagementController::class, 'view'])->name('users.view');
	    Route::get('/admin/users/edit/{uuid?}', [UserManagementController::class, 'edit'])->name('users.edit');
	    Route::post('/admin/users/update/{uuid?}', [UserManagementController::class, 'update'])->name('users.update');
	    Route::get('/admin/users/delete/{uuid?}', [UserManagementController::class, 'delete'])->name('users.delete');

	});
});