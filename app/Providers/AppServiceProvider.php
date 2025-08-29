<?php

namespace App\Providers;
use App\Models\Student; 
use App\Observers\StudentObserver;
use App\Models\ClassFee; 
use App\Observers\ClassFeeObserver;
use App\Models\StudentExtraFee; 
use App\Observers\ExtraFeeAssignmentObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Student::observe(StudentObserver::class);
        ClassFee::observe(ClassFeeObserver::class);
        StudentExtraFee::observe(ExtraFeeAssignmentObserver::class);
    }
}
