<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    public $table = 'attendances';

    public $fillable = [
        'name',
        'attendance',
        'reason',
        'date',
        's_no'
    ];

    protected $casts = [
        'name' => 'integer',
        'attendance' => 'string',
        'reason' => 'string',
        'date' => 'date',
        's_no' => 'integer'
    ];

    public static array $rules = [
        'name' => 'required',
        'attendance' => 'required',
        'date' => 'required',

    ];

    public function employee(){
        return $this->belongsTo(Employee::class, 'name','id');
    }
    
    
}
