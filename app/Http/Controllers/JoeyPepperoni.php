<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;

class JoeyPepperoni extends Controller
{
    public function crcChallenge(Request $request) {
        Log::create([
            'url' => $request->url(),
            'method' => $request->method(),
            'body' => $request->getContent(),
            'ip' => $request->ip()
        ]);
    }
}
