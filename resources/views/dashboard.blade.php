@extends('layouts.app')
@section('main')

<style>
   .card-counter {
      box-shadow: 0 4px 8px rgba(0,0,0,0.08);
      padding: 20px;
      border-radius: 12px;
      color: #fff;
      margin-bottom: 25px;
      text-align: center;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
   }

   .card-counter:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
   }

   .card-counter i {
      font-size: 32px;
      margin-bottom: 10px;
   }

   .card-counter .total_no {
      font-size: 26px;
      font-weight: bold;
   }

   .card-counter .head_couter {
      font-size: 14px;
      letter-spacing: 1px;
      text-transform: uppercase;
   }
</style>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
            @if($viewType == 'term')
         <h4 class="font-weight-bold ">Dashboard – {{ $currentTerm->name }} ({{ $currentTerm->year }})</h4>
      @else
         <h4 class="font-weight-bold text-success">Dashboard – Annual Summary ({{ $currentYear }})</h4>
      @endif
      </div>
   </div>
</div>

<!-- Dropdown filter -->
<!-- <div class="row mb-4">
   <div class="col-md-4">
      <form method="GET" action="{{ route('dashboard') }}">
         <label for="view" class="font-weight-bold">Select View:</label>
         <select name="view" id="view" class="form-control" onchange="this.form.submit()">
            <option value="term" {{ $viewType == 'term' ? 'selected' : '' }}>Current Term</option>
            <option value="annual" {{ $viewType == 'annual' ? 'selected' : '' }}>Annual Summary</option>
         </select>
      </form>
   </div>
</div> -->

<!-- Financial Summary Title -->


<!-- Counters Section -->
<div class="row">
   <div class="col-md-6 col-lg-3">
      <div class="card-counter blue_bg">
         <i class="fa fa-credit-card"></i>
         <p class="total_no">{{ number_format($totalFeesBilled) }}</p>
         <p class="head_couter">Total Fees Billed</p>
      </div>
   </div>

   <div class="col-md-6 col-lg-3">
      <div class="card-counter green_bg">
         <i class="fa fa-money"></i>
         <p class="total_no">{{ number_format($totalFeesCollected) }}</p>
         <p class="head_couter">Total Fees Collected</p>
      </div>
   </div>

   <div class="col-md-6 col-lg-3">
      <div class="card-counter red_bg">
         <i class="fa fa-balance-scale"></i>
         <p class="total_no">{{ number_format($outstandingBalances) }}</p>
         <p class="head_couter">Outstanding Balances</p>
      </div>
   </div>

   <div class="col-md-6 col-lg-3">
      <div class="card-counter yellow_bg">
         <i class="fa fa-line-chart"></i>
         <p class="total_no">{{ number_format($netPosition) }}</p>
         <p class="head_couter">Net Position</p>
      </div>
   </div>
</div>

<!-- Extra row for Other Income & Expenses -->
<div class="row">
   <div class="col-md-6 col-lg-6">
      <div class="card-counter purple_bg">
         <i class="fa fa-plus-circle"></i>
         <p class="total_no">{{ number_format($otherIncome) }}</p>
         <p class="head_couter">Other Income</p>
      </div>
   </div>

   <div class="col-md-6 col-lg-6">
      <div class="card-counter green_bg2">
         <i class="fa fa-minus-circle"></i>
         <p class="total_no">{{ number_format($totalExpenses) }}</p>
         <p class="head_couter">Total Expenses</p>
      </div>
   </div>
</div>



<div class="row mt-5">
    <div class="col-md-6">
        <div class="card p-3 shadow-sm">
            <h5 class="mb-3">Fees vs Collections</h5>
            <canvas id="feesPieChart"></canvas>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-3 shadow-sm">
            <h5 class="mb-3">Expenses Breakdown</h5>
            <canvas id="expensesPieChart"></canvas>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card p-3 shadow-sm">
            <h5 class="mb-3">Net Position Over Time</h5>
            <canvas id="netLineChart"></canvas>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
    // Fees vs Collections
    const feesCtx = document.getElementById('feesPieChart').getContext('2d');
    new Chart(feesCtx, {
        type: 'pie',
        data: {
            labels: ['Collected', 'Outstanding'],
            datasets: [{
                data: [{{ $totalFeesCollected }}, {{ $outstandingBalances }}],
                backgroundColor: ['#2ecc71', '#e74c3c'],
            }]
        },
        options: { responsive: true }
    });

    // Expenses Breakdown
    const expensesCtx = document.getElementById('expensesPieChart').getContext('2d');
    new Chart(expensesCtx, {
        type: 'pie',
        data: {
            labels: [
                @foreach($expensesByCategory as $exp)
                    '{{ $exp->category->name }}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($expensesByCategory as $exp)
                        {{ $exp->total }},
                    @endforeach
                ],
                backgroundColor: ['#3498db','#9b59b6','#f1c40f','#e67e22','#1abc9c','#e74c3c'],
            }]
        },
        options: { responsive: true }
    });

    // Net Position Over Time
    const netCtx = document.getElementById('netLineChart').getContext('2d');
    new Chart(netCtx, {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                label: 'Net Position',
                data: [{{ implode(',', $monthlyNet) }}],
                borderColor: '#3498db',
                backgroundColor: 'rgba(52,152,219,0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>


@endsection
