<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class extrafee extends Model
{
    use HasFactory;
    protected $fillable=['school_id','name','term','amoount','for_entire_school'];

      // Relationship: ExtraFee belongs to a School
      public function school()
      {
        return $this->belongsTo(schools::classmodel);
      }

       // Relationship: ExtraFee belongs to many Classes (only if for_entire_school = false)
       
}
