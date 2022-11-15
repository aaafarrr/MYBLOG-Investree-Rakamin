<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\PassportAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api','prefix' => 'v1/auth'], function ($router) {
    Route::post('/', [PassportAuthController::class, 'index']);
    Route::post('login', [PassportAuthController::class,'login']);
    Route::post('register', [PassportAuthController::class,'register']);
});

Route::group(['middleware' => 'auth:api','prefix' => 'v1/auth'], function ($router) {
    Route::post('logout', [PassportAuthController::class,'logout']);
    Route::post('refresh', [PassportAuthController::class,'refresh']);
    Route::get('me', [PassportAuthController::class,'me']);
});

// categories 
Route::group(['prefix' => 'v1/categories','namespace'=>'categories'], function ($router) {
    Route::get('/', [CategoriesController::class, 'index']);
    Route::get('/{id}', [CategoriesController::class, 'show']);
    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('/', [CategoriesController::class, 'store']);
        Route::put('/{id}', [CategoriesController::class, 'update']);
        Route::delete('/{id}', [CategoriesController::class, 'destroy']);
    });
});

// articles
Route::group(['prefix' => 'v1/articles','namespace'=>'articles'], function ($router) {
    Route::get('/', [ArticlesController::class, 'index']);
    Route::get('/{id}', [ArticlesController::class, 'show']);
    Route::get('/paginate/{page}', [ArticlesController::class, 'paginate']);
    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('/', [ArticlesController::class, 'store']);
        Route::put('/{id}', [ArticlesController::class, 'update']);
        Route::post('/{id}', [ArticlesController::class, 'update']);
        Route::delete('/{id}', [ArticlesController::class, 'destroy']);
    });
});

