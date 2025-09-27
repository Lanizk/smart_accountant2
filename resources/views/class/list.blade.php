@extends('layouts.app')

@section('main')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="row w-500 mt-4">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head d-flex justify-content-between ">
                <div class="heading1 margin_0">
        <h2 >Grade List</h2>  
    </div> 
    <button type="button" class="btn btn-success fw-bold px-4 py-2" data-toggle="modal" data-target="#addClassModal">
                    + Add New
                </button>
</div>
            
           

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Class</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($getRecord as $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->name }}</td>
                            <td class="text-center">
                                <!-- Edit Modal Trigger -->
                                <button 
                                    class="btn btn-primary btn-sm me-1 editBtn"
                                    data-id="{{ $value->id }}"
                                    data-name="{{ $value->name }}">
                                    Edit
                                </button>
                                <a href="{{ url('/deleteClass/' . $value->id) }}" class="btn btn-danger btn-sm">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- ✅ Reusable Edit Modal -->
<div class="modal fade" id="editClassModal" tabindex="-1" aria-labelledby="editClassModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editClassForm" method="POST">
        @csrf
        
        <div class="modal-header">
          <h5 class="modal-title" id="editClassModalLabel">Edit Class</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group mb-3">
                <label for="editName">Class Name:</label>
                <input type="text" id="editName" name="name" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ✅ Add Class Modal (with multiple inputs) -->
<div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addClassForm" action="{{ route('insertclass') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addClassModalLabel">Add New Class</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div id="classInputs">
                <div class="form-group mb-3">
                    <label>Class Name:</label>
                    <input type="text" name="name[]" class="form-control" placeholder="Class Name" required>
                </div>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" id="addMoreInput">+ Add Another Class</button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save Classes</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- ✅ JavaScript -->
<script>
document.getElementById('addMoreInput').addEventListener('click', function() {
    const container = document.getElementById('classInputs');
    const input = document.createElement('div');
    input.classList.add('form-group', 'mb-3');
    input.innerHTML = `<input type="text" name="name[]" class="form-control" placeholder="Class Name" required>`;
    container.appendChild(input);
});

// ✅ Handle Edit Button Clicks
document.querySelectorAll('.editBtn').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');

        // set form action dynamically
        document.getElementById('editClassForm').action = '/editClass/' + id;

        // set current name
        document.getElementById('editName').value = name;

        // open modal using Bootstrap 5 API
        const editModal = new bootstrap.Modal(document.getElementById('editClassModal'));
        editModal.show();
    });
});
</script>

@endsection
