<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ProductRatingController;
use App\Http\Controllers\NewsLetterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function ()
{
    Route::apiResource('products', 'ProductController');
    Route::middleware('auth:sanctum')->post('products/rate', [ProductController::class, 'rate']);
    Route::post('products/{product}/rate', [ProductRatingController::class, 'rate']);
    Route::post('products/{product}/unrate', [ProductRatingController::class, 'unrate']);
    Route::post('/newsletter', [NewsLetterController::class, 'send']);
    Route::post('logout', [AuthController::class, 'logout']);
});
//'auth:api'
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
