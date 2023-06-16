<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinDetail extends Model
{
    public $table = 'join_details';

    public $fillable = [
        'employee_id',
        'join_date'
    ];

    protected $casts = [
        'employee_id' => 'integer',
        'join_date' => 'date'
    ];

    public static array $rules = [
        'employee_id' => 'required',
        'join_date' => 'required'
    ];
    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id','id');
    }
    
}
