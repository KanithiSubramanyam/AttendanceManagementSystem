<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $table = 'employees';

    public $fillable = [
        'name',
        'mobile',
        'role',
        'image'
    ];

    protected $casts = [
        'name' => 'string',
        'mobile' => 'string',
        'role' => 'string',
        'image' => 'string'
    ];

    public static array $rules = [
        'name' => 'required',
        'mobile' => 'required',
        'role' => 'required'
    ];

    
}
