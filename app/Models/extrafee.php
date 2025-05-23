<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\SchoolScope;

class extrafee extends Model
{
    use HasFactory;
    protected $fillable=['school_id','name', 'fee_type', 'unit_price', 'term_id'];

    protected static function booted()
    {
        static::addGlobalScope(new SchoolScope);
    }

      // Relationship: ExtraFee belongs to a School
      public function school()
      {
        return $this->belongsTo(schools::classmodel);
      }

      public  function term(){
        return $this->belonsTo(Term::class);
      }

       
}
