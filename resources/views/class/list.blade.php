@extends('layouts.app')

@section('main')

<div class="main-wrapper">
    {{-- Page Header --}}
    <div class="page_title">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h4 class="mb-0">Grade Management</h4>
                <p class="text-muted mb-0 mt-1">Manage all class grades in the system</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <button type="button" class="btn btn-success px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addClassModal">
                    <i class="fa fa-plus me-2"></i>Add New Grade
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

    {{-- Grade List Table --}}
    <div class="row">
        <div class="col-12">
            <div class="table-card">
                <div class="card-header">
                    <h5>
                        <i class="fa fa-list me-2" style="color: #79c347;"></i>Grade List
                        <span class="badge bg-success ms-2" style="font-size: 12px; padding: 6px 12px; border-radius: 20px;">
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
                                    <th><i class="fa fa-school me-2"></i>Class Name</th>
                                    <th class="text-center" style="width: 200px;"><i class="fa fa-cog me-2"></i>Actions</th>
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
                                            <div class="grade-icon me-3" style="width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, #79c347 0%, #5fa732 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                                {{ strtoupper(substr($value->name, 0, 1)) }}
                                            </div>
                                            <strong>{{ $value->name }}</strong>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button 
                                                class="btn btn-sm btn-primary editBtn"
                                                style="border-radius: 6px; padding: 6px 14px;"
                                                data-id="{{ $value->id }}"
                                                data-name="{{ $value->name }}"
                                                title="Edit Grade">
                                                <i class="fa fa-edit me-1"></i>Edit
                                            </button>
                                            <a href="{{ url('/deleteClass/' . $value->id) }}" 
                                               class="btn btn-sm btn-danger" 
                                               style="border-radius: 6px; padding: 6px 14px;"
                                               onclick="return confirm('Are you sure you want to delete this grade?')"
                                               title="Delete Grade">
                                                <i class="fa fa-trash me-1"></i>Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5">
                                        <div style="color: #9ca3af;">
                                            <i class="fa fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                                            <p class="mb-0">No grades found</p>
                                            <small>Click "Add New Grade" to create one</small>
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

{{-- Edit Class Modal --}}
<div class="modal fade" id="editClassModal" tabindex="-1" aria-labelledby="editClassModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
            <form id="editClassForm" method="POST">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, #36a9e2 0%, #1e88c7 100%); border-radius: 12px 12px 0 0; border: none;">
                    <h5 class="modal-title" id="editClassModalLabel" style="color: white; font-weight: 600;">
                        <i class="fa fa-edit me-2"></i>Edit Grade
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <div class="form-group mb-0">
                        <label for="editName" class="form-label fw-semibold" style="font-size: 14px; color: #495057; margin-bottom: 10px;">
                            <i class="fa fa-school me-2 text-primary"></i>Class Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               id="editName" 
                               name="name" 
                               class="form-control" 
                               placeholder="Enter class name"
                               style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px; font-size: 14px;"
                               required>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e8eaed; padding: 20px 30px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px; padding: 10px 20px;">
                        <i class="fa fa-times me-1"></i>Close
                    </button>
                    <button type="submit" class="btn btn-primary" style="border-radius: 8px; padding: 10px 20px;">
                        <i class="fa fa-save me-1"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Add Class Modal --}}
<div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
            <form id="addClassForm" action="{{ route('insertclass') }}" method="POST">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, #79c347 0%, #5fa732 100%); border-radius: 12px 12px 0 0; border: none;">
                    <h5 class="modal-title" id="addClassModalLabel" style="color: white; font-weight: 600;">
                        <i class="fa fa-plus me-2"></i>Add New Grade(s)
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <div id="classInputs">
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold" style="font-size: 14px; color: #495057; margin-bottom: 10px;">
                                <i class="fa fa-school me-2 text-success"></i>Class Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="name[]" 
                                   class="form-control" 
                                   placeholder="Enter class name"
                                   style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px; font-size: 14px;"
                                   required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-success btn-sm" id="addMoreInput" style="border-radius: 6px;">
                        <i class="fa fa-plus-circle me-1"></i>Add Another Class
                    </button>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e8eaed; padding: 20px 30px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px; padding: 10px 20px;">
                        <i class="fa fa-times me-1"></i>Close
                    </button>
                    <button type="submit" class="btn btn-success" style="border-radius: 8px; padding: 10px 20px;">
                        <i class="fa fa-save me-1"></i>Save Classes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Modal Styling */
.modal-content {
    border: none;
}

.modal-header {
    padding: 20px 30px;
}

.btn-close-white {
    filter: brightness(0) invert(1);
}

/* Form Control Focus */
.form-control:focus {
    border-color: #79c347;
    box-shadow: 0 0 0 0.2rem rgba(121, 195, 71, 0.15);
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

.btn-outline-success {
    border: 2px solid #79c347;
    color: #79c347;
    transition: all 0.3s ease;
}

.btn-outline-success:hover {
    background: #79c347;
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .modal-body {
        padding: 20px !important;
    }

    .modal-footer {
        padding: 15px 20px !important;
    }

    .grade-icon {
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

<script>
// Add More Input Fields
document.getElementById('addMoreInput').addEventListener('click', function() {
    const container = document.getElementById('classInputs');
    const inputGroup = document.createElement('div');
    inputGroup.classList.add('form-group', 'mb-3', 'position-relative');
    inputGroup.innerHTML = `
        <label class="form-label fw-semibold" style="font-size: 14px; color: #495057; margin-bottom: 10px;">
            <i class="fa fa-school me-2 text-success"></i>Class Name <span class="text-danger">*</span>
        </label>
        <div class="input-group">
            <input type="text" 
                   name="name[]" 
                   class="form-control" 
                   placeholder="Enter class name"
                   style="border-radius: 8px 0 0 8px; border: 1px solid #e0e0e0; padding: 12px 16px; font-size: 14px;"
                   required>
            <button type="button" class="btn btn-outline-danger remove-input" style="border-radius: 0 8px 8px 0;">
                <i class="fa fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(inputGroup);

    // Add event listener to remove button
    inputGroup.querySelector('.remove-input').addEventListener('click', function() {
        inputGroup.remove();
    });
});

// Handle Edit Button Clicks
document.querySelectorAll('.editBtn').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');

        // Set form action dynamically
        document.getElementById('editClassForm').action = '/editClass/' + id;

        // Set current name
        document.getElementById('editName').value = name;

        // Open modal using Bootstrap 5 API
        const editModal = new bootstrap.Modal(document.getElementById('editClassModal'));
        editModal.show();
    });
});
</script>

@endsection