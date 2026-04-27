<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Form;
use App\Models\UserForm;
use App\Models\FormValue;
use Illuminate\Http\Request;
use App\Facades\UtilityFacades;
use App\Exports\FormValuesExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use App\DataTables\FormValuesDataTable;
use Illuminate\Support\Facades\Storage;

class FormValueController extends Controller
{
    public function showSubmitedForms($formID, FormValuesDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-submitted-form')) {
            $form       = Form::find($formID);
            $chartData  = UtilityFacades::chartData($formID);
            return $dataTable->with('form_id', $formID)->render('form-value.index', compact('chartData', 'form'));
        } else {
            return redirect()->back()->with('errors', __('Permission denied.'));
        }
    }


    public function show($id)
    {
        if (\Auth::user()->can('show-submitted-form')) {
            try {
                $formValue  = FormValue::find($id);
                $array      = json_decode($formValue->json);
            } catch (\Throwable $th) {
                return redirect()->back()->with('errors', $th->getMessage());
            }
            return view('form-value.view', compact('formValue', 'array'));
        } else {
            return redirect()->back()->with('errors', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        $user               = \Auth::user();
        $userRole           = $user->roles->first()->id;
        $formValue          = FormValue::find($id);
        $formAllowedEdit    = UserForm::where('role_id', $userRole)->where('form_id', $formValue->form_id)->count();
        if (\Auth::user()->can('edit-submitted-form') && $user->type == 'Admin') {
            $array          = json_decode($formValue->json);
            $form           = Form::find($formValue->form_id);
            return view('form.fill', compact('form', 'formValue', 'array'));
        } else {
            if (\Auth::user()->can('edit-submitted-form') && $formAllowedEdit > 0) {
                $formValue  = FormValue::find($id);
                $array      = json_decode($formValue->json);
                $form       = Form::find($formValue->form_id);
                return view('form.fill', compact('form', 'formValue', 'array'));
            } else {
                return redirect()->back()->with('errors', __('Permission denied.'));
            }
        }
    }

    public function destroy($id)
    {
        if (\Auth::user()->can('delete-submitted-form')) {
            FormValue::find($id)->delete();
            return redirect()->back()->with('success',  __('Form deleted successfully.'));
        } else {
            return redirect()->back()->with('errors', __('Permission denied.'));
        }
    }



    public function exportAllPdfsAsZip(Request $request)
    {
        // Use the alternative method which is more reliable
        return $this->exportAllPdfsAsZipAlternative($request);
    }

    private function generatePdfContent($formValue)
    {
        try {
            \Log::info("Starting PDF generation for FormValue ID: " . $formValue->id);
            
            $user = Auth::user();
            set_time_limit(0);
            
            // Create a new TCPDF instance with proper font configuration
            $pdf = new \App\Models\CustomPDF('P', 'mm', 'A4', true, 'UTF-8', false, $user);
            $pdf->SetTitle($formValue->Form->title);
            
            // Set fonts that support UTF-8 properly
            $pdf->setHeaderFont(['dejavusans', '', 10]);
            $pdf->setFooterFont(['dejavusans', '', 10]);
            
            $pdf->SetMargins(10, 10, 10, true);
            $pdf->SetHeaderMargin(5);
            $pdf->setFontSubsetting(false);
            $pdf->AddPage();
            $pdf->setJPEGQuality(75);
            
            // Set the main font for the document
            $pdf->SetFont('dejavusans', '', 12);

            $setY = 20;
            $pdf->SetY($setY);
            
            // Decode JSON data
            $ValuForm_array = json_decode($formValue->json);
            if (json_last_error() !== JSON_ERROR_NONE) {
                \Log::error("JSON decode error for FormValue ID {$formValue->id}: " . json_last_error_msg());
                return false;
            }
            
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            $pdf->SetFillColor(234, 236, 249);
            $pdf->Rect(0, 0, 210, 45, 'F');

            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(0, 1, $formValue->created_at->format('l, F j, Y'), 0, 1, 'R', 0, '', 0, false, 'T', 'M');

            if ($formValue->Form->logo) {
                $logoPath = storage_path('app/' . $formValue->Form->logo);
                if (file_exists($logoPath)) {
                    $pdf->Image($logoPath, 10, 20, 0, 10, 'PNG');
                    $setY += 15;
                    $pdf->SetY($setY);
                } else {
                    \Log::warning("Logo file not found: " . $logoPath);
                }
            }
            
            $pdf->SetFont('helvetica', '', 12);

            // Generate HTML content
            $html = $formValue->generateHtmlContent($ValuForm_array);
            if (empty($html)) {
                \Log::warning("Empty HTML content generated for FormValue ID: " . $formValue->id);
                $html = '<p>No content available</p>';
            }
            
            $pdf->writeHTML($html, true, false, true, false, '');

            // Return the PDF content as string
            $pdfContent = $pdf->Output('', 'S');
            
            if ($pdfContent && strlen($pdfContent) > 0) {
                \Log::info("Successfully generated PDF content of " . strlen($pdfContent) . " bytes for FormValue ID: " . $formValue->id);
                return $pdfContent;
            } else {
                \Log::error("PDF content is empty for FormValue ID: " . $formValue->id);
                return false;
            }

        } catch (\Exception $e) {
            \Log::error("Error generating PDF content for FormValue ID {$formValue->id}: " . $e->getMessage());
            \Log::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }



    // Alternative ZIP creation method using a different approach
    public function exportAllPdfsAsZipAlternative(Request $request)
    {
        try {
            $formId = $request->input('form_id');
            \Log::info("Starting ZIP export for form ID: " . $formId);
            
            $formValues = FormValue::where('form_id', $formId)->get();
            \Log::info("Found " . $formValues->count() . " form values");

            if ($formValues->isEmpty()) {
                return response()->json(['error' => 'No form values found'], 404);
            }

            $zipFileName = 'form_values_' . $formId . '_' . time() . '.zip';
            $zipPath = storage_path('app/' . $zipFileName);
            \Log::info("ZIP file path: " . $zipPath);

            // Clean up any existing zip file
            if (file_exists($zipPath)) {
                unlink($zipPath);
                \Log::info("Removed existing ZIP file");
            }

            // Create ZIP using a different approach - add files directly to ZIP without temporary files
            $zip = new \ZipArchive();
            $result = $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
            
            if ($result !== TRUE) {
                $errorMessages = [
                    \ZipArchive::ER_OK => 'No error',
                    \ZipArchive::ER_MULTIDISK => 'Multi-disk zip archives not supported',
                    \ZipArchive::ER_RENAME => 'Renaming temporary file failed',
                    \ZipArchive::ER_CLOSE => 'Closing zip archive failed',
                    \ZipArchive::ER_SEEK => 'Seek error',
                    \ZipArchive::ER_READ => 'Read error',
                    \ZipArchive::ER_WRITE => 'Write error',
                    \ZipArchive::ER_CRC => 'CRC error',
                    \ZipArchive::ER_ZIPCLOSED => 'Containing zip archive was closed',
                    \ZipArchive::ER_NOENT => 'No such file',
                    \ZipArchive::ER_EXISTS => 'File already exists',
                    \ZipArchive::ER_OPEN => 'Can\'t open file',
                    \ZipArchive::ER_TMPOPEN => 'Failure to create temporary file',
                    \ZipArchive::ER_ZLIB => 'Zlib error',
                    \ZipArchive::ER_MEMORY => 'Memory allocation failure',
                    \ZipArchive::ER_CHANGED => 'Entry has been changed',
                    \ZipArchive::ER_COMPNOTSUPP => 'Compression method not supported',
                    \ZipArchive::ER_EOF => 'Premature EOF',
                    \ZipArchive::ER_INVAL => 'Invalid argument',
                    \ZipArchive::ER_NOZIP => 'Not a zip archive',
                    \ZipArchive::ER_INTERNAL => 'Internal error',
                    \ZipArchive::ER_INCONS => 'Zip archive inconsistent',
                    \ZipArchive::ER_REMOVE => 'Can\'t remove file',
                    \ZipArchive::ER_DELETED => 'Entry has been deleted'
                ];
                
                $errorMessage = isset($errorMessages[$result]) ? $errorMessages[$result] : 'Unknown error';
                \Log::error("Failed to create ZIP file at: " . $zipPath . " Error code: " . $result . " - " . $errorMessage);
                return response()->json(['error' => 'Failed to create ZIP file: ' . $errorMessage], 500);
            }

            $successCount = 0;
            $failedCount = 0;

            foreach ($formValues as $index => $formValue) {
                try {
                    \Log::info("Processing form value " . ($index + 1) . "/" . $formValues->count() . " (ID: " . $formValue->id . ")");
                    
                    // Generate PDF content directly as string
                    $pdfContent = $this->generatePdfContent($formValue);
                    
                    if ($pdfContent && strlen($pdfContent) > 0) {
                        $fileName = 'form_value_' . $formValue->id . '.pdf';
                        \Log::info("Generated PDF content of " . strlen($pdfContent) . " bytes for " . $fileName);
                        
                        // Add PDF content directly to ZIP without creating temporary files
                        if ($zip->addFromString($fileName, $pdfContent)) {
                            $successCount++;
                            \Log::info("Successfully added " . $fileName . " to ZIP");
                        } else {
                            $failedCount++;
                            \Log::warning("Failed to add PDF to ZIP for FormValue ID: " . $formValue->id);
                        }
                    } else {
                        $failedCount++;
                        \Log::warning("Failed to generate PDF content for FormValue ID: " . $formValue->id);
                    }
                } catch (\Exception $e) {
                    $failedCount++;
                    \Log::error("Error creating PDF for FormValue ID {$formValue->id}: " . $e->getMessage());
                    \Log::error("Stack trace: " . $e->getTraceAsString());
                    // Continue with other PDFs even if one fails
                }
            }

            \Log::info("ZIP processing complete. Success: {$successCount}, Failed: {$failedCount}");

            // Close the ZIP file and verify it was created successfully
            if (!$zip->close()) {
                \Log::error("Failed to close ZIP file at: " . $zipPath);
                return response()->json(['error' => 'Failed to finalize ZIP file'], 500);
            }

            \Log::info("ZIP file closed successfully");

            // Verify the ZIP file was created and has content
            if (!file_exists($zipPath)) {
                \Log::error("ZIP file does not exist at: " . $zipPath);
                return response()->json(['error' => 'ZIP file was not created'], 500);
            }

            $zipFileSize = filesize($zipPath);
            \Log::info("ZIP file size: " . $zipFileSize . " bytes");

            if ($zipFileSize === 0) {
                \Log::error("ZIP file is empty at: " . $zipPath);
                unlink($zipPath);
                return response()->json(['error' => 'ZIP file is empty'], 500);
            }

            if ($successCount === 0) {
                // Clean up empty zip file
                if (file_exists($zipPath)) {
                    unlink($zipPath);
                }
                return response()->json(['error' => 'No PDFs could be generated'], 500);
            }

            \Log::info("Successfully created ZIP file with {$successCount} PDFs: " . $zipPath);
            return response()->download($zipPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Log::error("Error in exportAllPdfsAsZipAlternative: " . $e->getMessage());
            \Log::error("Stack trace: " . $e->getTraceAsString());
            return response()->json(['error' => 'An error occurred while creating the zip file: ' . $e->getMessage()], 500);
        }
    }






    public function downloadPdf($id)
    {
        $user = Auth::user();
        $form_value = FormValue::where('id', $id)->first();
        if ($form_value) {
            $form_value->createPDF($user);
        } else {
            $form_value = FormValue::where('id', '=', $id)->first();
            if (!$form_value) {
                $id = Crypt::decryptString($id);
                $form_value = FormValue::find($id);
            }
            if ($form_value) {
                $form_value->createPDF();
            } else {
                return redirect()->route('home')->with('error', __('File is not exist.'));
            }
        }
    }

    public function exportXlsx(Request $request)
    {
        $form                           = Form::find($request->form_id);
        if ($request->select_date != '') {
            $dateRange                  = $request->select_date;
            list($startDate, $endDate)  = array_map('trim', explode('to', $dateRange));
        } else {
            $startDate                  = '';
            $endDate                    = '';
        }
        return Excel::download(new FormValuesExport($request, $startDate, $endDate), $form->title . '.xlsx');
    }


    public function videoStore(Request $request)
    {
        $file           = $request->file('media');
        $fileName       = $file->store('form_video');
        $values         = $fileName;
        return response()->json(['success' => __('Video uploded successfully.'), 'filename' => $values]);
    }

    public function selfieDownload($id)
    {
        $formValue      = FormValue::find($id);
        $json           = $formValue->json;
        $jsonData       = json_decode($json, true);
        $selfieValue    = null;
        foreach ($jsonData[0] as $field) {
            if ($field['type'] === 'selfie') {
                $selfieValue = $field['value'];
                break;
            } elseif ($field['type'] === 'video') {
                $selfieValue = $field['value'];
                break;
            }
        }
        if ($selfieValue === null) {
            return redirect()->back()->with('errors', __('Image Value Not Found'));
        }
        $filePath       = storage_path('app/' . $selfieValue);
        return response()->download($filePath);
    }
    
    public function deleteSelectedRecords(Request $request)
    {
        // dd($request);
        $selectedIds = json_decode($request->selected_ids, true); // Decode JSON data
        if ($selectedIds) {
            FormValue::whereIn('id', $selectedIds)->delete(); // Adjust the model and field as needed
            return redirect()->back()->with('success', 'Selected records have been deleted.');
        }

        return redirect()->back()->with('error', 'No records selected.');
    }
}
