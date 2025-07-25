<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use App\Models\Scopes\SchoolScope;
use Auth;


class ClassFee extends Model
{
    use softDeletes;

    protected $fillable=['school_id',
        'class_id',
        'term_id',
        'amount',
        'description',];


         protected static function booted()
    {
        static::addGlobalScope(new SchoolScope);
    }


        public function class()
        {
            return $this->belongsTo(Classes::class);
        }

        public function term(){
            return $this->belongsTo(Term::class);
        }
}
