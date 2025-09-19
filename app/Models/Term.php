<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scopes\SchoolScope;


class Term extends Model
{
    use SoftDeletes;

    protected $fillable=['name','Year'];
     protected static function booted()
    {
        static::addGlobalScope(new SchoolScope);
    }


    public static function getRecord(){

        return self::all();
    }

    public static function getSingle($id){

        return self::find($id);

    }

    public function students(){

        return $this->hasMany(Student::class);
    }

     public function classfees(){

        return $this->hasMany(ClassFee::class);
    }


    public static function current()
    {
        $schoolId = auth()->user()->school_id;

        return self::where('school_id', $schoolId)
            ->where('active', true)
            ->first();
    }

    public static function currentId()
    {
        return optional(self::current())->id;
    }

    // Get current year value
    public static function currentYear()
    {
        $term = self::current();
        return $term ? $term->year : now()->year; // fallback to this year
    }
}
