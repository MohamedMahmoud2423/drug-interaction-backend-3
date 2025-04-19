<?php

namespace App\Imports;

use App\Models\Drug;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DrugsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Drug([
            'name' => $row['drug_name'],
            'category' => $row['category'],
            'contraindications' => $row['contraindications'],
            'severity' => $row['severity'],
            'risk_description' => $row['risk_description'],
            'contraindications_type' => $row['contraindications_type'],
            'severity_level' => $row['severity_level'],
            'allergy_risks' => $row['allergy_risks'],
            'age_groups' => $row['applicable_age_groups'],
            'pregnancy_safety' => $row['pregnancy_and_lactation_safety'],
            'drug_interactions' => $row['drug_interactions'],
            'drug_drug_interactions' => $row['drug_drug_interaction'],
        ]);
    }
}
