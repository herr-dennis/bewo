<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return app()->make('\App\Http\Controllers\MainController')->getHome();
});
Route::get('ÜberUns', function () {
    return app()->make('\App\Http\Controllers\MainController')->getAboutUs();
});
Route::get('Impressum', function () {
    return app()->make('\App\Http\Controllers\MainController')->getImpressum();
});
Route::get('Datenschutz', function () {
    return app()->make('\App\Http\Controllers\MainController')->getDatenschutz();
});
Route::get('Termine', function () {
    return app()->make('\App\Http\Controllers\MainController')->getTermine();
});

Route::get('Kontakt', function () {
    return app()->make('\App\Http\Controllers\MainController')->getKontakt();
});

Route::get('BetreutesWohnen', function () {
    return app()->make('\App\Http\Controllers\MainController')->getBetreutes();
});

Route::get('Soziotherapie', function () {
    return app()->make('\App\Http\Controllers\MainController')->getSozio();
});

Route::get('HilfeJungeErwachsene', function () {
    return app()->make('\App\Http\Controllers\MainController')->getHilfe();
});

Route::get('Team', function () {

    return app()->make('\App\Http\Controllers\MainController')->getTeam();
});

Route::get('Jobs', function () {
    return app()->make('\App\Http\Controllers\MainController')->getJobs();
});

Route::get('Kooperationen', function () {
    return app()->make('\App\Http\Controllers\MainController')->getKoor();
});

Route::get('Login', function () {
    return app()->make('\App\Http\Controllers\MainController')->getLogin();
});

Route::post('Login', function (Request $request) {
    return app()->make('\App\Http\Controllers\MainController')->verifizierung($request);
});

Route::get('Verwaltung', function () {
    return app()->make('\App\Http\Controllers\MainController')->getVerwaltung();

})->name('Verwaltung');

Route::post('insertVerwaltung', function (Request $request) {
    return app()->make('\App\Http\Controllers\MainController')->insertVerwaltung($request);
})->name("insertVerwaltung");

Route::get('Übersicht', function () {
    return app()->make('\App\Http\Controllers\MainController')->getÜbersicht();
});
Route::post('Delete', function (Request $request) {
    return app()->make('\App\Http\Controllers\MainController')->deleteUser($request);
})->name("Delete");
