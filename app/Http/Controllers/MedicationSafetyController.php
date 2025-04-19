<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Auth;

class MedicationSafetyController extends Controller
{
    public function index()
    {
        return view('medication-checker');
    }

    public function check(Request $request)
    {
        $user = Auth::user();

        // Get profile
        $profile = $user->profile;

        if (!$profile) {
            return view('medication-checker', [
                'message' => 'No profile data found. Please complete your profile first.',
                'status' => 'error'
            ]);
        }

        // Extract info from profile
        $drugInput = strtoupper(trim($request->input('drug_name')));
        $age = \Carbon\Carbon::parse($profile->date_of_birth)->age;
        $gender = strtolower($profile->gender);
        $pregnant = $profile->pregnancy_status; // boolean
        $allergies = array_map('strtolower', $profile->allergies ?? []);
        $conditions = array_map('strtolower', $profile->chronic_conditions ?? []);
        if (is_array($profile->medications)) {
            // If already an array, no need to explode
            $medications = array_map('strtolower', array_map('trim', $profile->medications));
        } else {
            // Otherwise, explode string into array
            $medications = array_map('strtolower', array_map('trim', explode(',', $profile->medications ?? '')));
        }

        // Load Excel file
        $filePath = storage_path('app/public/Drugss.xlsx');
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        $headers = array_map('strtolower', $data[0]);
        $rows = array_slice($data, 1);

        $matchedDrug = null;
        $issues = [];

        foreach ($rows as $row) {
            $drugName = strtoupper(trim($row[0]));  // Drug Name
            $tradeName = strtoupper(trim($row[1])); // Trade Name

            if ($drugName === $drugInput || $tradeName === $drugInput) {
                $matchedDrug = array_combine($headers, $row);

                // Age group check
                $ageGroup = strtolower(trim($matchedDrug['applicable age groups'] ?? ''));
                $userIsAdult = $age >= 18;

                if (!preg_match('/all age|all ages|all age groups/', $ageGroup)) {
                if ($userIsAdult && !preg_match('/adult(s)?|elderly|geriatric/', $ageGroup)) {
                $issues[] = "This drug may not be suitable for adult patients.";
                } elseif (!$userIsAdult && !preg_match('/child|children|pediatric/', $ageGroup)) {
                $issues[] = "This drug may not be suitable for pediatric patients.";
    }
}


                // Pregnancy check
                $pregnancyInfo = strtolower(trim($matchedDrug['pregnancy and lactation safety'] ?? ''));

                if ($gender == 'female' && $pregnant) {
                    if (!preg_match('/safe for pregnancy and lactation|safe during pregnancy|safe in pregnancy and lactation/', $pregnancyInfo)) {
                        $issues[] = "This drug may not be suitable for use during pregnancy.";
                    }

                }









                // Medication interaction check
                $interactions = array_map('trim', explode(',', strtolower($matchedDrug['drug interactions'] ?? '')));
                $interactions = array_map('strtolower', $interactions); // normalize interactions

                $intersectingMeds = array_intersect($medications, $interactions);

                foreach ($intersectingMeds as $problemMed) {
                    $issues[] = "Interacts with your medication: $problemMed.";
                }
                \Log::info('User Medications:', $medications);
                \Log::info('Drug Interactions:', $interactions);



            break;
            }
        }

        if (!$matchedDrug) {
            return view('medication-checker', [
                'message' => "Drug '{$drugInput}' not found in the database.",
                'status' => 'error'
            ]);
        }

        $status = count($issues) > 0 ? 'warning' : 'safe';
        $message = count($issues) > 0
            ? "Caution for '{$drugInput}':\n- " . implode("\n- ", $issues)
            : "The drug '{$drugInput}' appears to be safe based on your profile.";

        return view('medication-checker', compact('message', 'status', 'matchedDrug'));
    }
}
