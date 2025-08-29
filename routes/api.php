<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Restaurant routes
Route::middleware('throttle:60,1')->group(function () {
    Route::apiResource('restaurants', RestaurantController::class)->only(['index', 'show']);
    
    // Analytics routes
    Route::get('restaurants/{restaurant}/trends', [AnalyticsController::class, 'orderTrends']);
    Route::get('analytics/top-restaurants', [AnalyticsController::class, 'topRestaurants']);
    Route::get('analytics/orders', [AnalyticsController::class, 'filteredOrders']);
    Route::get('dashboard/overview', [DashboardController::class, 'overview']);
});
