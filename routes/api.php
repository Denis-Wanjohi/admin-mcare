<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CommentsController;
use Illuminate\Support\Facades\Route;

Route::get('/data',[FrontendController::class,'index']);
Route::post('/comment',[CommentsController::class,'create']);
Route::post('/appointment',[FrontendController::class,'appointment']);