<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
        return view('weather');
    }

  public function getWeather(Request $request)
{
    $city = $request->city;
    $apiKey = env('WEATHER_API_KEY');

    // Current weather
    $current = Http::get('https://api.openweathermap.org/data/2.5/weather', [
        'q' => $city,
        'appid' => $apiKey,
        'units' => 'metric'
    ]);

    if ($current->failed()) {
        return back()->with('error', 'City not found');
    }

    $weather = $current->json();

    // Hourly forecast (3-hour intervals)
    $forecast = Http::get('https://api.openweathermap.org/data/2.5/forecast', [
        'q' => $city,
        'appid' => $apiKey,
        'units' => 'metric'
    ])->json();

    return view('weather', compact('weather', 'forecast'));
}

public function getWeatherByLocation(Request $request)
{
    $lat = $request->lat;
    $lon = $request->lon;
    $apiKey = env('WEATHER_API_KEY');

    // Current weather
    $current = Http::get('https://api.openweathermap.org/data/2.5/weather', [
        'lat' => $lat,
        'lon' => $lon,
        'appid' => $apiKey,
        'units' => 'metric'
    ]);

    if ($current->failed()) {
        return back()->with('error', 'Unable to detect location weather.');
    }

    $weather = $current->json();

    // Hourly forecast (3-hour interval)
    $forecast = Http::get('https://api.openweathermap.org/data/2.5/forecast', [
        'lat' => $lat,
        'lon' => $lon,
        'appid' => $apiKey,
        'units' => 'metric'
    ])->json();

    return view('weather', compact('weather', 'forecast'));
}


}
