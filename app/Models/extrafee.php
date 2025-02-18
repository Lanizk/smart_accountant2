<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\SchoolScope;

class extrafee extends Model
{
    use HasFactory;
    protected $fillable=['school_id','name','term','amount','for_entire_school'];

    protected static function booted()
    {
        static::addGlobalScope(new SchoolScope);
    }

      // Relationship: ExtraFee belongs to a School
      public function school()
      {
        return $this->belongsTo(schools::classmodel);
      }

       // Relationship: ExtraFee belongs to many Classes (only if for_entire_school = false)
       public function classes()
       {
        return $this->belongstoMany(Classmodel::class,'extrafeeclasses');
       }
       
}
