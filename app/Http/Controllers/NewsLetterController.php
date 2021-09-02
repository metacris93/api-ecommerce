<?php

namespace App\Http\Controllers;

use App\Console\Commands\SendEmailVerificationReminderCommand;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class NewsLetterController extends Controller
{
    public function send()
    {
        Artisan::call(SendEmailVerificationReminderCommand::class);
        return response()->json([
            'data' => 'Todo OK'
        ]);
    }
}
