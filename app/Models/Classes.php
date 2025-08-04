<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\SchoolScope;
use Auth;

class Classes extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='classes';

    protected static function booted()
    {
        static::addGlobalScope(new SchoolScope);
    }

      public static function getRecord()
    {
        return self::all(); // or customize this query if needed
    }

    public static function getSingle($id)
    {
        return self::find($id);
    }

     public function students(){

        return $this->hasMany(Student::class);
    }

    public function classfees(){

        return $this->hasMany(ClassFee::class);
    }

    
    
    
}
