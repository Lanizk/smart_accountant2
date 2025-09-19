@extends('layouts.app')
@section('main')

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Dashboard</h2>
      </div>
   </div>
</div>

<!-- Dropdown filter -->
<div class="row mb-4">
   <div class="col-md-4">
      <form method="GET" action="{{ route('dashboard') }}">
         <label for="view">Select View:</label>
         <select name="view" id="view" class="form-control" onchange="this.form.submit()">
            <option value="term" {{ $viewType == 'term' ? 'selected' : '' }}>Current Term</option>
            <option value="annual" {{ $viewType == 'annual' ? 'selected' : '' }}>Annual Summary</option>
         </select>
      </form>
   </div>
</div>

<!-- Financial Summary Title -->
<div class="row mb-3">
   <div class="col-md-12">
      @if($viewType == 'term')
         <h4>Dashboard – {{ $currentTerm->name }} ({{ $currentTerm->year }})</h4>
      @else
         <h4>Dashboard – Annual Summary ({{ $currentYear }})</h4>
      @endif
   </div>
</div>

<!-- Counters Section -->
<div class="row column1">
   <div class="col-md-6 col-lg-3">
      <div class="full counter_section margin_bottom_30">
         <div class="couter_icon">
            <div><i class="fa fa-credit-card blue1_color"></i></div>
         </div>
         <div class="counter_no">
            <div>
               <p class="total_no">{{ number_format($totalFeesBilled) }}</p>
               <p class="head_couter">Total Fees Billed</p>
            </div>
         </div>
      </div>
   </div>

   <div class="col-md-6 col-lg-3">
      <div class="full counter_section margin_bottom_30">
         <div class="couter_icon">
            <div><i class="fa fa-money green_color"></i></div>
         </div>
         <div class="counter_no">
            <div>
               <p class="total_no">{{ number_format($totalFeesCollected) }}</p>
               <p class="head_couter">Total Fees Collected</p>
            </div>
         </div>
      </div>
   </div>

   <div class="col-md-6 col-lg-3">
      <div class="full counter_section margin_bottom_30">
         <div class="couter_icon">
            <div><i class="fa fa-balance-scale red_color"></i></div>
         </div>
         <div class="counter_no">
            <div>
               <p class="total_no">{{ number_format($outstandingBalances) }}</p>
               <p class="head_couter">Outstanding Balances</p>
            </div>
         </div>
      </div>
   </div>

   <div class="col-md-6 col-lg-3">
      <div class="full counter_section margin_bottom_30">
         <div class="couter_icon">
            <div><i class="fa fa-line-chart yellow_color"></i></div>
         </div>
         <div class="counter_no">
            <div>
               <p class="total_no">{{ number_format($netPosition) }}</p>
               <p class="head_couter">Net Position</p>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Extra row for Other Income & Expenses -->
<div class="row column1">
   <div class="col-md-6 col-lg-6">
      <div class="full counter_section margin_bottom_30">
         <div class="couter_icon">
            <div><i class="fa fa-plus-circle green_color"></i></div>
         </div>
         <div class="counter_no">
            <div>
               <p class="total_no">{{ number_format($otherIncome) }}</p>
               <p class="head_couter">Other Income</p>
            </div>
         </div>
      </div>
   </div>

   <div class="col-md-6 col-lg-6">
      <div class="full counter_section margin_bottom_30">
         <div class="couter_icon">
            <div><i class="fa fa-minus-circle red_color"></i></div>
         </div>
         <div class="counter_no">
            <div>
               <p class="total_no">{{ number_format($totalExpenses) }}</p>
               <p class="head_couter">Total Expenses</p>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- footer -->
<div class="container-fluid">
   <div class="footer">
      <p>Copyright © 2018 Designed by html.design. All rights reserved.<br><br>
         Distributed By: <a href="https://themewagon.com/">ThemeWagon</a>
      </p>
   </div>
</div>

@endsection

