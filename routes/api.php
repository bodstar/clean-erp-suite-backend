<?php

use App\Http\Controllers\Api\MPromo\PartnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\ResolveTeamFromHeader;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('switch-team', [AuthController::class, 'switchTeam']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

// Test route (optional)
Route::middleware(['auth:sanctum', ResolveTeamFromHeader::class])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', ResolveTeamFromHeader::class])
    ->prefix('mpromo')
    ->group(function () {
        Route::get('partners', [PartnerController::class, 'index']);
        Route::post('partners', [PartnerController::class, 'store']);
        Route::get('partners/{partner}', [PartnerController::class, 'show']);
        Route::put('partners/{partner}', [PartnerController::class, 'update']);

        Route::put('partners/{partner}/geolocation', [PartnerController::class, 'updateGeolocation']);
        Route::post('partners/{partner}/suspend', [PartnerController::class, 'suspend']);
        Route::post('partners/{partner}/activate', [PartnerController::class, 'activate']);
    });

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
