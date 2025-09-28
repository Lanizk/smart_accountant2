<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentChannel extends Model
{
     protected $fillable = [
        'school_id', 'type', 'identifier', 'account_pattern', 'is_active'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
