<?php

namespace App\Providers;
use App\Models\Student; 
use App\Models\Expense;
use App\Observers\ExpenseObserver;
use App\Observers\StudentObserver;
use App\Models\ClassFee; 
use App\Observers\ClassFeeObserver;
use App\Models\StudentExtraFee; 
use App\Observers\ExtraFeeAssignmentObserver;
use Illuminate\Support\ServiceProvider;
use App\Models\OtherIncome;
use App\Observers\OtherIncomeObserver;


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
        Expense::observe(ExpenseObserver::class);
        OtherIncome::observe(OtherIncomeObserver::class);
    }
}
