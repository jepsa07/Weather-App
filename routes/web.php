<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\WeatherController;

Route::get('/', [WeatherController::class, 'index']);
Route::get('/weather', [WeatherController::class, 'getWeather'])->name('weather');
Route::get('/location-weather', [WeatherController::class, 'getWeatherByLocation'])
    ->name('location.weather');
