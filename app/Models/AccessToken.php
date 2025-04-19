<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    protected $fillable = [
        'tokenable_type' , 'tokenable_id' ,'name' ,'token' ,'abilities' ,'last_used_at' , 'expires_at'
    ];

    protected $table = 'personal_access_tokens';


    protected function user()
    {
        return $this->belongsTo('App\Models\User' , 'tokenable_id');
    }
}
