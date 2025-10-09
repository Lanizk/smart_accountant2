@extends('layouts.app')
@section('main')

<div class="main-wrapper">
    {{-- Page Header --}}
    <div class="page_title">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h4 class="mb-0">Expense Management</h4>
                <p class="text-muted mb-0 mt-1">Track and manage all business expenses</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('expenses.create') }}" class="btn btn-success px-4 py-2 fw-bold shadow-sm">
                    <i class="fa fa-plus me-2"></i>Add Expense
                </a>
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

    {{-- Search Filters Card --}}
    <div class="row">
        <div class="col-12">
            <div class="white_shd full margin_bottom_30" style="border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #f0f0f0;">
                <div class="full graph_head" style="background: #fafbfc; padding: 20px 25px; border-bottom: 1px solid #e8eaed; border-radius: 12px 12px 0 0;">
                    <div class="heading1 margin_0">
                        <h2 style="font-size: 18px; color: #2c3e50; font-weight: 600; margin: 0; display: flex; align-items: center;">
                            <i class="fa fa-filter me-2" style="color: #ff4748;"></i>Search Filters
                        </h2>
                    </div>
                </div>

                <div class="full inner_elements" style="padding: 25px;">
                    <form method="GET" action="{{ route('expenses.index') }}" class="row g-3">
                        {{-- Category Filter --}}
                        <div class="col-md-4">
                            <label for="category_id" class="form-label fw-semibold" style="font-size: 13px; color: #6c757d; margin-bottom: 8px;">
                                <i class="fa fa-tag me-1"></i>Category
                            </label>
                            <select name="category_id" id="category_id" class="form-select" style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 10px 14px;">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Payment Method Filter --}}
                        <div class="col-md-4">
                            <label for="payment_method" class="form-label fw-semibold" style="font-size: 13px; color: #6c757d; margin-bottom: 8px;">
                                <i class="fa fa-credit-card me-1"></i>Payment Method
                            </label>
                            <select name="payment_method" id="payment_method" class="form-select" style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 10px 14px;">
                                <option value="">All Methods</option>
                                <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="mpesa" {{ request('payment_method') == 'mpesa' ? 'selected' : '' }}>M-Pesa</option>
                                <option value="bank" {{ request('payment_method') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="cheque" {{ request('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                            </select>
                        </div>

                        {{-- Description Filter --}}
                        <div class="col-md-4">
                            <label for="description" class="form-label fw-semibold" style="font-size: 13px; color: #6c757d; margin-bottom: 8px;">
                                <i class="fa fa-search me-1"></i>Description
                            </label>
                            <input type="text" 
                                   name="description" 
                                   id="description"
                                   class="form-control" 
                                   value="{{ request('description') }}"
                                   placeholder="Search description"
                                   style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 10px 14px;">
                        </div>

                        {{-- Buttons --}}
                        <div class="col-12 d-flex justify-content-start align-items-center">
                            <button type="submit" class="btn btn-primary me-2" style="border-radius: 8px;">
                                <i class="fa fa-search me-1"></i>Filter
                            </button>
                            <a href="{{ route('expenses.index') }}" class="btn btn-secondary" style="border-radius: 8px;">
                                <i class="fa fa-refresh me-1"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Expenses List Table --}}
    <div class="row">
        <div class="col-12">
            <div class="table-card">
                <div class="card-header">
                    <h5>
                        <i class="fa fa-list-alt me-2" style="color: #ff4748;"></i>Expenses List
                        <span class="badge bg-danger ms-2" style="font-size: 12px; padding: 6px 12px; border-radius: 20px;">
                            {{ $expenses->total() }} Total
                        </span>
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 80px;"><i class="fa fa-hashtag me-2"></i>#</th>
                                    <th><i class="fa fa-tag me-2"></i>Category</th>
                                    <th><i class="fa fa-file-alt me-2"></i>Description</th>
                                    <th><i class="fa fa-dollar-sign me-2"></i>Amount</th>
                                    <th><i class="fa fa-credit-card me-2"></i>Payment Method</th>
                                    <th><i class="fa fa-calendar me-2"></i>Date</th>
                                    <th style="min-width: 180px;"><i class="fa fa-cog me-2"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expenses as $expense)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark" style="padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                            #{{ $loop->iteration }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="category-icon me-3" style="width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #ff4748 0%, #e63946 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                                {{ strtoupper(substr($expense->category?->name ?? 'N', 0, 1)) }}
                                            </div>
                                            <strong>{{ $expense->category?->name ?? 'N/A' }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        @if($expense->description)
                                            <span style="color: #495057; font-size: 13px;">{{ Str::limit($expense->description, 40) }}</span>
                                        @else
                                            <span class="text-muted" style="font-style: italic; font-size: 13px;">
                                                <i class="fa fa-minus-circle me-1"></i>No description
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge" style="background: linear-gradient(135deg, #ff4748 0%, #e63946 100%); color: white; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                                            <i class="fa fa-coins me-1"></i>KSh {{ number_format($expense->amount, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: #e3f2fd; color: #1976d2; padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                            {{ ucfirst($expense->payment_method) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span style="color: #495057;">
                                            <i class="fa fa-calendar-day me-1 text-warning"></i>
                                            {{ $expense->expense_date?->format('d M, Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('expenses.edit', $expense->id) }}" 
                                               class="btn btn-sm btn-primary" 
                                               style="border-radius: 6px; padding: 6px 14px;" 
                                               title="Edit Expense">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            @if($expense->deleted_at)
                                                <form action="{{ route('expenses.restore', $expense->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-sm btn-warning" 
                                                            style="border-radius: 6px; padding: 6px 14px;"
                                                            title="Restore Expense">
                                                        <i class="fa fa-undo"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" 
                                                            style="border-radius: 6px; padding: 6px 14px;"
                                                            onclick="return confirm('Are you sure you want to delete this expense?')"
                                                            title="Delete Expense">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div style="color: #9ca3af;">
                                            <i class="fa fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                                            <p class="mb-0">No expenses found</p>
                                            <small>Try adjusting your filters or click "Add Expense"</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                @if($expenses->hasPages())
                <div class="card-footer" style="background: #fafbfc; padding: 20px 25px; border-top: 1px solid #e8eaed; border-radius: 0 0 12px 12px;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="mb-2 mb-sm-0">
                            <small class="text-muted">
                                Showing {{ $expenses->firstItem() }} to {{ $expenses->lastItem() }} of {{ $expenses->total() }} entries
                            </small>
                        </div>
                        <div>
                            {{ $expenses->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Form Control Focus */
.form-select:focus,
.form-control:focus {
    border-color: #ff4748;
    box-shadow: 0 0 0 0.2rem rgba(255, 71, 72, 0.15);
}

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

.btn-danger {
    background: linear-gradient(135deg, #ff4748 0%, #e63946 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 71, 72, 0.3);
}

.btn-warning {
    background: linear-gradient(135deg, #fabb3d 0%, #f9a825 100%);
    border: none;
    color: white;
    transition: all 0.3s ease;
}

.btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(250, 187, 61, 0.3);
    color: white;
}

.btn-secondary {
    background: #6c757d;
    border: none;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #5a6268;
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
    background: #ff4748;
    color: white;
    border-color: #ff4748;
}

.pagination .page-item.active .page-link {
    background: #ff4748;
    border-color: #ff4748;
}

/* Responsive Design */
@media (max-width: 768px) {
    .category-icon {
        width: 32px !important;
        height: 32px !important;
        font-size: 12px !important;
    }
    
    .btn-sm {
        padding: 4px 10px !important;
        font-size: 12px;
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

@endsection
