<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schools extends Model
{
    use HasFactory;

    
    protected $table = 'schools';

    protected $fillable = [
        'school_name',
        'email',
        'phone',
        'address',
        'subscription_status',
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function feePayments()
    {
        return $this->hasMany(FeePayment::class);
    }
}
