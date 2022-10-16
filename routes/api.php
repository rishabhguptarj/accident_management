<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsvUpload;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::post('uploadcsv',[CsvUpload::class,'uploadUsers']);
Route::post('uploadcsv',[CsvUpload::class,'uploadcsv']);
Route::post('files',[CsvUpload::class,'csvCron']);
Route::post('search',[CsvUpload::class,'filter_search']);
Route::post('perYear',[CsvUpload::class,'per_year_fatalities']);


