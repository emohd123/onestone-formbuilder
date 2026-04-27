<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use TCPDF;

class CustomPDF extends \TCPDF
{
    protected $user;
    
    // Constructor method to initialize the user data
    public function __construct($orientation, $unit, $size, $unicode, $encoding, $diskcache, $user)
    {
        // Pass the parameters to the parent TCPDF constructor
        parent::__construct($orientation, $unit, $size, $unicode, $encoding, $diskcache);

        // Set the user data to the class property
        $this->user = $user;
    }
    
    
    // Override Footer method
    public function Footer()
    {
        $user = $this->user;
        // dd($user);
        $logo = settings::where('key', 'app_dark_logo')->value('value');
        $plan_id = $user->plan_id;
        
        // dd($plan_id);
        if($plan_id == 1){
            $this->SetY(-20);
            
            $this->SetFillColor(234, 236, 249);
            $this->Rect(0, 277, 210, 20, 'F');
    
            $this->SetFont('dejavusans', '', 10);

            $this->Cell(160, 20, 'Powered by ', 0, 0, 'R');

            $logoPath = storage_path('app/' . $logo);

            $this->Image($logoPath, 172, 283, 35);
        }
    }
}

class FormValue extends Model
{
    use HasFactory;

    protected $fillable = ['form_id', 'user_id', 'json', 'customer_whatsapp', 'customer_email', 'transaction_id', 'currency_symbol', 'currency_name', 'status', 'amount', 'payment_type'];

    public function Form()
    {
        return $this->hasOne('App\Models\Form', 'id', 'form_id');
    }

    public function User()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function getFormArray()
    {
        return json_decode($this->json);
    }
    
