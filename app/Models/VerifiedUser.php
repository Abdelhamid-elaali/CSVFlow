<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifiedUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'telephone',
        'verified_at'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];
}
