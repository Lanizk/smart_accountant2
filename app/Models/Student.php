<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\SchoolScope;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=['school_id',
        'name',
        'phone',
        'admission',
        'gender',
        'class_id',
        'term_id',];

    protected static function booted()
    {
        static::addGlobalScope(new SchoolScope);
    }

    public static function getRecord(){
        return self::all();
    }

    public function class(){

        return $this->belongsTo(Classes::class);
    }

     public function term(){

        return $this->belongsTo(Term::class);
    }
}
