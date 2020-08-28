<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Log;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class JoeyPepperoni extends Controller
{
    // https://github.com/twitterdev/account-activity-dashboard
    // this repo will save your life for registering webhooks/subscriptions

    public function crcChallenge(Request $request) {
        $crc_token = $request->get('crc_token');

        Log::create([
            'url' => $request->url(),
            'method' => $request->method(),
            'body' => 'crcChallenge: ' . json_encode($request->all()),
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
        $content = $connection->post('account_activity/all/AyJoeyPepperoni/subscriptions');

        dd($connection, $content);

        $connection->post('/account_activity/all/AyJoeyPepperoni/subscriptions.json',[]);

        return response()->json($connection->getLastBody(), 200);
    }

    public function register() {
        $client = new Client(['base_uri' => 'https://api.twitter.com/1.1/account_activity/all/']);

        $response = $client->post('AyJoeyPepperoni/webhooks.json?url=https://lanewheeler.dev/webhook/twitter');
    }

    public function activity(Request $request) {
        Log::create([
            'url' => $request->url(),
            'method' => $request->method(),
            'body' => 'activity: ' . $request->getContent(),
            'ip' => $request->ip(),
        ]);

        Mail::send('emails.contact', [
            'request' => $request,
        ], function($message) {
            $message->to('twitter@lanewheeler.dev', 'Lane')
                ->subject('New Activity');
            $message->from(config('mail.from.address'),'theHub');
        });

        $connection = new TwitterOAuth(
            config('twitter.consumer_key'),
            config('twitter.consumer_secret'),
            config('twitter.access_token'),
            config('twitter.access_secret')
        );

        $content = $connection->post("statuses/update", ["text" => "hello world"]);

//        Log::create([
//            'url' => $connection->response->apiPath,
//            'method' => '',
//            'body' => json_decode($content),
//            'ip' => '',
//        ]);
    }

    public function getHooks(Request $request) {
        $connection = new TwitterOAuth(
            config('twitter.consumer_key'),
            config('twitter.consumer_secret'),
            config('twitter.access_token'),
            config('twitter.access_secret')
        );

        $content = $connection->get('account_activity/all/AyJoeyPepperoni/subscriptions');

        dd($connection, $content);
    }
}
