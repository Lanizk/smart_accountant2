<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'admission_number', 'gender', 'class_id'
    ];

    public function class(){
        return $this->belongsTo(classmodel::class,'class_id');
    }
}
