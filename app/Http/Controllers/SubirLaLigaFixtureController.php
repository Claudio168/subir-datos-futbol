<?php

namespace App\Http\Controllers;

use App\Models\Espana\SubirLaLigaFixture2023;
use App\Models\Espana\FixtureLaLigaStat;
use App\Models\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Twilio\Rest\Client;

class SubirLaLigaFixtureController extends Controller
{
    public function index()
    {
        //set_time_limit(3600);
        $fechaHoy = Carbon::now()->toDateString(); // Obtiene la fecha actual en formato 'Y-m-d'
        //$fechaAyer = Carbon::now()->subDay()->toDateString();
        $year = '2023';
        $liga = 140;
        $from = '2023-08-10';
        $to =  $fechaHoy;
        // Realizar la solicitud a la API
        $response = Http::withHeaders([
            'x-rapidapi-host' => 'v3.football.api-sports.io',
            'x-rapidapi-key' => '22240ee711b7e2faa6b80fa55809e7db'
        ])->get('https://v3.football.api-sports.io/fixtures', [
            'status' => 'FT',
            'league' =>  $liga,
            'season' =>  $year,
            'from' =>  $from,
            'to' =>  $to,
        ]);

        // Verificar si la solicitud fue exitosa (código de respuesta 200)
        if ($response->ok()) {

            $log = new Log();
            // Obtener el contenido de la respuesta como arreglo asociativo
            $data = $response->json();

            if (isset($data['errors']) && $data['errors'] !== []) {
                // Hay un mensaje de error, la API no pudo devolver datos
                $message = "Error: " . $data['errors']['requests'];
                //Enviar mensaje de WhatsApp
                $this->sendWhatsAppMessage($message);
                //guardar registro en log
                $log->message = $message;
                $log->save();
                return $message;
            }
            if ($data['response'] == []) {
                //NO hay datos para guardar en la BD
                // Enviar mensaje de WhatsApp
                $message = "NO hay datos para guardar para: Liga (" . $liga . ") Temporada " . $year . " para la fecha " . $from . " / " . $to;
                $this->sendWhatsAppMessage($message);
                //guardar registro en log
                $log->message = $message;
                $log->save();
                return $message;
            }
            // Verificar si hay datos de respuesta y si contiene la clave 'response' con datos de fixtures
            if (isset($data['response']) && is_array($data['response'])) {
                $contadorPartidos = 0;
                $contadorStats = 0;
                foreach ($data['response'] as $fixtureData) {
                    // Verificar si ya existe un registro con el mismo fixture_id para fixture o para stats
                    if (!SubirLaLigaFixture2023::where('fixture_id', $fixtureData['fixture']['id'])->exists() || !FixtureLaLigaStat::where('fixture_id', $fixtureData['fixture']['id'])->exists()) {


                        $fechaString =  $fixtureData['fixture']['date'];
                        $fechaFormateada = Carbon::parse($fechaString)->toDateString();

                        $timestamp = $fixtureData['fixture']['timestamp'];
                        $fechaHora = Carbon::createFromTimestamp($timestamp)->toDateTimeString();

                        if (!SubirLaLigaFixture2023::where('fixture_id', $fixtureData['fixture']['id'])->exists()) {
                            $contadorPartidos++;
                            //se rellena la tabla premierleaguefixture
                            $fixtures = SubirLaLigaFixture2023::create([
                                'fixture_date' => $fechaFormateada,
                                'fixture_id' =>  $fixtureData['fixture']['id'],
                                'fixture_referee' =>  $fixtureData['fixture']['referee'],
                                'fixture_timestamp' => $fechaHora,
                                'goals_away' =>  $fixtureData['goals']['away'],
                                'goals_home' => $fixtureData['goals']['home'],
                                'league_country' =>  $fixtureData['league']['country'],
                                'league_id' => $fixtureData['league']['id'],
                                'league_name' => $fixtureData['league']['name'],
                                'league_round' => $fixtureData['league']['round'],
                                'league_season' => $fixtureData['league']['season'],
                                'teams_home_id' => $fixtureData['teams']['home']['id'],
                                'teams_home_name' => $fixtureData['teams']['home']['name'],
                                'teams_home_logo' => $fixtureData['teams']['home']['logo'],
                                'teams_home_winner' => $fixtureData['teams']['home']['winner'],
                                'teams_away_id' => $fixtureData['teams']['away']['id'],
                                'teams_away_name' => $fixtureData['teams']['away']['name'],
                                'teams_away_logo' => $fixtureData['teams']['away']['logo'],
                                'teams_away_winner' => $fixtureData['teams']['away']['winner'],
                                'score_extratime_home' => $fixtureData['score']['extratime']['home'],
                                'score_extratime_away' => $fixtureData['score']['extratime']['away'],
                                'score_fulltime_home'  => $fixtureData['score']['fulltime']['home'],
                                'score_fulltime_away' => $fixtureData['score']['fulltime']['away'],
                                'score_halftime_home' => $fixtureData['score']['halftime']['home'],
                                'score_halftime_away' => $fixtureData['score']['halftime']['away'],
                                'score_penalty_home' => $fixtureData['score']['penalty']['home'],
                                'score_penalty_away' => $fixtureData['score']['penalty']['away'],
                            ]);
                        }

                        if (!FixtureLaLigaStat::where('fixture_id', $fixtureData['fixture']['id'])->exists()) {
                            //subir las estadisticas del partido
                            $response2 = Http::withHeaders([
                                'x-rapidapi-host' => 'v3.football.api-sports.io',
                                'x-rapidapi-key' => '22240ee711b7e2faa6b80fa55809e7db'
                            ])->get('https://v3.football.api-sports.io/fixtures/statistics', [
                                'fixture' => $fixtureData['fixture']['id'],
                            ]);

                            // Verificar si la solicitud fue exitosa (código de respuesta 200)
                            if ($response2->ok()) {
                                // Obtener el contenido de la respuesta como arreglo asociativo
                                $data2 = $response2->json();
                                if (isset($data2['errors']) && $data2['errors'] !== []) {
                                    // Hay un mensaje de error, la API no pudo devolver datos
                                    $message = "Error al tratar de subir las estadísticas para el fixture: " . $fixtureData['fixture']['id'];
                                    //guardar registro en log
                                    $log->message = $message;
                                    $log->save();
                                    return $message;
                                }
                                if ($data2['response'] == []) {
                                    //NO hay datos para guardar en la BD
                                    $message = "NO hay estadísticas para guardar para el fixture: " . $fixtureData['fixture']['id'];
                                    //guardar registro en log
                                    $log->message = $message;
                                    $log->save();
                                }
                                // Verificar si hay datos de respuesta y si contiene la clave 'response' con datos de fixtures
                                if (isset($data2['response']) && is_array($data2['response'])) {

                                    foreach ($data2['response'] as $indice => $fixtureData2) {
                                        if (!FixtureLaLigaStat::where('fixture_id', $fixtureData['fixture']['id'])->exists()) {
                                            $contadorStats++;
                                            FixtureLaLigaStat::create([
                                                'fixture_date' => $fechaFormateada,
                                                'fixture_id' => $fixtureData['fixture']['id'],
                                                'fixture_referee' =>  $fixtureData['fixture']['referee'],
                                                'fixture_timestamp' => $fechaHora,
                                                'goals_home' => $fixtureData['goals']['home'],
                                                'goals_away' =>  $fixtureData['goals']['away'],
                                                'score_halftime_home' => $fixtureData['score']['halftime']['home'],
                                                'score_halftime_away' => $fixtureData['score']['halftime']['away'],
                                                'score_fulltime_home'  => $fixtureData['score']['fulltime']['home'],
                                                'score_fulltime_away' => $fixtureData['score']['fulltime']['away'],
                                                'teams_home_id' => $fixtureData['teams']['home']['id'],
                                                'teams_away_id' => $fixtureData['teams']['away']['id'],
                                                'teams_home_name' => $fixtureData['teams']['home']['name'],
                                                'teams_away_name' => $fixtureData['teams']['away']['name'],

                                                "shots_on_goal" => $fixtureData2['statistics'][0]['value'],
                                                "shots_off_goal"  => $fixtureData2['statistics'][1]['value'],
                                                "total_shots"  => $fixtureData2['statistics'][2]['value'],
                                                "blocked_shots"  => $fixtureData2['statistics'][3]['value'],
                                                "shots_inside_box"  => $fixtureData2['statistics'][4]['value'],
                                                "shots_outside_box" => $fixtureData2['statistics'][5]['value'],
                                                "fouls"  => $fixtureData2['statistics'][6]['value'],
                                                "corner_kicks"  => $fixtureData2['statistics'][7]['value'],
                                                "offsides"  => $fixtureData2['statistics'][8]['value'],
                                                "ball_possession" => $fixtureData2['statistics'][9]['value'],
                                                "yellow_cards" => $fixtureData2['statistics'][10]['value'],
                                                "red_cards" => $fixtureData2['statistics'][11]['value'],
                                                "goalkeeper_saves"  => $fixtureData2['statistics'][12]['value'],
                                                "total_passes"  => $fixtureData2['statistics'][13]['value'],
                                                "passes_accurate"  => $fixtureData2['statistics'][14]['value'],
                                                "passes_percentage" => $fixtureData2['statistics'][15]['value'],
                                                "expected_goals"  => $fixtureData2['statistics'][16]['value'],

                                                "shots_on_goal2" => $data2['response'][1]['statistics'][0]['value'],
                                                "shots_off_goal2"  => $data2['response'][1]['statistics'][1]['value'],
                                                "total_shots2"  => $data2['response'][1]['statistics'][2]['value'],
                                                "blocked_shots2"  => $data2['response'][1]['statistics'][3]['value'],
                                                "shots_inside_box2"  => $data2['response'][1]['statistics'][4]['value'],
                                                "shots_outside_box2" => $data2['response'][1]['statistics'][5]['value'],
                                                "fouls2"  => $data2['response'][1]['statistics'][6]['value'],
                                                "corner_kicks2"  => $data2['response'][1]['statistics'][7]['value'],
                                                "offsides2"  => $data2['response'][1]['statistics'][8]['value'],
                                                "ball_possession2" => $data2['response'][1]['statistics'][9]['value'],
                                                "yellow_cards2" => $data2['response'][1]['statistics'][10]['value'],
                                                "red_cards2" => $data2['response'][1]['statistics'][11]['value'],
                                                "goalkeeper_saves2"  => $data2['response'][1]['statistics'][12]['value'],
                                                "total_passes2"  => $data2['response'][1]['statistics'][13]['value'],
                                                "passes_accurate2"  => $data2['response'][1]['statistics'][14]['value'],
                                                "passes_percentage2" => $data2['response'][1]['statistics'][15]['value'],
                                                "expected_goals2"  => $data2['response'][1]['statistics'][16]['value'],


                                            ]);
                                        }
                                    }
                                } else {
                                    $message = "Error al tratar de subir las estadísticas para el fixture: " . $fixtureData['fixture']['id'];
                                    //guardar registro en log
                                    $log->message = $message;
                                    $log->save();
                                    return $message;
                                }
                            } else {

                                $message = "Error al tratar de subir las estadísticas para el fixture: " . $fixtureData['fixture']['id'];
                                //guardar registro en log
                                $log->message = $message;
                                $log->save();
                                return $message;
                            }
                            //fin de subida de estadisticas
                            //sleep(7);
                        }
                      
                    }
                   
                }
                //fin de foreach
                // Verificar si se guardaron datos en la BD o no
                if ($contadorPartidos > 0 || $contadorStats > 0) {
                    $message = "Se han guardados correctamente " . $contadorPartidos . " partidos y " . $contadorStats . " estadisticas para la Liga (" . $liga . ") Temporada " . $year . " para la fecha: " . $from . " / " . $to;
                    // Enviar mensaje de WhatsApp
                    $this->sendWhatsAppMessage($message);
                    //guardar registro en log
                    $log->message = $message;
                    $log->fixture_id = $fixtureData['fixture']['id'];
                    $log->fixture_date = $fechaFormateada;
                    $log->save();
                    return $message;
                } else {
                    $message = "No hay datos nuevos para guardar para la liga: (" . $liga . ") Temporada " . $year . " para la fecha: " . $from . " / " . $to;
                    //guardar registro en log
                    $log->message = $message;
                    $log->save();
                    return $message;
                }
            } else {
                $message = "No hay datos de respueta con datos de fixtures";
                $log = new Log();
                //guardar registro en log
                $log->message = $message;
                $log->save();
                return $message;
            }
        } else {
            $message = "No hay respueta de la API";
            $log = new Log();
            //guardar registro en log
            $log->message = $message;
            $log->save();
            return $message;
        }
    }

    private function sendWhatsAppMessage($message)
    {
        try {
            $sid    = config('services.twilio.sid');
            $token  = config('services.twilio.auth_token');
            $from   = config('services.twilio.whatsapp_from');
            $to     = config('services.twilio.whatsapp_to');

            $client = new Client($sid, $token);

            $client->messages->create(
                $to,
                [
                    'from' => $from,
                    'body' => $message,
                ]
            );

            // Éxito al enviar el mensaje
            return true;
        } catch (\Exception $e) {
            // Captura la excepción y muestra el mensaje de error
            return $e->getMessage();
        }
    }
}

