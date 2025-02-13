<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classmodel extends Model
{
    use HasFactory;
    protected $table='classmodels';



    public function extraFee()
    {
      return $this->belongsToMany(extrafee::class,'extrafee_class');
    }

    static public function getRecord(){
        $return=Classmodel::select('classmodels.*');
        $return = $return->orderBy('classmodels.id', 'desc')
        ->paginate(20);
        return $return;
    }

    static public function getClass(){
      $return=classModel::all();
      return $return;
    }
    
}
