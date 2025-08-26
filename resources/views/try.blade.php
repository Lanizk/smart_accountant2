@extends('layouts.app')
@section('main')

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<style>
  .details-row { background: #f9fafb; }
  .amount { white-space: nowrap; }
  .badge-light { background:#eef2f7; border:1px solid #dee2e6; }
  .balance-positive { color: #198754; font-weight: 600; }
  .balance-negative { color: #dc3545; font-weight: 600; }
</style>

<div class="row column_title mb-3">
  <div class="col-md-12">
    <div class="d-flex justify-content-between align-items-center page_title">
      <h2 class="m-0">Student Fee Management</h2>
      <div class="d-flex " style="gap:1rem;">
        <!-- Full Statement Print -->
        <a href="" class="btn btn-outline-primary px-4 py-2 fw-bold">
          Print All Statements
        </a>
        <!-- Assign Extra Fee -->
        <a href="{{ route('assignextrafee') }}" class="btn btn-success px-4 py-2 fw-bold">
          + Assign Extra Fee
        </a>
      </div>
    </div>
  </div>
</div>

{{-- Filters --}}
<form method="GET" action="{{ route('listextrafeestudents') }}">
  <div class="row mb-4">
    <div class="col-md-4">
      <label for="extra_fee_id" class="form-label">Extra Fee</label>
      <select name="extra_fee_id" id="extra_fee_id" class="form-control" onchange="this.form.submit()">
        <option value="">-- Filter by Extra Fee --</option>
        <option value="transport">Transport</option>
        <option value="meals">Meals</option>
        <option value="clubs">Clubs</option>
      </select>
    </div>
    <div class="col-md-4">
      <label for="student_name" class="form-label">Search Student</label>
      <input type="text" name="student_name" id="student_name" class="form-control" placeholder="Name or Admission No.">
    </div>
    <div class="col-md-4 d-flex align-items-end" style="gap:1rem;">
      <button type="submit" class="btn btn-primary w-100">Filter</button>
      <a href="{{ route('listextrafeestudents') }}" class="btn btn-secondary w-100">Reset</a>
    </div>
  </div>
</form>

@php
  // -------- Mock data for UI testing only --------
  $students = [
    [
      'id' => 1, 'admission' => 'ADM001', 'name' => 'John Mwangi', 'class' => 'Grade 6A',
      'class_fee' => 10000,
      'extra_fees' => [
        ['name' => 'Transport', 'amount' => 2000, 'qty' => 1],
        ['name' => 'Meals', 'amount' => 1500, 'qty' => 1],
      ],
      'payments' => [
        ['date' => '2025-01-15', 'amount' => 5000, 'method' => 'Mpesa'],
        ['date' => '2025-02-01', 'amount' => 3000, 'method' => 'Cash'],
      ]
    ],
    [
      'id' => 2, 'admission' => 'ADM002', 'name' => 'Mary Wanjiru', 'class' => 'Grade 5B',
      'class_fee' => 9500,
      'extra_fees' => [
        ['name' => 'Meals', 'amount' => 1500, 'qty' => 1],
      ],
      'payments' => [
        ['date' => '2025-01-20', 'amount' => 4000, 'method' => 'Bank Transfer'],
      ]
    ],
    [
      'id' => 3, 'admission' => 'ADM003', 'name' => 'Kevin Otieno', 'class' => 'Grade 7C',
      'class_fee' => 12000,
      'extra_fees' => [],
      'payments' => []
    ],
  ];
@endphp

<div class="row w-100">
  <div class="col-md-12">
    <div class="white_shd full margin_bottom_30">
      <div class="full graph_head">
        <div class="heading1 margin_0"><h2>Student Fee Summary</h2></div>
      </div>

      <div class="table_section padding_infor_info">
        <div class="table-responsive-lg">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>Student</th>
                <th>Class</th>
                <th>Total Fee</th>
                <th>Paid</th>
                <th>Balance</th>
                <th style="min-width:200px;">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($students as $i => $s)
                @php
                  $extraTotal = collect($s['extra_fees'])->sum(fn($e) => $e['amount'] * $e['qty']);
                  $totalFee = $s['class_fee'] + $extraTotal;
                  $paid = collect($s['payments'])->sum('amount');
                  $balance = $totalFee - $paid;
                  $rowId = "details-row-{$i}";
                @endphp

                {{-- Summary row --}}
                <tr>
                  <td>
                    <div class="fw-semibold">{{ $s['name'] }}</div>
                    <div class="text-muted small">{{ $s['admission'] }}</div>
                  </td>
                  <td>{{ $s['class'] }}</td>
                  <td class="amount fw-bold">KES {{ number_format($totalFee) }}</td>
                  <td class="amount text-success">KES {{ number_format($paid) }}</td>
                  <td class="amount {{ $balance > 0 ? 'balance-negative' : 'balance-positive' }}">
                    {{ $balance > 0 ? 'KES '.number_format($balance) : 'Cleared' }}
                  </td>
                  <td>
                      <div class="d-flex align-items-center" style="gap:1rem;">
                    <button type="button"
                            class="btn btn-outline-primary btn-sm toggle-row"
                            data-target="{{ $rowId }}">
                      View Details
                    </button>
                    <a href="{{ route('assignextrafee') }}" class="btn btn-outline-success btn-sm ms-2">Add Payment</a>
                    <!-- Row-level Print Button -->
                    <a href="" 
                       class="btn btn-outline-secondary btn-sm ms-2">
                      Print Statement
                    </a>
</div>
                  </td>
                </tr>

                {{-- Collapsible details row --}}
                <tr id="{{ $rowId }}" class="details-row d-none">
                  <td colspan="6">
                    <div class="p-3">
                      {{-- Breakdown --}}
                      <div class="fw-semibold mb-2">Fee Breakdown</div>
                      <table class="table table-sm mb-4">
                        <thead>
                          <tr>
                            <th>Item</th><th class="text-center">Qty</th>
                            <th class="text-end">Unit</th><th class="text-end">Subtotal</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Class Fee ({{ $s['class'] }})</td>
                            <td class="text-center">1</td>
                            <td class="text-end">KES {{ number_format($s['class_fee']) }}</td>
                            <td class="text-end">KES {{ number_format($s['class_fee']) }}</td>
                          </tr>
                          @foreach($s['extra_fees'] as $e)
                            <tr>
                              <td>{{ $e['name'] }}</td>
                              <td class="text-center">{{ $e['qty'] }}</td>
                              <td class="text-end">KES {{ number_format($e['amount']) }}</td>
                              <td class="text-end">KES {{ number_format($e['amount']*$e['qty']) }}</td>
                            </tr>
                          @endforeach
                          <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th class="text-end">KES {{ number_format($totalFee) }}</th>
                          </tr>
                        </tbody>
                      </table>

                      {{-- Payment History --}}
                      <div class="fw-semibold mb-2">Payment History</div>
                      <table class="table table-sm mb-0">
                        <thead>
                          <tr>
                            <th>Date</th><th>Method</th><th class="text-end">Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse($s['payments'] as $p)
                            <tr>
                              <td>{{ $p['date'] }}</td>
                              <td>{{ $p['method'] }}</td>
                              <td class="text-end">KES {{ number_format($p['amount']) }}</td>
                            </tr>
                          @empty
                            <tr>
                              <td colspan="3" class="text-muted">No payments yet.</td>
                            </tr>
                          @endforelse
                          <tr>
                            <th colspan="2" class="text-end">Total Paid</th>
                            <th class="text-end">KES {{ number_format($paid) }}</th>
                          </tr>
                          <tr>
                            <th colspan="2" class="text-end">Balance</th>
                            <th class="text-end {{ $balance > 0 ? 'balance-negative' : 'balance-positive' }}">
                              {{ $balance > 0 ? 'KES '.number_format($balance) : 'Cleared' }}
                            </th>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </td>
                </tr>

              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.toggle-row');
    if (!btn) return;
    const row = document.getElementById(btn.dataset.target);
    if (!row) return;
    row.classList.toggle('d-none');
    btn.textContent = row.classList.contains('d-none') ? 'View Details' : 'Hide Details';
  });
</script>

@endsection
