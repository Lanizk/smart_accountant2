<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashbookEntry extends Model
{
     protected $fillable = [
        'school_id','transaction_type','entry_type','amount',
        'payment_method','transaction_date','description',
        'source_id','source_type','related_entry_id'
    ];

     public function source()
    {
        return $this->morphTo();
    }

    public function relatedEntry()
    {
        return $this->belongsTo(CashbookEntry::class, 'related_entry_id');
    }
}
