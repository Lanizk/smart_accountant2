<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classmodel extends Model
{
    use HasFactory;
    protected $table='classmodels';

    static public function getRecord(){
        $return=Classmodel::select('classmodels.*');
        $return = $return
        ->orderBy('classmodels.id', 'desc')
        ->paginate(20);
    return $return;
    }
    
}
