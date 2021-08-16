<?php
Route::group(['prefix' => 'api/trips'], function () {
    Route::post('/create', 'TripController@store');
    Route::post('/filter', 'TripController@filter');
    Route::post('/display/{slug}', 'TripController@displayTripBasedOnSlug');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/book', 'TripController@bookTrip');
    });
});
