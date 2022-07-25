<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;

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
Route::get('/about', function () {
    return view('about');
});



//Contact Session
Route::get('/contact', [ContactController::class, 'index'])->name('con');


//Category Session


//Get all Category
Route::get('/category/all', [CategoryController::class, 'AllCat'])->name('All.category');

//Save New Category
Route::post('/category/add', [CategoryController::class, 'SaveCat'])->name('Add.category');

//Edit Category
Route::get('/category/edit/{id}', [CategoryController::class, 'EditCat']);

//Update Category
Route::post('/category/update/{id}', [CategoryController::class, 'UpdateCat']);

//SoftDelete Category
Route::get('/softdelete/category/{id}', [CategoryController::class, 'SoftDeleteCat']);

//Restotre SoftDeleted Category
Route::get('/category/restore/{id}', [CategoryController::class, 'RestoreCat'] );

//Final Delete Category
Route::get('/category/delete/{id}', [CategoryController::class, 'DeleteCat'] );




//Brand Session

Route::get('/brand/all', [BrandController::class, 'AllBrand'])->name('All.brand');

//Add New Brand
Route::post('/brand/add', [BrandController::class, 'SaveBrand'])->name('Add.brand');















//Authenticate Users
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {

        //Get All Users
        $users = User::all();
        return view('dashboard', compact('users'));
    })->name('dashboard');
});
