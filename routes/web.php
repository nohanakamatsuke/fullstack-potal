<?php

use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get( '/', [ SessionController::class, 'session' ] );


Route::get( '/login', function(){
  return view('login');
});

