<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\Email;
use App\Services\Fast2SMSService;
class WelcomeController extends Controller
{
    protected $fast2SMSService;

    public function __construct(Fast2SMSService $fast2SMSService)
    {
        $this->fast2SMSService = $fast2SMSService;
    }

    public function index()
    {
        return view('welcome');
    }
    public function sendMail(Request $request)
    {
        $email = $request->query('email');
        $otp = rand(100000, 999999); // Generate a 6-digit OTP
        $mailData = [
            'page' => 'mail',
            'data' => $otp
        ];
        Mail::to($email)->send(new Email($mailData));
        return view('welcome');
    }
    public function sendOtp(Request $request)
    {
        $phone = $request->query('phone');
        $otp = rand(100000, 999999); // Generate a 6-digit OTP
        $message = "Your OTP is: $otp";
        $response = $this->fast2SMSService->sendOtp($phone, $message);
        return view('welcome');
    }
    
}
