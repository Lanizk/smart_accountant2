<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Auth;

class SchoolScope implements Scope
{
    
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::check()) {
            $builder->where('school_id', Auth::user()->school_id);
        }
    }
}
