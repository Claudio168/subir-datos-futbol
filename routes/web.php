<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pruebas;
use App\Http\Controllers\Subirpremierleaguefixtures;
use App\Http\Controllers\SubirLaLigaFixtureController;
use App\Http\Controllers\SubirElCalcioFixtureController;
use App\Http\Controllers\SubirLaBundesligaFixtureController;
use App\Http\Controllers\SubirLigue1fixture;
use App\Http\Controllers\SubirPrimeiraLigaFixture;
use App\Http\Controllers\SubirEredivisieController;
use App\Http\Controllers\SubirArgentinaController;
use App\Http\Controllers\SubirBrasilController;
use App\Http\Controllers\SubirChileController;
use App\Http\Controllers\SubirCopaChile;
use App\Http\Controllers\SubirColombiaController;
use App\Http\Controllers\SubirCopaColombia;
use App\Http\Controllers\SubirMexicoController;
use App\Http\Controllers\SubirFaCup;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SubirChampionLeague;
use App\Http\Controllers\SubirEuropaLeague;
use App\Http\Controllers\SubirEuropaConferenceLeague2023;
use App\Http\Controllers\SubirCopaLibertadores2024;
use App\Http\Controllers\SubirCopaSudamericana2024;
use App\Http\Controllers\SubirCopaRey;
use App\Http\Controllers\SubirCopaItalia;
use App\Http\Controllers\SubirDFB_Pokal;
use App\Http\Controllers\SubirCopaPortugal;
use App\Http\Controllers\SubirCopaPaisesBajos;
use App\Http\Controllers\SubirCopaDeLaLigaArgentina;
use App\Http\Controllers\SubirCopaFrancia;
use App\Http\Controllers\SubirCopaDeLaLigaInglaterra;
use App\Http\Controllers\SubirConcacafChampion;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pruebas', [Pruebas::class, 'index']);
//no es necesario esta autenticado
Route::get('/verlogs', [LogController::class, 'index']);
Route::get('/subirpremierleaguefixtures', [Subirpremierleaguefixtures::class, 'index']);
Route::get('/subirLaligafixtures', [SubirLaLigaFixtureController::class, 'index']);
Route::get('/subirElCalcioFixtures', [SubirElCalcioFixtureController::class, 'index']);
Route::get('/subirLaBundesligaFixtures', [SubirLaBundesligaFixtureController::class, 'index']);
Route::get('/subirPrimeiraLigaFixture', [SubirPrimeiraLigaFixture::class, 'index']);
Route::get('/subirLigue1fixture', [SubirLigue1fixture::class, 'index']);
Route::get('/subirLigaEredivisie', [SubirEredivisieController::class, 'index']);
Route::get('/subirLigaArgentina', [SubirArgentinaController::class, 'index']);
Route::get('/subirLigaBrasil', [SubirBrasilController::class, 'index']);
Route::get('/subirLigaChile', [SubirChileController::class, 'index']);
Route::get('/subirCopaChile', [SubirCopaChile::class, 'index']);
Route::get('/subirLigaColombia', [SubirColombiaController::class, 'index']);
Route::get('/subirCopaColombia', [SubirCopaColombia::class, 'index']);
Route::get('/subirLigaMexico', [SubirMexicoController::class, 'index']);
Route::get('/subirFACup', [SubirFaCup::class, 'index']);
Route::get('/subirchampionleague', [SubirChampionLeague::class, 'index']);
Route::get('/subireuropaleague', [SubirEuropaLeague::class, 'index']);
Route::get('/SubirEuropaConferenceLeague', [SubirEuropaConferenceLeague2023::class, 'index']);
Route::get('/SubirCopaLibertadores', [SubirCopaLibertadores2024::class, 'index']);
Route::get('/SubirCopaSudamericana', [SubirCopaSudamericana2024::class, 'index']);
Route::get('/SubirCopaRey', [SubirCopaRey::class, 'index']);
Route::get('/SubirCopaItalia', [SubirCopaItalia::class, 'index']);
Route::get('/SubirDFB_Pokal', [SubirDFB_Pokal::class, 'index']);
Route::get('/SubirCopaPortugal', [SubirCopaPortugal::class, 'index']);
Route::get('/SubirCopaPaisesbajos', [SubirCopaPaisesBajos::class, 'index']);
Route::get('/SubirCopaDeLaLigaArgentina', [SubirCopaDeLaLigaArgentina::class, 'index']);
Route::get('/SubirCopaFrancia', [SubirCopaFrancia::class, 'index']);
Route::get('/SubirCopaDeLaLigaInglaterra', [SubirCopaDeLaLigaInglaterra::class, 'index']);
Route::get('/SubirConcacafChampion', [SubirConcacafChampion::class, 'index']);









