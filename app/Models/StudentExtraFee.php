<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\softDeletes;
use App\Models\Scopes\SchoolScope;

class StudentExtraFee extends Model
{
    use HasFactory,softDelete;

    protected $fillable=['student_id',
        'extra_fee_id',
        'amount',
        'school_id',
        'created_by',];


          public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function extraFee()
    {
        return $this->belongsTo(ExtraFee::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
    
}
