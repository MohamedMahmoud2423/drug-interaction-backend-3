<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;


class EmailController extends Controller
{
    public function sendWelcomeEmail(){
        $toEmail = 'safytarek772@gmail.com';
        $message = 'Welcome to our website';
        $subject = 'Welcome Email In Laravel Using Gmail';

        $response = Mail::to($toEmail)->send(new WelcomeEmail($message , $subject));
        dd($response);
        
    }
}
