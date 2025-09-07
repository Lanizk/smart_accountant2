<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{

     protected $fillable = [
        'invoice_id',
        'amount',
        'method',
        'payment_date',
    ];




    public function invoice()
{
    return $this->belongsTo(Invoice::class);
}
}
