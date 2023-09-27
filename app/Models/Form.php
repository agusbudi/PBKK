<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'password',
        'name',
        'float',
        'image'
    ];

    protected $hidden = ['password'];
}
