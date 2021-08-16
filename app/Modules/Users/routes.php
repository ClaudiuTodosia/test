<?php
Route::group(['prefix' => 'api/users'], function () {
    Route::post('/create', 'UserController@store');
    Route::post('/login', 'UserController@login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', 'UserController@logout');
    });
});