    /**
     * Clean text data to prevent TCPDF font encoding issues
     */
    private function cleanTextForPdf($text)
    {
        if (empty($text)) {
            return '';
        }
        
        // Remove or replace problematic characters
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $text); // Remove control characters
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8'); // Ensure proper UTF-8 encoding
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); // Escape HTML entities
        
        return $text;
    }
    public function createPDFall()
    {
        $user = Auth::user();
        set_time_limit(0);
        // Define the PDF file path
        $pdfFilePath = storage_path('app/pdfs/form_value_' . $this->id . '.pdf');

        // Ensure the directory exists
        $pdfDir = dirname($pdfFilePath);
        if (!file_exists($pdfDir)) {
            if (!mkdir($pdfDir, 0777, true)) {
                \Log::error("Failed to create PDF directory: " . $pdfDir);
                return false;
            }
        }

        // Clean up any existing PDF file
        if (file_exists($pdfFilePath)) {
            unlink($pdfFilePath);
        }

        // Create a new TCPDF instance with proper font configuration
        $pdf = new CustomPDF('P', 'mm', 'A4', true, 'UTF-8', false, $user);
        $pdf->SetTitle($this->Form->title);
        
        // Set fonts that support UTF-8 properly
        $pdf->setHeaderFont(['dejavusans', '', 10]);
        $pdf->setFooterFont(['dejavusans', '', 10]);
        
        $pdf->SetMargins(10, 10, 10, true);
        $pdf->SetHeaderMargin(5);
        $pdf->setFontSubsetting(false); // Disable font subsetting to avoid character issues
        $pdf->AddPage();
        $pdf->setJPEGQuality(75);
        
        // Set the main font for the document
        $pdf->SetFont('dejavusans', '', 12);

        $setY = 20;
        $pdf->SetY($setY);
        $ValuForm_array = json_decode($this->json);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetFillColor(234, 236, 249);
        $pdf->Rect(0, 0, 210, 45, 'F');

        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 1, $this->created_at->format('l, F j, Y'), 0, 1, 'R', 0, '', 0, false, 'T', 'M');

        if ($this->Form->logo) {
            $pdf->Image(Storage::url($this->Form->logo), 10, 20, 0, 10, 'PNG'); // Set width to 0 to maintain aspect ratio
            $setY += 15;
            $pdf->SetY($setY);
        }
        
        $pdf->SetFont('helvetica', '', 12);

        $html = $this->generateHtmlContent($ValuForm_array); // Pass the variable to the method
        $pdf->writeHTML($html, true, false, true, false, '');

        // Save the PDF to a file
        try {
            $pdf->Output($pdfFilePath, 'F');
            
            // Verify the PDF was created successfully
            if (!file_exists($pdfFilePath) || filesize($pdfFilePath) === 0) {
                \Log::error("PDF file was not created or is empty: " . $pdfFilePath);
                return false;
            }
            
            return $pdfFilePath;
        } catch (\Exception $e) {
            \Log::error("Error saving PDF file: " . $e->getMessage());
            return false;
        }
    }

    
    public function createPDF($user)
    {
        // dd($user);
        set_time_limit(0);
        $pdf = new CustomPDF('P', 'mm', 'A4', true, 'UTF-8', false, $user);
        $pdf->SetTitle($this->Form->title);
        $pdf->setHeaderFont(['helvetica', '', 10]);
        $pdf->setFooterFont(['helvetica', '', 10]);
        $pdf->SetMargins(10, 10, 10, true);
        $pdf->SetHeaderMargin(5);
        $pdf->setFontSubsetting(true);
        $pdf->AddPage();
        $pdf->setJPEGQuality(75);
        $setY = 20;
        $pdf->SetY($setY);
        $ValuForm_array = json_decode($this->json);
        // dd($ValuForm_array);
        
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetFillColor(234, 236, 249);
        $pdf->Rect(0, 0, 210, 45, 'F');


        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 1, $this->created_at->format('l, F j, Y'), 0, 1, 'R', 0, '', 0, false, 'T', 'M');

        if ($this->Form->logo) {
            $pdf->Image(Storage::url($this->Form->logo), 10, 20, 0, 10, 'PNG'); // Set width to 0 to maintain aspect ratio
            $setY += 15;
            $pdf->SetY($setY);
        }

        $pdf->SetFont('helvetica', '', 12);
        $html = '<table width="100%" cellpadding="5"></table><p></p><p></p>';

        $html .= '<table width="100%" cellpadding="8"><tbody>';
        $skip = 0;
        foreach ($ValuForm_array as $value) {
            foreach ($value as $data) {
                if ($skip) {
                    $skip--;
                    continue;
                }
                if (isset($data->value) || isset($data->values)) {

                    $html .= '<tr><td><span style="font-size: 15px; font-weight:bold;">' . str_replace('&nbsp;', ' ', $data->label) . '</span></td><td>';

                    if ($data->type == "starRating") {
                        $html .= '<div style="font-size: 25px;font-weight: bold">';
                        $starNumber = $data->value;
                        $final_stars = isset($data->number_of_star) ? $data->number_of_star : 5;

                        for ($x = 1; $x <= $starNumber; $x++) {
                            $html .= '<img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/full.png') . '">';
                        }
                        if (strpos($starNumber, '.')) {
                            $starNumber_array = explode(".", $starNumber);
                            /* half start */
                            if ($starNumber_array[1] > 0) {
                                $html .= '<img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/half.png') . '">';
                                $x++;
                            }
                        }
                        while ($x <= $final_stars) {
                            $html .= '<img style="height:17px;padding-left:20px;" src="' . asset('assets/images/ratings/empty.png') . '">';
                            $x++;
                        }
                        $html .= '</div>';
                    } elseif ($data->type == 'repeater') {
                        $imageChoiceJsons = json_decode($data->value);
                        foreach ($imageChoiceJsons as $imageChoiceJson) {
                            if (isset($imageChoiceJson->selected) && $imageChoiceJson->selected == 1) {
                                $html .= '<div><img src="' . Storage::url($imageChoiceJson->image) . '"></div>';
                            }
                        }
                    } elseif ($data->type == 'SignaturePad') {
                        $html .= '<div><img src="' . Storage::url($data->value) . '" width="150px"></div>';
                    } elseif ($data->type == 'location') {
                        $value  = $data->value;
                        $html .= '<a href="http://www.google.com/maps/place/' . $value . '" target="_blank"><img style="height:40px; margin-top:10px;" src="' . asset('assets/images/map.jpg') . '"></a>';
                    } elseif ($data->type == 'video' || $data->type == 'selfie') {
                        $html .= '<a href="' . route('selfie.image.download', $this->id) . '"><button style="padding:10px; background-color: #584ED2;" id="downloadButton">Download ' . ucfirst($data->type) . '</button></a>';
                    } elseif (isset($data->values)) {
                        foreach ($data->values as $sub_data) {
                            if ($data->type == "checkbox-group") {
                                if (isset($sub_data->selected)) {
                                    $html .= '<br><img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/checked.png') . '"> ' . $sub_data->label;
                                } else {
                                    $html .= '<br><img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/unchecked.png') . '"> ' . $sub_data->label;
                                }
                            } else {
                                if (isset($sub_data->selected)) {
                                    $html .=
                                        '<span style="font-size: 14px; color: rgb(78,81,102);"> ' . $sub_data->label . '</span>&nbsp;&nbsp;&nbsp;&nbsp;';
                                    
                                }
                            }
                        }
                    } elseif ($data->type == "file") {
                        if (!empty($data->value)) {
                            // If value is an array of files
                            if (is_array($data->value)) {
                                $firstImage = $data->value[0];
                                if ($data->file_extention == 'image') {
                                    // $html .= '<table  border="0" cellpadding="2"><tbody><tr>';
                                    // foreach ($data->value as $k => $val) {
                                    //     $html .= '<td><img src="' . Storage::url($val) . '"/></td>';
                                    //     if ((($k + 1) % 2) == 0) {
                                    //         $html .= "</tr><tr>";
                                    //     }
                                    // }
                                    // $html .= '</tr></tbody></table>';
                                    $html .= '<table width="100%" border="0" cellpadding="2"><tr>';
                                    $html .= '<td><img src="' . Storage::url($firstImage) . '"/></td>';
                                    $html .= '</tr></table>';
                                } else {
                                    // $html .= '<table width="100%" border="0" cellpadding="2"><tbody><tr>';
                                    // foreach ($data->value as $k => $val) {
                                    //     $file_name = basename($val); // Extracts the file name
                                    //     $html .= '<td><a class="my-2 btn btn-info" download="" style="background-color: #3ec9d6;" href="' . Storage::url($val) . '">' . substr($file_name, 0, 25) . (strlen($file_name) > 25 ? '...' : '') . '</a></td>';
                                    // }
                                    // $html .= '</tr></tbody></table>';
                                    $html .= '<table width="100%" border="0" cellpadding="2"><tr>';
                                    $html .= '<td><a class="my-2 btn btn-info" download="" style="background-color: #3ec9d6;" href="' . Storage::url($firstImage) . '">' . substr($file_name, 0, 25) . (strlen($file_name) > 25 ? '...' : '') . '</a></td>';
                                    $html .= '</tr></table>';
                                }
                            }
                            // If value is a single file
                            else {
                                $file_name = basename($data->value); // Extracts the file name
                                if ($data->file_extention == 'image') {
                                    $html .= '<table width="100%" border="0" cellpadding="2"><tr>';
                                    $html .= '<td><img src="' . Storage::url($data->value) . '"/></td>';
                                    $html .= '</tr></table>';
                                } else {
                                    $html .= '<table width="100%" border="0" cellpadding="2"><tr>';
                                    $html .= '<td><a class="my-2 btn btn-info" download="" style="background-color: #3ec9d6;" href="' . Storage::url($data->value) . '">' . substr($file_name, 0, 25) . (strlen($file_name) > 25 ? '...' : '') . '</a></td>';
                                    $html .= '</tr></table>';
                                }
                            }
                        }
                    } elseif ($data->type == 'Color') {
                        $html .= '<div style="background-color:' . $data->value . ';"></div>';
                    } else {
                        $html .= '<span style="font-size: 14px; color: rgb(78,81,102);">' . $data->value . '</span>';
                    }
                    $html .= '</td></tr>';
                }
            }
        }
        $html .= '</tbody></table>';
        // dd($html);

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($this->Form->title . '_' . (($this->User) ? $this->User->name : '') . '_' . $this->created_at . '.pdf', 'D');
    }
    

    
    
    public function generateHtmlContent($ValuForm_array)
    {

        $html = '<table width="100%" cellpadding="5"></table><p></p><p></p>';

        $html .= '<table width="100%" cellpadding="8"><tbody>';
        $skip = 0;
        foreach ($ValuForm_array as $value) {
            foreach ($value as $data) {
                if ($skip) {
                    $skip--;
                    continue;
                }
                if (isset($data->value) || isset($data->values)) {

                    // Clean and escape the label to prevent font encoding issues
                    $cleanLabel = $this->cleanTextForPdf($data->label);
                    $cleanLabel = str_replace('&nbsp;', ' ', $cleanLabel);
                    
                    $html .= '<tr><td><span style="font-size: 15px; font-weight:bold;">' . $cleanLabel . '</span></td><td>';

                    if ($data->type == "starRating") {
                        $html .= '<div style="font-size: 25px;font-weight: bold">';
                        $starNumber = $data->value;
                        $final_stars = isset($data->number_of_star) ? $data->number_of_star : 5;

                        for ($x = 1; $x <= $starNumber; $x++) {
                            $html .= '<img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/full.png') . '">';
                        }
                        if (strpos($starNumber, '.')) {
                            $starNumber_array = explode(".", $starNumber);
                            /* half start */
                            if ($starNumber_array[1] > 0) {
                                $html .= '<img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/half.png') . '">';
                                $x++;
                            }
                        }
                        while ($x <= $final_stars) {
                            $html .= '<img style="height:17px;padding-left:20px;" src="' . asset('assets/images/ratings/empty.png') . '">';
                            $x++;
                        }
                        $html .= '</div>';
                    } elseif ($data->type == 'repeater') {
                        $imageChoiceJsons = json_decode($data->value);
                        foreach ($imageChoiceJsons as $imageChoiceJson) {
                            if (isset($imageChoiceJson->selected) && $imageChoiceJson->selected == 1) {
                                $html .= '<div><img src="' . Storage::url($imageChoiceJson->image) . '"></div>';
                            }
                        }
                    } elseif ($data->type == 'SignaturePad') {
                        $html .= '<div><img src="' . Storage::url($data->value) . '" width="150px"></div>';
                    } elseif ($data->type == 'location') {
                        $value  = $data->value;
                        $html .= '<a href="http://www.google.com/maps/place/' . $value . '" target="_blank"><img style="height:40px; margin-top:10px;" src="' . asset('assets/images/map.jpg') . '"></a>';
                    } elseif ($data->type == 'video' || $data->type == 'selfie') {
                        $html .= '<a href="' . route('selfie.image.download', $this->id) . '"><button style="padding:10px; background-color: #584ED2;" id="downloadButton">Download ' . ucfirst($data->type) . '</button></a>';
                    } elseif (isset($data->values)) {
                        foreach ($data->values as $sub_data) {
                            if ($data->type == "checkbox-group") {
                                if (isset($sub_data->selected)) {
                                    $html .= '<br><img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/checked.png') . '"> ' . $sub_data->label;
                                } else {
                                    $html .= '<br><img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/unchecked.png') . '"> ' . $sub_data->label;
                                }
                            } else {
                                if (isset($sub_data->selected)) {
                                    $html .=
                                        '<span style="font-size: 14px; color: rgb(78,81,102);"> ' . $sub_data->label . '</span>&nbsp;&nbsp;&nbsp;&nbsp;';
                                    
                                }
                            }
                        }
                    } elseif ($data->type == "file") {
                        if (!empty($data->value)) {
                            // If value is an array of files
                            if (is_array($data->value)) {
                                // if ($data->file_extention == 'image') {
                                //     $html .= '<table  border="0" cellpadding="2"><tbody><tr>';
                                //     foreach ($data->value as $k => $val) {
                                //         $html .= '<td><img src="' . Storage::url($val) . '"/></td>';
                                //         if ((($k + 1) % 2) == 0) {
                                //             $html .= "</tr><tr>";
                                //         }
                                //     }
                                //     $html .= '</tr></tbody></table>';
                                // } else {
                                //     $html .= '<table width="100%" border="0" cellpadding="2"><tbody><tr>';
                                //     foreach ($data->value as $k => $val) {
                                //         $file_name = basename($val); // Extracts the file name
                                //         $html .= '<td><a class="my-2 btn btn-info" download="" style="background-color: #3ec9d6;" href="' . Storage::url($val) . '">' . substr($file_name, 0, 25) . (strlen($file_name) > 25 ? '...' : '') . '</a></td>';
                                //     }
                                //     $html .= '</tr></tbody></table>';
                                // }
                                $firstImage = $data->value[0];
                                if ($data->file_extention == 'image') {
                                    // $html .= '<table  border="0" cellpadding="2"><tbody><tr>';
                                    // foreach ($data->value as $k => $val) {
                                    //     $html .= '<td><img src="' . Storage::url($val) . '"/></td>';
                                    //     if ((($k + 1) % 2) == 0) {
                                    //         $html .= "</tr><tr>";
                                    //     }
                                    // }
                                    // $html .= '</tr></tbody></table>';
                                    $html .= '<table width="100%" border="0" cellpadding="2"><tr>';
                                    $html .= '<td><img src="' . Storage::url($firstImage) . '"/></td>';
                                    $html .= '</tr></table>';
                                } else {
                                    // $html .= '<table width="100%" border="0" cellpadding="2"><tbody><tr>';
                                    // foreach ($data->value as $k => $val) {
                                    //     $file_name = basename($val); // Extracts the file name
                                    //     $html .= '<td><a class="my-2 btn btn-info" download="" style="background-color: #3ec9d6;" href="' . Storage::url($val) . '">' . substr($file_name, 0, 25) . (strlen($file_name) > 25 ? '...' : '') . '</a></td>';
                                    // }
                                    // $html .= '</tr></tbody></table>';
                                    $html .= '<table width="100%" border="0" cellpadding="2"><tr>';
                                    $html .= '<td><a class="my-2 btn btn-info" download="" style="background-color: #3ec9d6;" href="' . Storage::url($firstImage) . '">' . substr($file_name, 0, 25) . (strlen($file_name) > 25 ? '...' : '') . '</a></td>';
                                    $html .= '</tr></table>';
                                }
                            }
                            // If value is a single file
                            else {
                                $file_name = basename($data->value); // Extracts the file name
                                if ($data->file_extention == 'image') {
                                    $html .= '<table width="100%" border="0" cellpadding="2"><tr>';
                                    $html .= '<td><img src="' . Storage::url($data->value) . '"/></td>';
                                    $html .= '</tr></table>';
                                } else {
                                    $html .= '<table width="100%" border="0" cellpadding="2"><tr>';
                                    $html .= '<td><a class="my-2 btn btn-info" download="" style="background-color: #3ec9d6;" href="' . Storage::url($data->value) . '">' . substr($file_name, 0, 25) . (strlen($file_name) > 25 ? '...' : '') . '</a></td>';
                                    $html .= '</tr></table>';
                                }
                            }
                        }
                    } elseif ($data->type == 'Color') {
                        $html .= '<div style="background-color:' . $data->value . ';"></div>';
                    } else {
                        $cleanValue = $this->cleanTextForPdf($data->value);
                        $html .= '<span style="font-size: 14px; color: rgb(78,81,102);">' . $cleanValue . '</span>';
                    }
                    $html .= '</td></tr>';
                }
            }
        }
        $html .= '</tbody></table>';

        return $html;

    }

    public function sendPDF($user)
    {   
        // dd($user);
        // Initialize TCPDF
        $pdf = new CustomPDF('P', 'mm', 'A4', true, 'UTF-8', false, $user);
        $pdf->SetTitle($this->Form->title);
        $pdf->setHeaderFont(['helvetica', '', 10]);
        $pdf->setFooterFont(['helvetica', '', 10]);
        $pdf->SetMargins(10, 10, 10, true);
        $pdf->SetHeaderMargin(5);
        $pdf->setFontSubsetting(true);
        $pdf->AddPage();
        $pdf->setJPEGQuality(75);
        $setY = 20;
        $pdf->SetY($setY);
        $ValuForm_array = json_decode($this->json);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetFillColor(234, 236, 249);
        $pdf->Rect(0, 0, 210, 45, 'F');
        
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 1, $this->created_at->format('l, F j, Y'), 0, 1, 'R', 0, '', 0, false, 'T', 'M');
        // $pdf->Cell(0, 1, ($this->created_at->format('d M Y')), 0, 1, 'R', 0, '', 0, false, 'T', 'M');

        if ($this->Form->logo) {
            $pdf->Image(Storage::url($this->Form->logo), 10, 20, 0, 10, 'PNG'); // Set width to 0 to maintain aspect ratio
            $setY += 15;
            $pdf->SetY($setY);
        }

        $pdf->SetFont('helvetica', '', 12);
        $html = '<table width="100%" cellpadding="5"></table><p></p><p></p>';

        $html .= '<table width="100%" cellpadding="8"><tbody>';
        $skip = 0;
        foreach ($ValuForm_array as $value) {
            foreach ($value as $data) {
                if ($skip) {
                    $skip--;
                    continue;
                }
                if (isset($data->value) || isset($data->values)) {

                    $html .= '<tr><td><span style="font-size: 15px; font-weight:bold;">' . str_replace('&nbsp;', ' ', $data->label) . '</span></td><td>';

                    if ($data->type == "starRating") {
                        $html .= '<div style="font-size: 25px;font-weight: bold">';
                        $starNumber = $data->value;
                        $final_stars = isset($data->number_of_star) ? $data->number_of_star : 5;

                        for ($x = 1; $x <= $starNumber; $x++) {
                            $html .= '<img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/full.png') . '">';
                        }
                        if (strpos($starNumber, '.')) {
                            $starNumber_array = explode(".", $starNumber);
                            /* half start */
                            if ($starNumber_array[1] > 0) {
                                $html .= '<img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/half.png') . '">';
                                $x++;
                            }
                        }
                        while ($x <= $final_stars) {
                            $html .= '<img style="height:17px;padding-left:20px;" src="' . asset('assets/images/ratings/empty.png') . '">';
                            $x++;
                        }
                        $html .= '</div>';
                    } elseif ($data->type == 'repeater') {
                        $imageChoiceJsons = json_decode($data->value);
                        foreach ($imageChoiceJsons as $imageChoiceJson) {
                            if (isset($imageChoiceJson->selected) && $imageChoiceJson->selected == 1) {
                                $html .= '<div><img src="' . Storage::url($imageChoiceJson->image) . '"></div>';
                            }
                        }
                    } elseif ($data->type == 'SignaturePad') {
                        $html .= '<div><img src="' . Storage::url($data->value) . '" width="150px"></div>';
                    } elseif ($data->type == 'location') {
                        $value  = $data->value;
                        $html .= '<a href="http://www.google.com/maps/place/' . $value . '" target="_blank"><img style="height:40px; margin-top:10px;" src="' . asset('assets/images/map.jpg') . '"></a>';
                    } elseif ($data->type == 'video' || $data->type == 'selfie') {
                        $html .= '<a href="' . route('selfie.image.download', $this->id) . '"><button style="padding:10px; background-color: #584ED2;" id="downloadButton">Download ' . ucfirst($data->type) . '</button></a>';
                    } elseif (isset($data->values)) {
                        foreach ($data->values as $sub_data) {
                            if ($data->type == "checkbox-group") {
                                if (isset($sub_data->selected)) {
                                    $html .= '<br><img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/checked.png') . '"> ' . $sub_data->label;
                                } else {
                                    $html .= '<br><img style="height:20px;padding-left:20px;" src="' . asset('assets/images/ratings/unchecked.png') . '"> ' . $sub_data->label;
                                }
                            } else {
                                if (isset($sub_data->selected)) {
                                    $html .=
                                        '<span style="font-size: 14px; color: rgb(78,81,102);"> ' . $sub_data->label . '</span>&nbsp;&nbsp;&nbsp;&nbsp;';
                                    
                                }
                            }
                        }
                    } elseif ($data->type == "file") {
                        if (!empty($data->value)) {
                            // If value is an array of files
                            if (is_array($data->value)) {
                                $firstImage = $data->value[0];
                                if ($data->file_extention == 'image') {
                                    // $html .= '<table  border="0" cellpadding="2"><tbody><tr>';
                                    // foreach ($data->value as $k => $val) {
                                    //     $html .= '<td><img src="' . Storage::url($val) . '"/></td>';
                                    //     if ((($k + 1) % 2) == 0) {
                                    //         $html .= "</tr><tr>";
                                    //     }
                                    // }
                                    // $html .= '</tr></tbody></table>';
                                    $html .= '<table width="100%" border="0" cellpadding="2"><tr>';
                                    $html .= '<td><img src="' . Storage::url($firstImage) . '"/></td>';
                                    $html .= '</tr></table>';
                                } else {
                                    // $html .= '<table width="100%" border="0" cellpadding="2"><tbody><tr>';
                                    // foreach ($data->value as $k => $val) {
                                    //     $file_name = basename($val); // Extracts the file name
                                    //     $html .= '<td><a class="my-2 btn btn-info" download="" style="background-color: #3ec9d6;" href="' . Storage::url($val) . '">' . substr($file_name, 0, 25) . (strlen($file_name) > 25 ? '...' : '') . '</a></td>';
                                    // }
                                    // $html .= '</tr></tbody></table>';
                                    $html .= '<table width="100%" border="0" cellpadding="2"><tr>';
                                    $html .= '<td><a class="my-2 btn btn-info" download="" style="background-color: #3ec9d6;" href="' . Storage::url($firstImage) . '">' . substr($file_name, 0, 25) . (strlen($file_name) > 25 ? '...' : '') . '</a></td>';
                                    $html .= '</tr></table>';
                                }
                            }
                            // If value is a single file
                            else {
                                $file_name = basename($data->value); // Extracts the file name
                                if ($data->file_extention == 'image') {
                                    $html .= '<table width="100%" border="0" cellpadding="2"><tr>';
                                    $html .= '<td><img src="' . Storage::url($data->value) . '"/></td>';
                                    $html .= '</tr></table>';
                                } else {
                                    $html .= '<table width="100%" border="0" cellpadding="2"><tr>';
                                    $html .= '<td><a class="my-2 btn btn-info" download="" style="background-color: #3ec9d6;" href="' . Storage::url($data->value) . '">' . substr($file_name, 0, 25) . (strlen($file_name) > 25 ? '...' : '') . '</a></td>';
                                    $html .= '</tr></table>';
                                }
                            }
                        }
                    } elseif ($data->type == 'Color') {
                        $html .= '<div style="background-color:' . $data->value . ';"></div>';
                    } else {
                        $html .= '<span style="font-size: 14px; color: rgb(78,81,102);">' . $data->value . '</span>';
                    }
                    $html .= '</td></tr>';
                }
            }
        }
        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true,  false, '');
        // $pdf->Output($this->Form->title . '_' . (($this->User) ? $this->User->name : '') . '_' . $this->created_at . '.pdf', 'D');
        // Output PDF as a string
        // Generate the PDF string
        $pdfString = $pdf->Output('', 'S');

        // Define the directory within the storage disk
        $directory = 'pdf/form-value/';

        // Generate a unique filename
