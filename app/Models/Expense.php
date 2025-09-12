<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'school_id',
        'expense_category_id',
        'description',
        'amount',
        'payment_method',
        'expense_date',
        'created_by',
    ];

     protected $casts = [
        'expense_date' => 'date', 
    ];

    public function cashbookEntries()
{
    return $this->morphMany(\App\Models\CashbookEntry::class, 'source');
}

public function category()
    {
        return $this->belongsTo(\App\Models\ExpenseCategory::class, 'expense_category_id');
    }
}
