@extends('layouts.app')

@section('main')
<div class="main-wrapper">
    {{-- Page Header --}}
    <div class="page_title">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h4 class="mb-0">Expense Categories</h4>
                <p class="text-muted mb-0 mt-1">Manage expense categories for financial tracking</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <button class="btn btn-success px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="fa fa-plus me-2"></i>Add Category
                </button>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #28a745; border-radius: 8px;">
            <i class="fa fa-check-circle me-2"></i>
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #dc3545; border-radius: 8px;">
            <div class="d-flex align-items-start">
                <i class="fa fa-exclamation-circle me-3 mt-1" style="font-size: 20px;"></i>
                <div class="flex-grow-1">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Categories Table --}}
    <div class="row">
        <div class="col-12">
            <div class="table-card">
                <div class="card-header">
                    <h5>
                        <i class="fa fa-list me-2" style="color: #ff4748;"></i>All Categories
                        <span class="badge bg-danger ms-2" style="font-size: 12px; padding: 6px 12px; border-radius: 20px;">
                            {{ count($categories) }} Total
                        </span>
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table custom-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 80px;"><i class="fa fa-hashtag me-2"></i>#</th>
                                    <th><i class="fa fa-tag me-2"></i>Name</th>
                                    <th><i class="fa fa-file-alt me-2"></i>Description</th>
                                    <th style="min-width: 180px;"><i class="fa fa-cog me-2"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>
                                            <span class="badge bg-light text-dark" style="padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                                #{{ $loop->iteration }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="category-icon me-3" style="width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #ff4748 0%, #e63946 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                                    {{ strtoupper(substr($category->name, 0, 1)) }}
                                                </div>
                                                <strong>{{ $category->name }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            @if($category->description)
                                                <span style="color: #495057; font-size: 13px;">{{ Str::limit($category->description, 50) }}</span>
                                            @else
                                                <span class="text-muted" style="font-style: italic; font-size: 13px;">
                                                    <i class="fa fa-minus-circle me-1"></i>No description
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-primary" 
                                                        style="border-radius: 6px; padding: 6px 14px;"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editCategoryModal{{ $category->id }}"
                                                        title="Edit Category">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <form action="{{ route('expense_categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            style="border-radius: 6px; padding: 6px 14px;"
                                                            onclick="return confirm('Are you sure you want to delete this category?')"
                                                            title="Delete Category">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div style="color: #9ca3af;">
                                                <i class="fa fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                                                <p class="mb-0">No categories found</p>
                                                <small>Click "Add Category" to create one</small>
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

{{-- Add Category Modal --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
            <form action="{{ route('expense_categories.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, #79c347 0%, #5fa732 100%); border-radius: 12px 12px 0 0; border: none;">
                    <h5 class="modal-title" id="addCategoryModalLabel" style="color: white; font-weight: 600;">
                        <i class="fa fa-plus-circle me-2"></i>Add Expense Category
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <div class="mb-3">
                        <label for="add_name" class="form-label fw-semibold" style="font-size: 14px; color: #495057; margin-bottom: 10px;">
                            <i class="fa fa-tag me-2 text-success"></i>Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               id="add_name"
                               name="name" 
                               class="form-control" 
                               placeholder="e.g., Transport, Utilities, Salaries"
                               style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px; font-size: 14px;"
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="add_description" class="form-label fw-semibold" style="font-size: 14px; color: #495057; margin-bottom: 10px;">
                            <i class="fa fa-file-alt me-2 text-info"></i>Description
                        </label>
                        <textarea id="add_description"
                                  name="description" 
                                  class="form-control" 
                                  rows="4" 
                                  placeholder="Enter a brief description (optional)"
                                  style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px; font-size: 14px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e8eaed; padding: 20px 30px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px; padding: 10px 20px;">
                        <i class="fa fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-success" style="border-radius: 8px; padding: 10px 20px;">
                        <i class="fa fa-save me-1"></i>Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Category Modals --}}
@foreach($categories as $category)
<div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
            <form action="{{ route('expense_categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header" style="background: linear-gradient(135deg, #36a9e2 0%, #1e88c7 100%); border-radius: 12px 12px 0 0; border: none;">
                    <h5 class="modal-title" style="color: white; font-weight: 600;">
                        <i class="fa fa-edit me-2"></i>Edit Category
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <div class="mb-3">
                        <label for="edit_name_{{ $category->id }}" class="form-label fw-semibold" style="font-size: 14px; color: #495057; margin-bottom: 10px;">
                            <i class="fa fa-tag me-2 text-primary"></i>Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               id="edit_name_{{ $category->id }}"
                               name="name" 
                               class="form-control" 
                               value="{{ $category->name }}"
                               style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px; font-size: 14px;"
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description_{{ $category->id }}" class="form-label fw-semibold" style="font-size: 14px; color: #495057; margin-bottom: 10px;">
                            <i class="fa fa-file-alt me-2 text-info"></i>Description
                        </label>
                        <textarea id="edit_description_{{ $category->id }}"
                                  name="description" 
                                  class="form-control" 
                                  rows="4"
                                  style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px; font-size: 14px;">{{ $category->description }}</textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e8eaed; padding: 20px 30px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px; padding: 10px 20px;">
                        <i class="fa fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" style="border-radius: 8px; padding: 10px 20px;">
                        <i class="fa fa-check me-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<style>
/* Modal Styling */
.btn-close-white {
    filter: brightness(0) invert(1);
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

.btn-secondary {
    background: #6c757d;
    border: none;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #5a6268;
}

/* Form Control Focus */
.form-control:focus {
    border-color: #79c347;
    box-shadow: 0 0 0 0.2rem rgba(121, 195, 71, 0.15);
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

    .modal-body {
        padding: 20px !important;
    }
}
</style>

@endsection
