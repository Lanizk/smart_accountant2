@extends('layouts.app')

@section('main')
<div class="main-wrapper">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="page_title">
                    <h4>Other Incomes</h4>
                </div>
                <a href="{{ route('other_incomes.create') }}" class="btn btn-quick-success" style="width: auto; display: inline-flex; align-items: center; padding: 12px 24px;">
                    <i class="fa fa-plus"></i> Add New Income
                </a>
            </div>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-left: 4px solid #79c347; background: rgba(121, 195, 71, 0.1); border-radius: 8px;">
            <i class="fa fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-left: 4px solid #ff4748; background: rgba(255, 71, 72, 0.1); border-radius: 8px;">
            <i class="fa fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Income Summary Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card-counter green_bg2">
                <i class="fa fa-money-bill-wave"></i>
                <span class="total_no">KSh {{ number_format($incomes->sum('amount'), 2) }}</span>
                <span class="head_couter">Total Income</span>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card-counter blue_bg">
                <i class="fa fa-calendar-check"></i>
                <span class="total_no">{{ $incomes->count() }}</span>
                <span class="head_couter">Total Entries</span>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card-counter yellow_bg">
                <i class="fa fa-clock"></i>
                <span class="total_no">KSh {{ number_format($incomes->where('income_date', '>=', now()->startOfMonth())->sum('amount'), 2) }}</span>
                <span class="head_couter">This Month</span>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card-counter purple_bg">
                <i class="fa fa-tags"></i>
                <span class="total_no">{{ $incomes->groupBy('income_category_id')->count() }}</span>
                <span class="head_couter">Categories Used</span>
            </div>
        </div>
    </div>

    <!-- Income Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="table-card">
                <div class="card-header">
                    <h5><i class="fa fa-list me-2"></i>All Income Records</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><i class="fa fa-folder me-2"></i>Category</th>
                                    <th><i class="fa fa-money-bill me-2"></i>Amount</th>
                                    <th><i class="fa fa-credit-card me-2"></i>Payment Method</th>
                                    <th><i class="fa fa-calendar me-2"></i>Date</th>
                                    <th><i class="fa fa-comment me-2"></i>Description</th>
                                    <th style="min-width:120px; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($incomes as $income)
                                    <tr>
                                        <td><strong>{{ $loop->iteration }}</strong></td>
                                        <td>
                                            <span class="badge" style="background: linear-gradient(135deg, #8e68ef 0%, #7344e8 100%); color: #fff; padding: 6px 12px; border-radius: 6px; font-weight: 500;">
                                                {{ $income->category->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong style="color: #1ed085; font-size: 15px;">
                                                KSh {{ number_format($income->amount, 2) }}
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-status" style="background: #36a9e2; color: #fff;">
                                                {{ ucfirst($income->payment_method) ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $income->income_date ? \Carbon\Carbon::parse($income->income_date)->format('d M Y') : '-' }}
                                        </td>
                                        <td>
                                            <span style="color: #898989; font-size: 13px;">
                                                {{ Str::limit($income->description, 50) }}
                                            </span>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="{{ route('other_incomes.edit', $income->id) }}" 
                                               class="btn-action" 
                                               title="Edit"
                                               style="background: #36a9e2; border-color: #36a9e2; color: #fff;">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('other_incomes.destroy', $income->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this income record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn-action" 
                                                        title="Delete"
                                                        style="background: #ff4748; border-color: #ff4748; color: #fff;">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 40px;">
                                            <div style="color: #b0b0b0;">
                                                <i class="fa fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                                                <h5 style="color: #898989; font-weight: 500;">No Income Records Found</h5>
                                                <p style="color: #b0b0b0; font-size: 14px;">Start by adding your first income entry.</p>
                                                <a href="{{ route('other_incomes.create') }}" class="btn btn-quick-success mt-3" style="width: auto; display: inline-flex; align-items: center; padding: 10px 20px;">
                                                    <i class="fa fa-plus me-2"></i> Add New Income
                                                </a>
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

    <!-- Pagination (if applicable) -->
    @if(method_exists($incomes, 'links'))
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-center">
                    {{ $incomes->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    /* Additional styles for this page */
    .alert {
        border: none;
        padding: 15px 20px;
        margin-bottom: 20px;
    }

    .alert i {
        font-size: 18px;
        vertical-align: middle;
    }

    .btn-close {
        padding: 0.5rem;
    }

    /* Ensure action buttons align properly */
    .btn-action {
        margin: 0 3px;
    }

    /* Hover effects for table rows */
    .custom-table tbody tr {
        transition: all 0.2s ease;
    }

    .custom-table tbody tr:hover {
        background: #f8f9fa;
        transform: scale(1.002);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    /* Badge hover effect */
    .badge:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-counter {
            margin-bottom: 15px;
        }

        .table-responsive {
            font-size: 13px;
        }

        .btn-action {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }
    }
</style>
@endsection
