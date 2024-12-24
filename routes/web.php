<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return app()->make('\App\Http\Controllers\MainController')->getHome();
});