// Replace spaces with underscores in the filename
        $filename = str_replace(' ', '_', $this->Form->title) . '_' . (($this->User) ? str_replace(' ', '_', $this->User->name) : '') . '_' . str_replace(' ', '_', $this->created_at) . '.pdf';
        
        // Save the PDF file to the storage directory
        $savedPath = Storage::disk('local')->put($directory . $filename, $pdfString);
        // Check if the file was saved successfully
        // Check if the file was saved successfully
        if ($savedPath) {
            // Get the full path to the saved file
            $fullPath = Storage::disk('local')->path($directory . $filename);

            // Remove the unwanted part from the path
            $cleanedPath = str_replace('/home/onesgcyc/', '', $fullPath);

            // Return the cleaned path
            return $filename;
        } else {
            // Return null or handle the failure case accordingly
            return null;
        }



    }

    private function generatePDFContent()
    {
        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle($this->Form->title);
        $pdf->setHeaderFont(['helvetica', '', 10]);
        $pdf->setFooterFont(['helvetica', '', 10]);
        $pdf->SetMargins(10, 10, 10, true);
        $pdf->SetHeaderMargin(5);
        $pdf->setFontSubsetting(true);
        $pdf->AddPage();
        $pdf->setJPEGQuality(75);
        $setY = 20;
        $pdf->SetY($setY);
        $ValuForm_array = json_decode($this->json);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if ($this->Form->logo) {
            $pdf->Image(Storage::url($this->Form->logo), 10, 20, 0, 30, 'PNG');
            $setY += 40;
            $pdf->SetY($setY);
        }

        $pdf->SetFont('helvetica', '', 20);
        $pdf->Cell(170, 1, $this->Form->title, 0, 0, '', 0, '', 0, false, 'T', 'M');
        $setY += 10;
        $pdf->SetY($setY);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(170, 1, ($this->created_at->format('d M Y') . " / " . (($this->User) ? $this->User->name : '')), 0, 0, '', 0, '', 0, false, 'T', 'M');
        $setY += 10;
        $pdf->SetY($setY);
        $pdf->SetFont('helvetica', '', 14);
        $html = '<table width="100%" border="1" cellpadding="5"></table>';
        $html .= '<p></p><table width="100%" border="1" cellpadding="5"><tbody>';

        foreach ($ValuForm_array as $value) {
            foreach ($value as $data) {
                // Handle different types of form fields
                // Example code continues...
            }
        }

        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        return $pdf->Output('', 'S');
    }

    private function generatePDFFilename()
    {
        return $this->Form->title . '_' . (($this->User) ? $this->User->name : '') . '_' . $this->created_at->format('Y-m-d') . '.pdf';
    }
    public function columns()
    {
        $columns = [];
        $data = json_decode($this->json, true);
        foreach ($data as $page) {
            $columns = array_merge($columns, array_column($page, 'label'));
        }
        return $columns;
    }
}


