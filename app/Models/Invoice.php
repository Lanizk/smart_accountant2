<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Invoice extends Model
{
      use HasFactory;

    protected $fillable = [
        'student_id',
        'term_id',
        'total_amount',
        'amount_paid',
        'base_fee',
        'balance_forward',
        'credit_forward',
        'balance',
        'invoice_date',
        'status',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
 

public function payments()
{
    return $this->hasMany(InvoicePayment::class);
}
}
