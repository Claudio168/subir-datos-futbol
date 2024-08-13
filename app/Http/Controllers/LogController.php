<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use PhpParser\Node\Expr\New_;

class LogController extends Controller
{
    public function index(){
        $logs = Log::orderBy('id', 'DESC')->get();

        return view('log', compact('logs'));

    }
}
