<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\SchoolScope;

class Classes extends Model
{
    use HasFactory;
    protected $table='classes';

    protected static function booted()
    {
        static::addGlobalScope(new SchoolScope);
    }

    
    
    
}
