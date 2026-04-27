<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price', 'duration', 'max_users', 'durationtype', 'max_form', 'max_roles', 'max_booking', 'max_documents', 'max_polls', 'description1','description2','description3','description4','description5','description6','description7','description8'
    ];
}
