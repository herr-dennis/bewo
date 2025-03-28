<?php

use App\Http\Controllers\SitemapController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/', function () {
    return app()->make('\App\Http\Controllers\MainController')->getHome();
})->middleware(\App\Http\Middleware\CookieConsentMiddleware::class);

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
})->name('Kontakt');

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

Route::get('Admin', function () {
    return app()->make('\App\Http\Controllers\MainController')->getLogin();
});

Route::post('Admin', function (Request $request) {
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
})->name("Übersicht");

Route::post('Delete', function (Request $request) {
    return app()->make('\App\Http\Controllers\MainController')->deleteUser($request);
})->name("Delete");

Route::post('insertNewsletter', function (Request $request) {
    return app()->make('\App\Http\Controllers\MainController')->insertNewsletter($request);
})->name("insertNewsletter");

Route::post('sendKontakt', function (Request $request) {
    return app()->make('\App\Http\Controllers\MainController')->sendKontakt($request);
})->name("sendKontakt");

Route::get('Abmelden', function () {
    return app()->make('\App\Http\Controllers\MainController')->abmelden();
});

Route::get('/generate-sitemap', [SitemapController::class, 'generateSitemap']);

Route::get('Logs', function () {
    return app()->make('\App\Http\Controllers\MainController')->getLogs();
})->name('Logs');

Route::get('LogLöschen', function () {
    return app()->make('\App\Http\Controllers\MainController')->logLöschen();
})->name('LogLöschen');
