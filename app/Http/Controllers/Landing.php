<?php

namespace App\Http\Controllers;

use App\Contacts;
use App\Errors;
use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Landing extends Controller
{
    //
    public function index() {
        $rand = rand(0,360);
        while($rand <= 90 && $rand >= 30)
            $rand = rand(0,360);
        return view('landing')->with('rand', $rand);
    }

    public function showLogs() {
        $logs = Log::all();

        return view('logs')->with('logs', $logs);
    }

    public function showErrorLogs() {
        $logs = Errors::all();

        return view('errors')->with('logs', $logs);
    }

    public function colors() {
        return view('colors');
    }

    public function sendContact(Request $request) {

        try {


            Contacts::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'message' => $request->get('message'),
                'favorite' => $request->get('favorite') . ': ' . $request->get('selectedFavorite'),
            ]);

            Mail::send('emails.contact', [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'message' => $request->get('message'),
                'favorite' => $request->get('favorite'),
                'favoriteSelected' => $request->get('favoriteSelected'),
            ], function($message) {
                $message->to('contactform@lanewheeler.dev', 'Lane')
                    ->subject('New Contact Form Submission');
                $message->from(config('mail.from.address'),'theHub');
            });

        } catch(\Throwable $ex) {
            Errors::create([
                'page' => $request->path(),
                'error_code' => $ex->getCode(),
                'error_message' => $ex->getMessage(),
                'ip' => $request->ip(),
            ]);

            Mail::send('emails.contact', $request->all(), function($message) {
                $message->to('contactform@lanewheeler.dev', 'Lane')
                    ->subject('Error sending contact');
                $message->from(config('mail.from.address'),'theHub');
            });
            return response()->json($ex->getMessage(), 500);
        }

        return response()->json('Thanks!', 200);
    }
}
