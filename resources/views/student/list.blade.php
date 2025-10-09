@extends('layouts.app')
@section('main')

<div class="main-wrapper">
    {{-- Page Header --}}
    <div class="page_title">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h4 class="mb-0">Student Management</h4>
                <p class="text-muted mb-0 mt-1">Manage and view all student records</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('addStudents') }}" class="btn btn-primary px-4 py-2 fw-bold shadow-sm">
                    <i class="fa fa-plus me-2"></i>Add New Student
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
                            <i class="fa fa-filter me-2" style="color: #36a9e2;"></i>Search Filters
                        </h2>
                    </div>
                </div>

                <div class="full inner_elements" style="padding: 25px;">
                    <form method="GET" action="{{ route('listStudents') }}" class="row g-3">
                        {{-- Class Filter --}}
                        <div class="col-md-3">
                            <label for="class_id" class="form-label fw-semibold" style="font-size: 13px; color: #6c757d; margin-bottom: 8px;">
                                <i class="fa fa-school me-1"></i>Class
                            </label>
                            <select name="class_id" id="class_id" class="form-select" style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 10px 14px;">
                                <option value="">All Classes</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Term Filter --}}
                        <div class="col-md-3">
                            <label for="term_id" class="form-label fw-semibold" style="font-size: 13px; color: #6c757d; margin-bottom: 8px;">
                                <i class="fa fa-calendar me-1"></i>Term
                            </label>
                            <select name="term_id" id="term_id" class="form-select" style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 10px 14px;">
                                <option value="">All Terms</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term->id }}" {{ request('term_id') == $term->id ? 'selected' : '' }}>
                                        {{ $term->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Admission No Filter --}}
                        <div class="col-md-3">
                            <label for="admission" class="form-label fw-semibold" style="font-size: 13px; color: #6c757d; margin-bottom: 8px;">
                                <i class="fa fa-hashtag me-1"></i>Admission No
                            </label>
                            <input type="text" name="admission" id="admission" class="form-control" placeholder="Enter admission number" value="{{ request('admission') }}" style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 10px 14px;">
                        </div>

                        {{-- Name Filter --}}
                        <div class="col-md-3">
                            <label for="name" class="form-label fw-semibold" style="font-size: 13px; color: #6c757d; margin-bottom: 8px;">
                                <i class="fa fa-user me-1"></i>Student Name
                            </label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter student name" value="{{ request('name') }}" style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 10px 14px;">
                        </div>

                        {{-- Action Buttons --}}
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-4 py-2 me-2" style="border-radius: 8px;">
                                <i class="fa fa-search me-2"></i>Search
                            </button>
                            <a href="{{ route('listStudents') }}" class="btn btn-secondary px-4 py-2" style="border-radius: 8px;">
                                <i class="fa fa-refresh me-2"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Student List Table --}}
    <div class="row">
        <div class="col-12">
            <div class="table-card">
                <div class="card-header">
                    <h5>
                        <i class="fa fa-users me-2" style="color: #36a9e2;"></i>Student List
                        <span class="badge bg-primary ms-2" style="font-size: 12px; padding: 6px 12px; border-radius: 20px;">
                            {{ $getRecord->total() }} Total
                        </span>
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table mb-0">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-user me-2"></i>Full Name</th>
                                    <th><i class="fa fa-phone me-2"></i>Phone No</th>
                                    <th><i class="fa fa-hashtag me-2"></i>Admission No</th>
                                    <th><i class="fa fa-venus-mars me-2"></i>Gender</th>
                                    <th><i class="fa fa-school me-2"></i>Class</th>
                                    <th><i class="fa fa-calendar me-2"></i>Term</th>
                                    <th><i class="fa fa-cog me-2"></i>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($getRecord as $value)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3" style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                                {{ strtoupper(substr($value->name, 0, 1)) }}
                                            </div>
                                            <strong>{{ $value->name }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $value->phone ?: 'N/A' }}</td>
                                    <td><span class="badge bg-light text-dark" style="padding: 6px 12px; border-radius: 6px;">{{ $value->admission }}</span></td>
                                    <td>
                                        @if(strtolower($value->gender) == 'male')
                                            <span class="badge" style="background: #e3f2fd; color: #1976d2; padding: 6px 12px; border-radius: 6px;">
                                                <i class="fa fa-mars me-1"></i>Male
                                            </span>
                                        @elseif(strtolower($value->gender) == 'female')
                                            <span class="badge" style="background: #fce4ec; color: #c2185b; padding: 6px 12px; border-radius: 6px;">
                                                <i class="fa fa-venus me-1"></i>Female
                                            </span>
                                        @else
                                            <span class="badge bg-secondary" style="padding: 6px 12px; border-radius: 6px;">{{ $value->gender }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $value->class->name ?? 'N/A' }}</td>
                                    <td>{{ $value->term->name ?? 'N/A' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ url('/editstudent/' . $value->id) }}" class="btn btn-sm btn-primary" style="border-radius: 6px; padding: 6px 14px;" title="Edit Student">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{ url('/deletestudent/' . $value->id) }}" class="btn btn-sm btn-danger" style="border-radius: 6px; padding: 6px 14px;" onclick="return confirm('Are you sure you want to delete this student?')" title="Delete Student">
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
                                            <p class="mb-0">No students found</p>
                                            <small>Try adjusting your search filters</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                @if($getRecord->hasPages())
                <div class="card-footer" style="background: #fafbfc; padding: 20px 25px; border-top: 1px solid #e8eaed; border-radius: 0 0 12px 12px;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="mb-2 mb-sm-0">
                            <small class="text-muted">
                                Showing {{ $getRecord->firstItem() }} to {{ $getRecord->lastItem() }} of {{ $getRecord->total() }} entries
                            </small>
                        </div>
                        <div>
                            {{ $getRecord->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Pagination Styling */
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

/* Form Control Focus */
.form-select:focus,
.form-control:focus {
    border-color: #36a9e2;
    box-shadow: 0 0 0 0.2rem rgba(54, 169, 226, 0.15);
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

.btn-secondary {
    background: #6c757d;
    border: none;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
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

/* Responsive adjustments */
@media (max-width: 768px) {
    .table-responsive {
        border-radius: 8px;
    }
    
    .user-avatar {
        width: 32px !important;
        height: 32px !important;
        font-size: 12px !important;
    }
    
    .btn-sm {
        padding: 4px 10px !important;
        font-size: 12px;
    }
}
</style>

@endsection