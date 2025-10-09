@extends('layouts.app')
@section('main')

<div class="main-wrapper">
    {{-- Page Header --}}
    <div class="page_title">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h4 class="mb-0">Term Management</h4>
                <p class="text-muted mb-0 mt-1">Manage academic terms and schedules</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('addterm') }}" class="btn btn-success px-4 py-2 fw-bold shadow-sm">
                    <i class="fa fa-plus me-2"></i>Add New Term
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

    {{-- Term List Table --}}
    <div class="row">
        <div class="col-12">
            <div class="table-card">
                <div class="card-header">
                    <h5>
                        <i class="fa fa-calendar-alt me-2" style="color: #fabb3d;"></i>Term List
                        <span class="badge bg-warning text-dark ms-2" style="font-size: 12px; padding: 6px 12px; border-radius: 20px;">
                            {{ count($getRecord) }} Total
                        </span>
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 80px;"><i class="fa fa-hashtag me-2"></i>ID</th>
                                    <th><i class="fa fa-bookmark me-2"></i>Term</th>
                                    <th><i class="fa fa-calendar me-2"></i>Year</th>
                                    <th><i class="fa fa-play-circle me-2"></i>Start Date</th>
                                    <th><i class="fa fa-stop-circle me-2"></i>End Date</th>
                                    <th><i class="fa fa-toggle-on me-2"></i>Status</th>
                                    <th style="min-width: 180px;"><i class="fa fa-cog me-2"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($getRecord as $value)
                                    <tr>
                                        <td>
                                            <span class="badge bg-light text-dark" style="padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                                #{{ $value->id }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="term-icon me-3" style="width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #fabb3d 0%, #f9a825 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                                    {{ strtoupper(substr($value->name, 0, 1)) }}
                                                </div>
                                                <strong>{{ $value->name }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #e3f2fd; color: #1976d2; padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                                {{ $value->year }}
                                            </span>
                                        </td>
                                        <td>
                                            <span style="color: #495057;">
                                                <i class="fa fa-calendar-day me-1 text-success"></i>
                                                {{ \Carbon\Carbon::parse($value->start_date)->format('d M, Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($value->end_date)
                                                <span style="color: #495057;">
                                                    <i class="fa fa-calendar-check me-1 text-danger"></i>
                                                    {{ \Carbon\Carbon::parse($value->end_date)->format('d M, Y') }}
                                                </span>
                                            @else
                                                <span class="text-muted" style="font-style: italic;">
                                                    <i class="fa fa-minus-circle me-1"></i>Not Set
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($value->active)
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
                                                <a href="{{ url('/editterm/' . $value->id) }}" 
                                                   class="btn btn-sm btn-primary" 
                                                   style="border-radius: 6px; padding: 6px 14px;" 
                                                   title="Edit Term">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ url('/deleteterm/' . $value->id) }}" 
                                                   class="btn btn-sm btn-danger" 
                                                   style="border-radius: 6px; padding: 6px 14px;"
                                                   onclick="return confirm('Are you sure you want to delete this term?')" 
                                                   title="Delete Term">
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
                                                <p class="mb-0">No terms available</p>
                                                <small>Click "Add New Term" to create one</small>
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
    .term-icon {
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
}
</style>

@endsection