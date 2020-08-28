<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Errors;
use App\JoeyPepName;
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

    public function genName() {
        $names = file(public_path('FirstNames.txt'), FILE_IGNORE_NEW_LINES);
        $foods = file(public_path('ItalianFoods.txt'), FILE_IGNORE_NEW_LINES);

        $randomName = rand(0, count($names) - 1);
        $alliteration = (($randomName % 2) === 0);

        $selectedName = $names[$randomName];
        if($alliteration) {
            $oldFoods = $foods;
            $foods = array_values(collect($foods)->reject(function($food) use ($selectedName) {
               return substr($food, 0, 1) !== substr($selectedName, 0, 1);
            })->toArray());
        }

        if(!count($foods) > 0)
            $foods = $oldFoods;

        $randomFood = rand(0, count($foods) - 1);
        $selectedFood = $foods[$randomFood];

        return ucfirst($selectedName) . ' ' . ucfirst($selectedFood);
    }

    public function tweetTest() {
        $connection = new TwitterOAuth(
            config('twitter.consumer_key'),
            config('twitter.consumer_secret'),
            config('twitter.access_token'),
            config('twitter.access_secret')
        );

        $content = $connection->post("statuses/update", ["status" => "hello world"]);

        dd($content);
    }

    public function activity(Request $request) {
        try {
            Log::create([
                'url' => $request->url(),
                'method' => $request->method(),
                'body' => 'activity: ' . $request->getContent(),
                'ip' => $request->ip(),
            ]);

            $json = json_decode($request->getContent());
            $tweetId = $json->tweet_create_events[0]->id;
            $handle = $json->tweet_create_events[0]->user->screen_name;
            $uid = $json->tweet_create_events[0]->user->id;

            $joeyPepName = JoeyPepName::where('uid', $uid)->first();

            if($joeyPepName) $name = $joeyPepName->name;
            else {
                $name = $this->genName();
                JoeyPepName::create([
                    'uid' => $uid,
                    'name' => $name,
                ]);
            }


            $connection = new TwitterOAuth(
                config('twitter.consumer_key'),
                config('twitter.consumer_secret'),
                config('twitter.access_token'),
                config('twitter.access_secret')
            );


            $content = $connection->post("statuses/update", ["status" => '@' . $handle . " Well, if it isn't " . $name . '!']);
        } catch (\Throwable $ex) {
            Errors::create([
                'page' => $request->path(),
                'error_code' => $ex->getCode(),
                'error_message' => $ex->getMessage(),
                'ip' => $request->ip(),
            ]);
        }
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
