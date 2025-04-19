<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicationPlan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'medication_name', 'dosage', 'time', 'note', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
