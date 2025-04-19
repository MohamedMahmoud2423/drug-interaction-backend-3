<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'gender',
        'date_of_birth',
        'phone_number',
        'blood_type',
        'allergies',
        'chronic_conditions',
        'medications',
        'prescription',
        'pregnancy_status',
        'weight',
        'height',
        'notes',
    ];


    // Automatically decode the JSON from the database into an array when retrieving and
    // Automatically encode the array back into JSON when saving.

    protected $casts = [
        'allergies' => 'array',
        'chronic_conditions' => 'array',
        'medications' => 'array',
        'prescription' => 'array',
    ];

    protected $table = 'profiles' ;


    protected function user()  ///keda el profile el wahed belongs to one user
    {
        return $this->belongsTo('App\Models\User' , 'user_id');
    }
}
