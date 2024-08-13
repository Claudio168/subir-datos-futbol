<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Espana\CopaRey2023;
use App\Models\Espana\CopaReyStat2023;

class Pruebas extends Controller
{
    public function index()
    {

        if(CopaRey2023::where('league_round', '!=', 'Preliminary Round')){
             
            echo "SI";

        }else{
            echo "NO";
        }
    }
}
