<?php

namespace App\Http\Controllers;

use App\Jobs\SendWelcomeEmail;
use App\Traits\ApiResponser;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    use ApiResponser;
    public function verify(EmailVerificationRequest $request)
    {
        /*
        if ($request->user()->hasVerifiedEmail()) {
            return [
                'message' => 'Email already verified'
            ];
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return [
            'message'=>'Email has been verified'
        ];
        */
        $request->fulfill();
        dispatch(new SendWelcomeEmail($request->user()->email));
        return $this->success([
            'message'=>'Email has been verified'
        ], 'OK');
    }
}
