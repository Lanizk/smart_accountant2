@extends('layouts.app')
@section('main')

<div class="main-wrapper">
    {{-- Page Header --}}
    <div class="page_title">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h4 class="mb-0">Student Invoices</h4>
                <p class="text-muted mb-0 mt-1">Manage student fees, payments, and statements</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <button type="button" 
                        class="btn btn-primary px-4 py-2 shadow-sm" 
                        data-bs-toggle="modal" 
                        data-bs-target="#bulkPrintModal">
                    <i class="fa fa-print me-2"></i>Print All Statements
                </button>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; border-radius: 8px;">
            <i class="fa fa-check-circle me-2"></i>
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #dc3545; border-radius: 8px;">
            <i class="fa fa-exclamation-circle me-2"></i>
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Invoices Table --}}
    <div class="row">
        <div class="col-12">
            <div class="table-card">
                <div class="card-header">
                    <h5>
                        <i class="fa fa-file-invoice-dollar me-2" style="color: #79c347;"></i>Student Fee Summary
                        <span class="badge bg-success ms-2" style="font-size: 12px; padding: 6px 12px; border-radius: 20px;">
                            {{ count($invoices) }} Total
                        </span>
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table mb-0">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-user me-2"></i>Student</th>
                                    <th><i class="fa fa-school me-2"></i>Class</th>
                                    <th><i class="fa fa-file-invoice me-2"></i>Total Fee</th>
                                    <th><i class="fa fa-check-circle me-2"></i>Paid</th>
                                    <th><i class="fa fa-exclamation-circle me-2"></i>Balance</th>
                                    <th style="min-width: 250px;"><i class="fa fa-cog me-2"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $i => $invoice)
                                    @php
                                        $student = $invoice->student;
                                        $paid = $invoice->amount_paid;
                                        $balance = $invoice->balance;
                                        $rowId = "details-row-{$i}";
                                        $paymentRowId = "payment-row-{$i}";
                                    @endphp

                                    {{-- Summary Row --}}
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-3" style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #36a9e2 0%, #1e88c7 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $student->name }}</div>
                                                    <div class="text-muted small">{{ $student->admission }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #e3f2fd; color: #1976d2; padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                                {{ $student->class->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: linear-gradient(135deg, #8e68ef 0%, #7344e8 100%); color: white; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                                                <i class="fa fa-coins me-1"></i>KSh {{ number_format($invoice->total_amount, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: linear-gradient(135deg, #79c347 0%, #5fa732 100%); color: white; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                                                <i class="fa fa-check me-1"></i>KSh {{ number_format($paid, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($balance > 0)
                                                <span class="badge" style="background: linear-gradient(135deg, #ff4748 0%, #e63946 100%); color: white; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                                                    <i class="fa fa-exclamation-triangle me-1"></i>KSh {{ number_format($balance, 2) }}
                                                </span>
                                            @else
                                                <span class="badge badge-status badge-paid" style="display: inline-flex; align-items: center; gap: 5px;">
                                                    <i class="fa fa-check-double"></i>Cleared
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button type="button"
                                                        class="btn btn-sm btn-primary toggle-row"
                                                        style="border-radius: 6px; padding: 6px 14px;"
                                                        data-target="{{ $rowId }}"
                                                        data-label="Details"
                                                        title="View Details">
                                                    <i class="fa fa-eye me-1"></i><span class="btn-text">Details</span>
                                                </button>
                                                <button type="button"
                                                        class="btn btn-sm btn-success toggle-row"
                                                        style="border-radius: 6px; padding: 6px 14px;"
                                                        data-target="{{ $paymentRowId }}"
                                                        data-label="Payment"
                                                        title="Add Payment">
                                                    <i class="fa fa-plus me-1"></i><span class="btn-text">Payment</span>
                                                </button>
                                                <a href="{{ route('statements.single', $invoice->student->id) }}" 
                                                   class="btn btn-sm btn-secondary" 
                                                   style="border-radius: 6px; padding: 6px 14px;"
                                                   title="Print Statement">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Details Row --}}
                                    <tr id="{{ $rowId }}" class="details-row d-none">
                                        <td colspan="6" style="background: #fafbfc; padding: 0;">
                                            <div class="p-4">
                                                <div class="row">
                                                    {{-- Fee Breakdown --}}
                                                    <div class="col-md-6 mb-3">
                                                        <h6 class="fw-semibold mb-3" style="color: #2c3e50; font-size: 15px;">
                                                            <i class="fa fa-list-ul me-2" style="color: #8e68ef;"></i>Fee Breakdown
                                                        </h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-hover mb-0" style="font-size: 13px;">
                                                                <thead style="background: #f0f2f5;">
                                                                    <tr>
                                                                        <th style="padding: 10px;">Item</th>
                                                                        <th class="text-end" style="padding: 10px;">Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($invoice->items as $item)
                                                                        <tr>
                                                                            <td style="padding: 8px;">{{ $item->description }}</td>
                                                                            <td class="text-end" style="padding: 8px;">KSh {{ number_format($item->amount, 2) }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    <tr style="background: #f8f9fa; font-weight: 600;">
                                                                        <td class="text-end" style="padding: 10px;">Total</td>
                                                                        <td class="text-end" style="padding: 10px;">KSh {{ number_format($invoice->total_amount, 2) }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    {{-- Payment History --}}
                                                    <div class="col-md-6 mb-3">
                                                        <h6 class="fw-semibold mb-3" style="color: #2c3e50; font-size: 15px;">
                                                            <i class="fa fa-history me-2" style="color: #79c347;"></i>Payment History
                                                        </h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-hover mb-0" style="font-size: 13px;">
                                                                <thead style="background: #f0f2f5;">
                                                                    <tr>
                                                                        <th style="padding: 10px;">Date</th>
                                                                        <th style="padding: 10px;">Method</th>
                                                                        <th class="text-end" style="padding: 10px;">Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse($invoice->payments as $p)
                                                                        <tr>
                                                                            <td style="padding: 8px;">{{ $p->payment_date }}</td>
                                                                            <td style="padding: 8px;">
                                                                                <span class="badge bg-light text-dark" style="font-size: 11px;">{{ $p->method }}</span>
                                                                            </td>
                                                                            <td class="text-end" style="padding: 8px;">KSh {{ number_format($p->amount, 2) }}</td>
                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="3" class="text-muted text-center" style="padding: 15px;">
                                                                                <i class="fa fa-info-circle me-1"></i>No payments recorded yet
                                                                            </td>
                                                                        </tr>
                                                                    @endforelse
                                                                    <tr style="background: #f8f9fa; font-weight: 600;">
                                                                        <td colspan="2" class="text-end" style="padding: 10px;">Total Paid</td>
                                                                        <td class="text-end" style="padding: 10px; color: #79c347;">KSh {{ number_format($invoice->amount_paid, 2) }}</td>
                                                                    </tr>
                                                                    <tr style="background: #f8f9fa; font-weight: 600;">
                                                                        <td colspan="2" class="text-end" style="padding: 10px;">Balance</td>
                                                                        <td class="text-end" style="padding: 10px; color: {{ $balance > 0 ? '#ff4748' : '#79c347' }};">
                                                                            {{ $balance > 0 ? 'KSh '.number_format($balance, 2) : 'Cleared' }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Payment Form Row --}}
                                    <tr class="payment-form-row d-none" id="{{ $paymentRowId }}">
                                        <td colspan="6" style="background: #f0f9ff; padding: 0;">
                                            <div class="p-4">
                                                <h6 class="fw-semibold mb-3" style="color: #2c3e50; font-size: 15px;">
                                                    <i class="fa fa-plus-circle me-2" style="color: #79c347;"></i>Add Payment
                                                </h6>
                                                <form action="{{ route('payments.store', $invoice->id) }}" method="POST" class="row g-3">
                                                    @csrf
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold" style="font-size: 13px;">
                                                            <i class="fa fa-money-bill-wave me-1 text-success"></i>Amount (KSh)
                                                        </label>
                                                        <input type="number" 
                                                               name="amount" 
                                                               class="form-control" 
                                                               placeholder="Enter amount" 
                                                               step="0.01"
                                                               style="border-radius: 8px; padding: 10px;"
                                                               required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold" style="font-size: 13px;">
                                                            <i class="fa fa-credit-card me-1 text-info"></i>Payment Method
                                                        </label>
                                                        <select name="method" class="form-select" style="border-radius: 8px; padding: 10px;" required>
                                                            <option value="Cash">Cash</option>
                                                            <option value="Mpesa">M-Pesa</option>
                                                            <option value="Bank">Bank Transfer</option>
                                                            <option value="Cheque">Cheque</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold" style="font-size: 13px;">&nbsp;</label>
                                                        <button type="submit" class="btn btn-success w-100" style="border-radius: 8px; padding: 10px;">
                                                            <i class="fa fa-check-circle me-2"></i>Add Payment
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div style="color: #9ca3af;">
                                                <i class="fa fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                                                <p class="mb-0">No invoices found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Bulk Print Modal --}}
<div class="modal fade" id="bulkPrintModal" tabindex="-1" aria-labelledby="bulkPrintModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
            <form method="POST" action="{{ route('statements.bulk') }}">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, #36a9e2 0%, #1e88c7 100%); border-radius: 12px 12px 0 0; border: none;">
                    <h5 class="modal-title" id="bulkPrintModalLabel" style="color: white; font-weight: 600;">
                        <i class="fa fa-print me-2"></i>Bulk Print Statements
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <div class="mb-3">
                        <label for="class_id" class="form-label fw-semibold" style="font-size: 14px;">
                            <i class="fa fa-school me-2 text-primary"></i>Select Class
                        </label>
                        <select name="class_id" id="class_id" class="form-select" style="border-radius: 8px; padding: 10px;" required>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="term_id" class="form-label fw-semibold" style="font-size: 14px;">
                            <i class="fa fa-calendar me-2 text-warning"></i>Select Term
                        </label>
                        <select name="term_id" id="term_id" class="form-select" style="border-radius: 8px; padding: 10px;" required>
                            @foreach($terms as $term)
                                <option value="{{ $term->id }}">{{ $term->name }} - {{ $term->year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e8eaed; padding: 20px 30px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">
                        <i class="fa fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" style="border-radius: 8px;">
                        <i class="fa fa-download me-2"></i>Download Zip
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Button Styles */
.btn-primary {
    background: linear-gradient(135deg, #36a9e2 0%, #1e88c7 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(54, 169, 226, 0.3);
}

.btn-success {
    background: linear-gradient(135deg, #79c347 0%, #5fa732 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(121, 195, 71, 0.3);
}

.btn-secondary {
    background: #6c757d;
    border: none;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #5a6268;
}

/* Modal Styling */
.btn-close-white {
    filter: brightness(0) invert(1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .user-avatar {
        width: 32px !important;
        height: 32px !important;
        font-size: 12px !important;
    }
    
    .btn-sm {
        padding: 4px 10px !important;
        font-size: 12px;
    }

    .btn-sm .btn-text {
        display: none;
    }
    
    .table {
        font-size: 13px;
    }

    .badge {
        font-size: 11px !important;
        padding: 4px 8px !important;
    }
}
</style>

<script>
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.toggle-row');
    if (!btn) return;

    const row = document.getElementById(btn.dataset.target);
    if (!row) return;

    row.classList.toggle('d-none');

    // Update button text and icon
    const textSpan = btn.querySelector('.btn-text');
    const icon = btn.querySelector('i');
    
    if (row.classList.contains('d-none')) {
        if (btn.dataset.label === "Details") {
            if (textSpan) textSpan.textContent = "Details";
            if (icon) icon.className = "fa fa-eye me-1";
        } else {
            if (textSpan) textSpan.textContent = "Payment";
            if (icon) icon.className = "fa fa-plus me-1";
        }
    } else {
        if (textSpan) textSpan.textContent = "Hide";
        if (icon) icon.className = "fa fa-eye-slash me-1";
    }
});
</script>

@endsection
