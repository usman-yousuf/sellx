<?php

use App\Http\Controllers\Admin\AuctioneerManagementController;
use App\Http\Controllers\Admin\CategoriesManagementController;
use App\Http\Controllers\Admin\CitiesManagementController;
use App\Http\Controllers\Admin\CountriesManagementController;
use App\Http\Controllers\Admin\CurrenciesManagementController;
use App\Http\Controllers\Admin\LanguagesManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Route;



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

Route::any('/', function () {
    return view('index');

})->name('home');
Route::get('cms/tos', 'App\Http\Controllers\CMSController@tos_page');
Route::get('cms/privacy', 'App\Http\Controllers\CMSController@privacy_page');
// Route::get('/index', [App\Http\Controllers\HomeController::class, 'homeindex']);
Route::get('/contactus', [App\Http\Controllers\HomeController::class, 'contactus'])->name('contact');
Route::get('/aboutus', [App\Http\Controllers\HomeController::class, 'aboutus'])->name('about');
//Terms And Conditions
Route::get('pages/privacy-mob', [App\Http\Controllers\HomeController::class,'privacymobpage'])->name('pages.mob.privacy.mob');
Route::get('pages/terms-mob', [App\Http\Controllers\HomeController::class,'termsmobpage'])->name('pages.mob.terms.mob');
Route::get('pages/partner-mob', [App\Http\Controllers\HomeController::class,'partnermobpage'])->name('pages.mob.partner.mob');
Route::get('pages/refund-mob', [App\Http\Controllers\HomeController::class,'refundmobpage'])->name('pages.mob.refund.mob');

Route::post('contact_us', 'App\Http\Controllers\ContactFormController@contact_form')->name('contact-us');
Route::post('subscribe', 'App\Http\Controllers\SubscribeController@subscribe')->name('subscribe');


Auth::routes();


Route::group(['middleware' => 'auth'], function () {
	Route::name('admin.')->group(function() {
		
		Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

		//USERS MANAGEMENT ROUTES
	    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('users');
	    Route::get('/admin/users/view/{uuid}', [UserManagementController::class, 'view'])->name('users.view');
	    Route::get('/admin/users/delete/{uuid?}', [UserManagementController::class, 'delete'])->name('users.delete');

	    //AUCTIONEER MANAGEMENT ROUTES
	    Route::get('/admin/auctioneer', [AuctioneerManagementController::class, 'index'])->name('auctioneer');
	    Route::get('/admin/auctioneer/view/{uuid}', [AuctioneerManagementController::class, 'view'])->name('auctioneer.view');
	    Route::get('/admin/auctioneer/delete/{uuid?}', [AuctioneerManagementController::class, 'delete'])->name('auctioneer.delete');
	    Route::get('/admin/auctioneer/approvalrequest', [AuctioneerManagementController::class, 'approvalRequests'])->name('auctioneer.view_approval_request');
	    Route::get('/admin/auctioneer/approvalrequest/form/{uuid?}', [AuctioneerManagementController::class, 'approvalRequestForm'])->name('auctioneer.view_approval_request.form');
	    Route::get('/admin/auctioneer/approvalrequest/delete/{uuid?}', [AuctioneerManagementController::class, 'deleteApprovalRequests'])->name('auctioneer.delete_approval_request');
	    Route::post('/admin/auctioneer/approvalrequest/update/{uuid?}', [AuctioneerManagementController::class, 'updateApprovalRequests'])->name('auctioneer.update_approval_request');

	    //CATEGORY MANAGEMENT ROUTES
	    Route::get('/admin/categories', [CategoriesManagementController::class, 'index'])->name('categories');
	    Route::get('/admin/categories/view/{uuid}', [CategoriesManagementController::class, 'view'])->name('categories.view');
	    Route::get('/admin/categories/create_form/', [CategoriesManagementController::class, 'createForm'])->name('categories.create_form');
	    Route::get('/admin/categories/edit_form/{uuid}', [CategoriesManagementController::class, 'editForm'])->name('categories.edit_form');
	    Route::get('/admin/categories/delete/{uuid?}', [CategoriesManagementController::class, 'delete'])->name('categories.delete');
	    Route::post('/admin/categories/update/', [CategoriesManagementController::class, 'update'])->name('categories.update');

	    //COUNTRY MANAGEMENT ROUTES
	    Route::get('/admin/countries', [CountriesManagementController::class, 'index'])->name('countries');
	    Route::get('/admin/countries/view/{id}', [CountriesManagementController::class, 'view'])->name('countries.view');
	    Route::get('/admin/countries/create_form/', [CountriesManagementController::class, 'createForm'])->name('countries.create_form');
	    Route::get('/admin/countries/edit_form/{id}', [CountriesManagementController::class, 'editForm'])->name('countries.edit_form');
	    Route::get('/admin/countries/delete/{id?}', [CountriesManagementController::class, 'delete'])->name('countries.delete');
	    Route::post('/admin/countries/update/', [CountriesManagementController::class, 'update'])->name('countries.update');

	    //CITY MANAGEMENT ROUTES
	    Route::get('/admin/cities', [CitiesManagementController::class, 'index'])->name('cities');
	    Route::get('/admin/cities/view/{id}', [CitiesManagementController::class, 'view'])->name('cities.view');
	    Route::get('/admin/cities/create_form/', [CitiesManagementController::class, 'createForm'])->name('cities.create_form');
	    Route::get('/admin/cities/edit_form/{id}', [CitiesManagementController::class, 'editForm'])->name('cities.edit_form');
	    Route::get('/admin/cities/delete/{id?}', [CitiesManagementController::class, 'delete'])->name('cities.delete');
	    Route::post('/admin/cities/update/', [CitiesManagementController::class, 'update'])->name('cities.update');

	    //CURRENCY MANAGEMENT ROUTES
	    Route::get('/admin/currencies', [CurrenciesManagementController::class, 'index'])->name('currencies');
	    Route::get('/admin/currencies/view/{id}', [CurrenciesManagementController::class, 'view'])->name('currencies.view');
	    Route::get('/admin/currencies/create_form/', [CurrenciesManagementController::class, 'createForm'])->name('currencies.create_form');
	    Route::get('/admin/currencies/edit_form/{id}', [CurrenciesManagementController::class, 'editForm'])->name('currencies.edit_form');
	    Route::get('/admin/currencies/delete/{id?}', [CurrenciesManagementController::class, 'delete'])->name('currencies.delete');
	    Route::post('/admin/currencies/update/', [CurrenciesManagementController::class, 'update'])->name('currencies.update');

	    //LANGUAGE MANAGEMENT ROUTES
	    Route::get('/admin/languages', [LanguagesManagementController::class, 'index'])->name('languages');
	    Route::get('/admin/languages/view/{id}', [LanguagesManagementController::class, 'view'])->name('languages.view');
	    Route::get('/admin/languages/create_form/', [LanguagesManagementController::class, 'createForm'])->name('languages.create_form');
	    Route::get('/admin/languages/edit_form/{id}', [LanguagesManagementController::class, 'editForm'])->name('languages.edit_form');
	    Route::get('/admin/languages/delete/{id?}', [LanguagesManagementController::class, 'delete'])->name('languages.delete');
	    Route::post('/admin/languages/update/', [LanguagesManagementController::class, 'update'])->name('languages.update');

	});
});