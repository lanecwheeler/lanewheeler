<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Log;
use Illuminate\Http\Request;

class JoeyPepperoni extends Controller
{
    public function crcChallenge(Request $request) {
        $crc_token = $request->get('crc_token');

        Log::create([
            'url' => $request->url(),
            'method' => $request->method(),
            'body' => json_encode($request->getContent()),
            'ip' => $request->ip()
        ]);

        if($crc_token){
            $hash = base64_encode(hash_hmac('sha256', $crc_token, env('TWITTER_SECRET')));

            return response()->json(['response_token' => 'sha256='.$hash]);
        }else{
            return response('Error: crc_token is missing from request', 400);
        }

    }
}
