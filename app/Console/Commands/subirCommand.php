<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Subirpremierleaguefixtures;
use App\Http\Controllers\SubirLaLigaFixtureController;
use App\Http\Controllers\SubirElCalcioFixtureController;
use App\Http\Controllers\SubirLaBundesligaFixtureController;
use App\Http\Controllers\SubirLigue1fixture;
use App\Http\Controllers\SubirPrimeiraLigaFixture;
use App\Http\Controllers\SubirColombiaController;
use App\Http\Controllers\SubirEredivisieController;
use App\Http\Controllers\SubirArgentinaController;
use App\Http\Controllers\SubirBrasilController;
use App\Http\Controllers\SubirChileController;
use App\Http\Controllers\SubirMexicoController;
use App\Http\Controllers\SubirCopaChile;
use App\Http\Controllers\SubirCopaColombia;
use App\Http\Controllers\SubirFaCup;
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


class subirCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subir:datos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'subida de datos a la BD';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        app(Subirpremierleaguefixtures::class)->index();
        sleep(120);
        app(SubirLaLigaFixtureController::class)->index();
        sleep(120);
        app(SubirElCalcioFixtureController::class)->index();
        sleep(120);
        app(SubirLaBundesligaFixtureController::class)->index();
        sleep(120);
        app(SubirLigue1fixture::class)->index();
        sleep(120);
        app(SubirEredivisieController::class)->index();
        sleep(120);
        app(SubirPrimeiraLigaFixture::class)->index();
        sleep(120);
        app(SubirBrasilController::class)->index();
        sleep(120);
        app(SubirChileController::class)->index();
        sleep(120);
        app(SubirArgentinaController::class)->index();
        sleep(120);
        app(SubirColombiaController::class)->index();
        sleep(120);
        app(SubirMexicoController::class)->index();
        sleep(120);
        app(SubirCopaChile::class)->index();
        sleep(120);
        app(SubirCopaColombia::class)->index();
        sleep(120);
        app(SubirFaCup::class)->index();
        sleep(120);
        app(SubirChampionLeague::class)->index();
        sleep(120);
        app(SubirEuropaLeague::class)->index();
        sleep(120);
        app(SubirEuropaConferenceLeague2023::class)->index();
        sleep(120);
        app(SubirCopaLibertadores2024::class)->index();
        sleep(120);
        app(SubirCopaSudamericana2024::class)->index();
        sleep(120);
        app(SubirCopaRey::class)->index();
        sleep(120);
        app(SubirCopaItalia::class)->index();
        sleep(120);
        app(SubirDFB_Pokal::class)->index();
        sleep(120);
        app(SubirCopaPortugal::class)->index();
        sleep(120);
        app(SubirCopaPaisesBajos::class)->index();
        sleep(120);
        app(SubirCopaDeLaLigaArgentina::class)->index();
        sleep(120);
        app(SubirCopaFrancia::class)->index();
        sleep(120);
        app(SubirCopaDeLaLigaInglaterra::class)->index();
        sleep(120);
        app(SubirConcacafChampion::class)->index();
        sleep(120);
        
    }
}
