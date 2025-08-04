<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Scopes\SchoolScope;
use Auth;

class ExtraFee extends Model
{
     use softDeletes, HasFactory;
     protected $fillable=[
        'name','amount','is_quantity_based', 'description', 'school_id', 'created_by','status'
     ];


    protected static function booted()
    {
        static::addGlobalScope(new SchoolScope);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
