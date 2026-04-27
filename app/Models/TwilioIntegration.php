<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwilioIntegration extends Model
{
    use HasFactory;

    protected $fillable = [
        'twilio_sid',
        'twilio_auth_token',
        'twillio_number',
        // Add other fields as needed
    ];
}
