@extends('layouts.app')

@section('main')
<div class="row column_title mb-3">
  <div class="col-md-12">
    <div class="d-flex justify-content-between align-items-center page_title">
      <h2>Other Incomes</h2>
      <a href="{{ route('other_incomes.create') }}" class="btn btn-success">
        + Add New
      </a>
    </div>
  </div>
</div>

{{-- Flash Messages --}}
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row w-100">
  <div class="col-md-12">
    <div class="white_shd full margin_bottom_30">
      <div class="full graph_head">
        <h2 class="heading1">All Incomes</h2>
      </div>
      <div class="table_section padding_infor_info">
        <div class="table-responsive-lg">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Date</th>
                <th>Description</th>
                <th style="min-width:150px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($incomes as $income)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $income->category->name ?? '-' }}</td>
                  <td>{{ number_format($income->amount, 2) }}</td>
                  <td>{{ ucfirst($income->payment_method) ?? '-' }}</td>
                  <td>{{ $income->income_date ? \Carbon\Carbon::parse($income->income_date)->format('d M Y') : '-' }}</td>
                  <td>{{ $income->description }}</td>
                  <td>
                    <a href="{{ route('other_incomes.edit', $income->id) }}" class="btn btn-sm btn-outline-secondary">
                      Edit
                    </a>
                    <form action="{{ route('other_incomes.destroy', $income->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this income?')">
                        Delete
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center">No incomes recorded yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
