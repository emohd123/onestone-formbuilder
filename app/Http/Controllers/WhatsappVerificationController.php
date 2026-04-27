<?php

namespace App\Http\Controllers;

use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class WhatsappVerificationController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function index(){
        $user = Auth::user();
        if ($user->otp != null) {
            return redirect()->route('home');
        }
        return view('verification.formverification', compact('user'));

    }

    public function sendOtp(Request $request)
    {
        // Validate the user input (you should perform proper validation)
        $request->validate([
            'phone' => 'required',
            'countryCode' => 'required',
        ]);

        // Check if the phone number is already registered
        $phoneNumber = $request->input('countryCode') . $request->input('phone');
        $user = User::where('phone', $request->input('phone'))
            ->where('country_code', $request->input('countryCode'))
            ->first();

        if ($user && $user->id != Auth::id()) {
            // Phone number is already registered, redirect back with an error message
            return redirect()->back()->with('error', 'This WhatsApp number is already registered. Please use a different number.');
        }

        // Phone number is not registered, proceed with OTP generation and sending
        $otp = rand(100000, 999999); // Generate a 6-digit random number

        // Send OTP via Twilio for WhatsApp
        $this->twilioService->sendOtpWhatsApp($phoneNumber, $otp);

        // Store the OTP in the session or database
        $request->session()->put('otp', $otp);

        // Update user's phone number if it has changed
        $cc = $request->input('countryCode');
        $phone = $request->input('phone');
        $updateUser = Auth::user();

        if ($updateUser->country_code != $cc || $updateUser->phone != $phone) {
            $updateUser->country_code = $cc;
            $updateUser->phone = $phone;
            $updateUser->save();
        }

        $hiddenNumber = '*******' . substr($phoneNumber, -4);

        return view('verification.verification', compact('hiddenNumber'));
    }


    public function verifyOtp(Request $request)
    {

//        $request->validate([
//            'otp' => 'required|numeric',
//        ]);
        $user = Auth::user();
        if ($user->otp != null) {
            return redirect()->route('home');
        }
        $enteredOtp = $request->input('first') . $request->input('second') . $request->input('third') . $request->input('fourth') . $request->input('fifth') . $request->input('sixth');


//        $enteredOtp = $request->input('otp');
        $storedOtp = $request->session()->get('otp');


        if ($enteredOtp == $storedOtp) {


            // OTP is valid
            $request->session()->forget('otp'); // Clear the OTP from the session

            // Perform further actions (e.g., user registration, login, etc.)

            $user = Auth::user();
            $user->otp = $storedOtp;
            $user->update();
            return redirect()->route('home')->with('success', 'OTP verified successfully.');
        } else {
            // Invalid OTP
            return redirect()->back()->with('error', 'Invalid OTP. Please try again.');

        }
    }
}
