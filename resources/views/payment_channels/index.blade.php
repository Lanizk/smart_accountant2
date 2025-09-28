@extends('layouts.app')

@section('main')

<div class="row w-100 mt-4">
    <div class="col-md-12">
        <div class="white_shd full p-3 shadow-sm rounded">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Payment Channels</h2>
                <!-- Add Modal Trigger -->
                <button type="button" class="btn btn-success fw-bold px-4 py-2" data-toggle="modal" data-target="#addChannelModal">
                    + Add Channel
                </button>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Identifier</th>
                            <th>Account Pattern</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($channels as $channel)
                        <tr>
                            <td>{{ $channel->id }}</td>
                            <td>{{ ucfirst($channel->type) }}</td>
                            <td>{{ $channel->identifier }}</td>
                            <td>{{ $channel->account_pattern ?? '—' }}</td>
                            <td>
                                @if($channel->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <!-- Edit Modal Trigger -->
                                <button 
                                    class="btn btn-primary btn-sm editBtn"
                                    data-id="{{ $channel->id }}"
                                    data-type="{{ $channel->type }}"
                                    data-identifier="{{ $channel->identifier }}"
                                    data-pattern="{{ $channel->account_pattern }}"
                                    data-status="{{ $channel->is_active }}">
                                    Edit
                                </button>

                                @if($channel->is_active)
                                    <a href="{{ route('payment_channels.deactivate', $channel->id) }}" 
                                       class="btn btn-warning btn-sm">
                                        Deactivate
                                    </a>
                                @else
                                    <a href="{{ route('payment_channels.activate', $channel->id) }}" 
                                       class="btn btn-success btn-sm">
                                        Activate
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No payment channels defined yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- ✅ Add Modal -->
<div class="modal fade" id="addChannelModal" tabindex="-1" aria-labelledby="addChannelModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('payment_channels.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addChannelModalLabel">Add Payment Channel</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="form-group mb-3">
                <label>Type</label>
                <select name="type" class="form-control" required>
                    <option value="">-- Select Type --</option>
                    <option value="paybill">Paybill</option>
                    <option value="till">Till</option>
                    <option value="send_money">Send Money</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label>Identifier</label>
                <input type="text" name="identifier" class="form-control" required placeholder="Shortcode or Phone Number">
            </div>
<div class="form-group mb-3">
    <label>Account Pattern</label>
    <select name="account_pattern" class="form-control">
        <option value="">-- Select Pattern --</option>
        <option value="{name}-{class}-{admission_no}">Name-Class-Admission</option>
        <option value="{class}-{admission_no}">Class-Admission</option>
        <option value="{admission_no}">Admission Only</option>
    </select>
    <small class="text-muted">
        This determines how parents must enter the account/reference field during payment.
    </small>
</div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ✅ Edit Modal -->
<div class="modal fade" id="editChannelModal" tabindex="-1" aria-labelledby="editChannelModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editChannelForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editChannelModalLabel">Edit Payment Channel</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="form-group mb-3">
                <label>Type</label>
                <select name="type" id="editType" class="form-control" required>
                    <option value="paybill">Paybill</option>
                    <option value="till">Till</option>
                    <option value="send_money">Send Money</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label>Identifier</label>
                <input type="text" id="editIdentifier" name="identifier" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Account Pattern (Optional)</label>
                <input type="text" id="editPattern" name="account_pattern" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Status</label>
                <select name="is_active" id="editStatus" class="form-control" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ✅ Script to populate Edit Modal -->
<script>
document.querySelectorAll('.editBtn').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.dataset.id;
        const type = this.dataset.type;
        const identifier = this.dataset.identifier;
        const pattern = this.dataset.pattern;
        const status = this.dataset.status;

        // Fill form
        document.getElementById('editType').value = type;
        document.getElementById('editIdentifier').value = identifier;
        document.getElementById('editPattern').value = pattern || '';
        document.getElementById('editStatus').value = status;

        // Set form action
        document.getElementById('editChannelForm').action = '/payment_channels/' + id;

        // Show modal
        new bootstrap.Modal(document.getElementById('editChannelModal')).show();
    });
});
</script>

@endsection

