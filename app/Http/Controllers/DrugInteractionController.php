<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DrugInteractionController extends Controller
{
    // Show the form where users input drug names
    public function index()
    {
        return view('drug-interaction');
    }

    // Check if two drugs interact
    public function check(Request $request)
    {
        // Get the drug names from the form
        $drug1 = $request->input('drug1');
        $drug2 = $request->input('drug2');

        // Load the Excel file containing drug data
        $filePath = storage_path('app/public/cleaned_data.xlsx'); // adjust the path to your Excel file
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Initialize flag to check for interaction
        $interactionFound = false;
        $message = '';

        // Check for drug-drug interaction
        foreach ($data as $row) {
            $genericName = $row[0];  // assuming Generic name is in the first column
            $tradeName = $row[1];    // assuming Trade name is in the second column
            $interactsWith = $row[2]; // assuming Interaction data is in the third column

            // Match either drug by generic name or trade name
            if (($genericName == $drug1 || $tradeName == $drug1) && strpos($interactsWith, $drug2) !== false) {
                $interactionFound = true;
                $message = "Warning: {$drug1} interacts with {$drug2}. They should not be administered together.";
                break;
            }

            if (($genericName == $drug2 || $tradeName == $drug2) && strpos($interactsWith, $drug1) !== false) {
                $interactionFound = true;
                $message = "Warning: {$drug2} interacts with {$drug1}. They should not be administered together.";
                break;
            }
        }

        // If no interaction was found
        if (!$interactionFound) {
            $message = "No interaction found between {$drug1} and {$drug2}. They can be administered together.";
        }

        // Return the result to the view
        return view('drug-interaction', ['message' => $message]);
    }
}
