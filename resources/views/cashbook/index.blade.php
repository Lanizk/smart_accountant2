@extends('layouts.app')

@section('main')
<div class="main-wrapper">
    {{-- Page Header --}}
    <div class="page_title">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h4 class="mb-0">Cashbook</h4>
                <p class="text-muted mb-0 mt-1">Track all cash inflows and outflows</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="stat-card-secondary stat-teal d-inline-block" style="padding: 15px 25px; margin: 0;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-secondary" style="width: 50px; height: 50px; font-size: 22px;">
                            <i class="fa fa-wallet"></i>
                        </div>
                        <div>
                            <p style="margin: 0; font-size: 12px; color: #6c757d; font-weight: 500;">Current Balance</p>
                            <h4 style="margin: 0; font-size: 24px; font-weight: 700; color: #2c3e50;">KSh {{ number_format($balance, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Cashbook Table --}}
    <div class="row">
        <div class="col-12">
            <div class="table-card">
                <div class="card-header">
                    <h5>
                        <i class="fa fa-book me-2" style="color: #36a9e2;"></i>Transaction History
                        <span class="badge bg-primary ms-2" style="font-size: 12px; padding: 6px 12px; border-radius: 20px;">
                            {{ $entries->total() }} Entries
                        </span>
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 120px;"><i class="fa fa-calendar me-2"></i>Date</th>
                                    <th><i class="fa fa-file-alt me-2"></i>Description</th>
                                    <th><i class="fa fa-credit-card me-2"></i>Payment Method</th>
                                    <th class="text-end" style="color: #79c347;"><i class="fa fa-arrow-down me-2"></i>Cash Inflow (KSh)</th>
                                    <th class="text-end" style="color: #ff4748;"><i class="fa fa-arrow-up me-2"></i>Cash Outflow (KSh)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalInflow = 0;
                                    $totalOutflow = 0;
                                @endphp

                                @forelse($entries as $entry)
                                    <tr>
                                        <td>
                                            <span style="color: #495057;">
                                                <i class="fa fa-calendar-day me-1 text-primary"></i>
                                                {{ \Carbon\Carbon::parse($entry->transaction_date)->format('d M, Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="transaction-icon me-3" style="width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, {{ $entry->transaction_type === 'inflow' ? '#79c347 0%, #5fa732' : '#ff4748 0%, #e63946' }} 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                                                    <i class="fa fa-{{ $entry->transaction_type === 'inflow' ? 'arrow-down' : 'arrow-up' }}"></i>
                                                </div>
                                                <span style="font-size: 13px;">{{ $entry->description }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #e3f2fd; color: #1976d2; padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                                {{ ucfirst($entry->payment_method) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            @if($entry->transaction_type === 'inflow')
                                                <span class="badge" style="background: linear-gradient(135deg, #79c347 0%, #5fa732 100%); color: white; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                                                    <i class="fa fa-plus-circle me-1"></i>{{ number_format($entry->amount, 2) }}
                                                </span>
                                                @php $totalInflow += $entry->amount; @endphp
                                            @else
                                                <span style="color: #9ca3af;">-</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if($entry->transaction_type === 'outflow')
                                                <span class="badge" style="background: linear-gradient(135deg, #ff4748 0%, #e63946 100%); color: white; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                                                    <i class="fa fa-minus-circle me-1"></i>{{ number_format($entry->amount, 2) }}
                                                </span>
                                                @php $totalOutflow += $entry->amount; @endphp
                                            @else
                                                <span style="color: #9ca3af;">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div style="color: #9ca3af;">
                                                <i class="fa fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                                                <p class="mb-0">No transactions found</p>
                                                <small>Transaction history will appear here</small>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                            @if($entries->count() > 0)
                            <tfoot style="background: #fafbfc; border-top: 2px solid #e8eaed;">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold" style="padding: 16px; color: #2c3e50; font-size: 14px;">
                                        <i class="fa fa-calculator me-2"></i>Totals:
                                    </td>
                                    <td class="text-end" style="padding: 16px;">
                                        <span class="badge" style="background: linear-gradient(135deg, #79c347 0%, #5fa732 100%); color: white; padding: 10px 16px; border-radius: 6px; font-weight: 700; font-size: 14px;">
                                            KSh {{ number_format($totalInflow, 2) }}
                                        </span>
                                    </td>
                                    <td class="text-end" style="padding: 16px;">
                                        <span class="badge" style="background: linear-gradient(135deg, #ff4748 0%, #e63946 100%); color: white; padding: 10px 16px; border-radius: 6px; font-weight: 700; font-size: 14px;">
                                            KSh {{ number_format($totalOutflow, 2) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr style="background: #f0f9ff;">
                                    <td colspan="3" class="text-end fw-bold" style="padding: 16px; color: #2c3e50; font-size: 15px;">
                                        <i class="fa fa-wallet me-2"></i>Closing Balance:
                                    </td>
                                    <td colspan="2" class="text-end" style="padding: 16px;">
                                        <span class="badge" style="background: linear-gradient(135deg, #36a9e2 0%, #1e88c7 100%); color: white; padding: 12px 20px; border-radius: 6px; font-weight: 700; font-size: 16px;">
                                            KSh {{ number_format($totalInflow - $totalOutflow, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                @if($entries->hasPages())
                <div class="card-footer" style="background: #fafbfc; padding: 20px 25px; border-top: 1px solid #e8eaed; border-radius: 0 0 12px 12px;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="mb-2 mb-sm-0">
                            <small class="text-muted">
                                Showing {{ $entries->firstItem() }} to {{ $entries->lastItem() }} of {{ $entries->total() }} entries
                            </small>
                        </div>
                        <div>
                            {{ $entries->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
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

/* Pagination Styling */
.pagination {
    margin: 0;
}

.pagination .page-link {
    border-radius: 6px;
    margin: 0 3px;
    border: 1px solid #e0e0e0;
    color: #6c757d;
    padding: 8px 14px;
}

.pagination .page-link:hover {
    background: #36a9e2;
    color: white;
    border-color: #36a9e2;
}

.pagination .page-item.active .page-link {
    background: #36a9e2;
    border-color: #36a9e2;
}

/* Responsive Design */
@media (max-width: 768px) {
    .transaction-icon {
        width: 28px !important;
        height: 28px !important;
        font-size: 11px !important;
    }
    
    .table {
        font-size: 13px;
    }

    .badge {
        font-size: 11px !important;
        padding: 4px 8px !important;
    }

    .stat-card-secondary {
        width: 100%;
        margin-bottom: 15px;
    }

    tfoot .badge {
        font-size: 12px !important;
        padding: 6px 10px !important;
    }
}

@media (max-width: 576px) {
    .table thead th:nth-child(3),
    .table tbody td:nth-child(3) {
        display: none;
    }
}
</style>

@endsection