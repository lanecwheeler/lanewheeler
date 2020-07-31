<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Log;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class JoeyPepperoni extends Controller
{
    // https://github.com/twitterdev/account-activity-dashboard
    // this repo will save your life for registering webhooks/subscriptions

    public function crcChallenge(Request $request) {
        $crc_token = $request->get('crc_token');

        Log::create([
            'url' => $request->url(),
            'method' => $request->method(),
            'body' => json_encode($request->all()),
            'ip' => $request->ip()
        ]);

        if($crc_token){
            $hash = hash_hmac('sha256', $crc_token, config('twitter.consumer_secret'),true);

            return response()->json(['response_token' => 'sha256='.base64_encode($hash)]);
        }else{
            return response('Error: crc_token is missing from request', 400);
        }

    }

    public function addSub(Request $request) {
        $connection = new TwitterOAuth(
            config('twitter.consumer_key'),
            config('twitter.consumer_secret'),
            config('twitter.access_token'),
            config('twitter.access_secret')
        );

        $connection->post('/1.1/account_activity/all/AyJoeyPepperoni/subscriptions.json','');

        return response()->json($connection->getLastBody(), 200);
    }

    public function register() {
        $client = new Client(['base_uri' => 'https://api.twitter.com/1.1/account_activity/all/']);

        $response = $client->post('AyJoeyPepperoni/webhooks.json?url=https://lanewheeler.dev/webhook/twitter');
    }
}
