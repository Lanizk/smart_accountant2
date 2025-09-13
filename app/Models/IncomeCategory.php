<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
         'school_id',
        'name',
        'description',
    ];

    public function incomes()
    {
        return $this->hasMany(OtherIncome::class, 'income_category_id');
    }
}

