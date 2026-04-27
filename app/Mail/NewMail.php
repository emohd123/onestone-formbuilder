<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdfUrl;

    public function __construct($pdfUrl)
    {
        $this->pdfUrl = $pdfUrl;
    }

    public function build()
    {
        $pdfPath = 'https//' . $this->pdfUrl; // Assuming the PDF is stored in the storage/app/pdf directory

        return $this->markdown('emails.consomer-form-submit')
            ->with(['message' => 'Dear Customer, Please find attached
            the Form you recently submitted
            for your reference. '])
        ->attach("https://app.onestoneads.com/storage/app/pdf/form-value/". $this->pdfUrl) // Attach PDF
            ->subject('New Feedback Submitted - ');
    }
}

//class NewMail extends Mailable
//{
//    use Queueable, SerializesModels;
//
//
//
//    protected $pdfUrl;
//
//    public function __construct()
//    {
//
////        $this->pdfUrl   = $pdfUrl;
//    }
//
//    public function build()
//    {
//
////        $pdf = 'https://'. $this->pdfUrl;
//        return $this->markdown('emails.consomer-form-submit')
////            ->with(['formValue' => $this->pdfUrl, 'formValueArray' => $this->formValueArray ])
//            ->with(['message' => 'Dear Customer, Please find attached the Form you recently submitted for your reference. '])
////            ->attach("https://app.onestoneads.com/storage/app/pdf/form-value/". $this->pdfUrl) // Attach PDF
//            ->subject('New Feedback Submited - ');
//    }
//}
