<?php
// app/Services/TwilioService.php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $twilio;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->twilio = new Client($sid, $token);
    }

    public function sendOtpWhatsApp($to, $otp)
    {
        // Replace 'your_twilio_whatsapp_number' with your Twilio WhatsApp-enabled phone numberrgy
//        $from = 'whatsapp:+14155238886';
        $from = 'whatsapp:+16073182638';

        // Compose the message
        $message = "is your verification code. For your security, do not share this code";
//        $message = $otp;

        $this->twilio->messages->create("whatsapp:$to", [
            "contentSid" => "HXaff5a43ac089f827f6f2c198481bc036",
            "from" => $from,
            'body' => $message,
            "contentVariables" => json_encode([
                "1" => "$otp"
            ]),
            "messagingServiceSid" => "MG8e78f47389cf4fb1ce1ec9a2dcc02f7a"
        ]);

    }


    public function sendPdfToWhatsApp($to, $pdfUrl)
    {
        // Get your Twilio WhatsApp number from the configuration
        $from = 'whatsapp:+16073182638'; // Update with your Twilio WhatsApp number

        try {

            // Compose the message
            $message = "Dear Customer, Please find attached the Form you recently submitted for your reference.";
            $this->twilio->messages
                ->create("whatsapp:$to", // to
                    array(
                        "contentSid" => "HXec58d5353a3d40b3d02ba8f6a52b2fbf",
                        "from" => $from,
                        'body' => $pdfUrl,
                        "contentVariables" => json_encode(["1" => $pdfUrl]), // Set the content variable
                        'mediaUrl' => ["https://app.onestoneads.com/storage/app/pdf/form-value/". $pdfUrl],
                        "messagingServiceSid" => "MG8e78f47389cf4fb1ce1ec9a2dcc02f7a",

                        )
                );

            // Return success response or perform other actions if needed
            return response()->json(['message' => 'PDF file sent successfully via WhatsApp.']);
        } catch (\Exception $e) {
            // Handle exceptions gracefully, e.g., log the error and provide meaningful feedback
            error_log('Failed to send PDF file via WhatsApp: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send PDF file via WhatsApp.']);
        }
    }
}
