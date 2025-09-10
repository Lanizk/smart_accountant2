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
  .balance-positive { color: #198754; font-weight: 600; }
  .balance-negative { color: #dc3545; font-weight: 600; }
</style>

<div class="row column_title mb-3">
  <div class="col-md-12">
    <div class="d-flex justify-content-between align-items-center page_title">
      <h2 class="m-0">Student Invoices</h2>
      <div class="d-flex " style="gap:1rem;">
       {{-- Bulk Print Button --}}
<button type="button" class="btn btn-outline-primary px-4 py-2 fw-bold"
        data-toggle="modal" data-target="#bulkPrintModal">
  Print All Statements
</button>

{{-- Bulk Print Modal --}}
<div class="modal fade" id="bulkPrintModal" tabindex="-1" role="dialog" aria-labelledby="bulkPrintModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <form method="POST" action="{{ route('statements.bulk') }}">
        @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="bulkPrintModalLabel">Bulk Print Statements</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="class_id" class="form-label">Select Class</label>
            <select name="class_id" id="class_id" class="form-control" required>
              @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
             <label for="term_id" class="form-label">Select Term</label>
             <select name="term_id" id="term_id" class="form-control" required>
             @foreach($terms as $term)
             <option value="{{ $term->id }}">{{ $term->name }}</option>
             @endforeach
             </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Download Zip</button>
        </div>
      </form>
    </div>
  </div>
</div>

       
      </div>
    </div>
  </div>
</div>

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
              @foreach($invoices as $i => $invoice)
                @php
                  $student = $invoice->student;
                  $paid = $invoice->amount_paid;
                  $balance = $invoice->balance;
                  $rowId = "details-row-{$i}";
                  $paymentRowId = "payment-row-{$i}";
                @endphp

                {{-- Summary row --}}
                <tr>
                  <td>
                    <div class="fw-semibold">{{ $student->name }}</div>
                    <div class="text-muted small">{{ $student->admission_no }}</div>
                  </td>
                  <td>{{ $student->class->name ?? '-' }}</td>
                  <td class="amount fw-bold">KES {{ number_format($invoice->total_amount) }}</td>
                  <td class="amount text-success">KES {{ number_format($paid) }}</td>
                  <td class="amount {{ $balance > 0 ? 'balance-negative' : 'balance-positive' }}">
                    {{ $balance > 0 ? 'KES '.number_format($balance) : 'Cleared' }}
                  </td>
                  <td>
                    <div class="d-flex align-items-center" style="gap:1rem;">
                      <button type="button"
                              class="btn btn-outline-primary btn-sm toggle-row"
                              data-target="{{ $rowId }}"
                              data-label="Details">
                        View Details
                      </button>
                      <button type="button"
                              class="btn btn-outline-success btn-sm toggle-row"
                              data-target="{{ $paymentRowId }}"
                              data-label="Payment">
                        Add Payment
                      </button>
                     <a href="{{ route('statements.single', $invoice->student->id) }}" 
                        class="btn btn-outline-secondary btn-sm">
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
                            <th>Item</th>
                            <th class="text-end">Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($invoice->items as $item)
                            <tr>
                              <td>{{ $item->description }}</td>
                              <td class="text-end">KES {{ number_format($item->amount) }}</td>
                            </tr>
                          @endforeach
                          <tr>
                            <th class="text-end">Total</th>
                            <th class="text-end">KES {{ number_format($invoice->total_amount) }}</th>
                          </tr>
                        </tbody>
                      </table>

                      {{-- Payment History --}}
                      <div class="fw-semibold mb-2">Payment History</div>
                      <table class="table table-sm mb-0">
                        <thead>
                          <tr>
                            <th>Date</th>
                            <th>Method</th>
                            <th class="text-end">Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse($invoice->payments as $p)
                            <tr>
                              <td>{{ $p->payment_date }}</td>
                              <td>{{ $p->method }}</td>
                              <td class="text-end">KES {{ number_format($p->amount) }}</td>
                            </tr>
                          @empty
                            <tr>
                              <td colspan="3" class="text-muted">No payments yet.</td>
                            </tr>
                          @endforelse
                          <tr>
                            <th colspan="2" class="text-end">Total Paid</th>
                            <th class="text-end">KES {{ number_format($invoice->amount_paid) }}</th>
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

                {{-- Separate row for Payment Form --}}
                <tr class="payment-form-row d-none" id="{{ $paymentRowId }}">
                  <td colspan="6">
                    <div class="p-3 bg-light border rounded">
                      <div class="fw-semibold mb-2">Add Payment</div>
                      <form action="{{ route('payments.store', $invoice->id) }}" method="POST" class="row g-2">
                        @csrf
                        <div class="col-md-4">
                          <input type="number" name="amount" class="form-control" placeholder="Amount" required>
                        </div>
                        <div class="col-md-4">
                          <select name="method" class="form-control" required>
                            <option value="Cash">Cash</option>
                            <option value="Mpesa">M-Pesa</option>
                            <option value="Bank">Bank</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <button type="submit" class="btn btn-success w-100">Add Payment</button>
                        </div>
                      </form>
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

    // Update button text dynamically
    if (row.classList.contains('d-none')) {
      btn.textContent = btn.dataset.label === "Details" ? "View Details" : "Add Payment";
    } else {
      btn.textContent = btn.dataset.label === "Details" ? "Hide Details" : "Hide Payment";
    }
  });
</script>

@endsection
