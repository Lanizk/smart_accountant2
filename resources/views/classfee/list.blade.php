@extends('layouts.app')
@section('main')

<div class="main-wrapper">
    {{-- Page Header --}}
    <div class="page_title">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h4 class="mb-0">Fee Management</h4>
                <p class="text-muted mb-0 mt-1">Manage class fees and payment structures</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('addclassfee') }}" class="btn btn-success px-4 py-2 fw-bold shadow-sm">
                    <i class="fa fa-plus me-2"></i>Add New Fee
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

    {{-- Fee Amount List Table --}}
    <div class="row">
        <div class="col-12">
            <div class="table-card">
                <div class="card-header">
                    <h5>
                        <i class="fa fa-money-bill-wave me-2" style="color: #79c347;"></i>Fee Amount List
                        <span class="badge bg-success ms-2" style="font-size: 12px; padding: 6px 12px; border-radius: 20px;">
                            {{ count($classFees) }} Total
                        </span>
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table mb-0">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-school me-2"></i>Grade</th>
                                    <th><i class="fa fa-dollar-sign me-2"></i>Amount</th>
                                    <th><i class="fa fa-calendar me-2"></i>Term</th>
                                    <th><i class="fa fa-calendar-alt me-2"></i>Year</th>
                                    <th><i class="fa fa-file-alt me-2"></i>Description</th>
                                    <th><i class="fa fa-toggle-on me-2"></i>Status</th>
                                    <th style="min-width: 180px;"><i class="fa fa-cog me-2"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classFees as $value)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="grade-icon me-3" style="width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #8e68ef 0%, #7344e8 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                                {{ strtoupper(substr($value->class->name, 0, 1)) }}
                                            </div>
                                            <strong>{{ $value->class->name }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: linear-gradient(135deg, #79c347 0%, #5fa732 100%); color: white; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                                            <i class="fa fa-coins me-1"></i>KSh {{ number_format($value->amount, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: #e3f2fd; color: #1976d2; padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                            {{ $value->term->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                            {{ $value->year }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($value->description)
                                            <span style="color: #495057; font-size: 13px;">{{ Str::limit($value->description, 40) }}</span>
                                        @else
                                            <span class="text-muted" style="font-style: italic; font-size: 13px;">
                                                <i class="fa fa-minus-circle me-1"></i>No description
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(strtolower($value->status) == 'active')
                                            <span class="badge badge-status badge-paid" style="display: inline-flex; align-items: center; gap: 5px;">
                                                <i class="fa fa-check-circle"></i>Active
                                            </span>
                                        @else
                                            <span class="badge badge-status badge-overdue" style="display: inline-flex; align-items: center; gap: 5px;">
                                                <i class="fa fa-times-circle"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ url('/editclassfee/' . $value->id) }}" 
                                               class="btn btn-sm btn-primary" 
                                               style="border-radius: 6px; padding: 6px 14px;" 
                                               title="Edit Fee">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{ url('/deleteclassfee/' . $value->id) }}" 
                                               class="btn btn-sm btn-danger" 
                                               style="border-radius: 6px; padding: 6px 14px;"
                                               onclick="return confirm('Are you sure you want to delete this fee?')" 
                                               title="Delete Fee">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div style="color: #9ca3af;">
                                            <i class="fa fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                                            <p class="mb-0">No fees configured</p>
                                            <small>Click "Add New Fee" to create one</small>
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

.btn-danger {
    background: linear-gradient(135deg, #ff4748 0%, #e63946 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 71, 72, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .grade-icon {
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