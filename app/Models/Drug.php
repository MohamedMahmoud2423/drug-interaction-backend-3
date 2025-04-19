<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'contraindications',
        'severity',
        'risk_description',
        'contraindications_type',
        'severity_level',
        'allergy_risks',
        'age_groups',
        'pregnancy_safety',
        'drug_interactions',
        'drug_drug_interactions',
    ];
}
