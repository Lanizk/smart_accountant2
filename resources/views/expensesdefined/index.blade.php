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

<div class="row column_title">
    <div class="col-md-12">
        <div class="page_title">
            <a href="{{ route('expenses.create') }}" class="btn btn-success px-4 py-2 fw-bold">+ Add Expense</a>
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="row w-100 mb-3">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Search Filters</h2>
                </div>
            </div>

            <div class="full inner_elements">
                <form method="GET" action="{{ route('expenses.index') }}" class="row px-4 py-3">
                    <div class="col-md-4 mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">-- All Categories --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-control">
                            <option value="">-- All --</option>
                            <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="mpesa" {{ request('payment_method') == 'mpesa' ? 'selected' : '' }}>M-Pesa</option>
                            <option value="bank" {{ request('payment_method') == 'bank' ? 'selected' : '' }}>Bank</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" value="{{ request('description') }}">
                    </div>

                    <div class="col-12 d-flex justify-content-start align-items-center mt-2">
                        <button type="submit" class="btn btn-primary me-2">Filter</button>
                        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- Expenses Table --}}
<div class="row w-100">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Expenses List</h2>
                </div>
            </div>

            <div class="table-responsive-lg">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $expense->category?->name ?? 'N/A' }}</td>
                            <td>{{ $expense->description }}</td>
                            <td>{{ number_format($expense->amount,2) }}</td>
                            <td>{{ ucfirst($expense->payment_method) }}</td>
                            <td>{{ $expense->expense_date?->format('d-M-Y') }}</td>
                            <td style="min-width: 150px;">
                                <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-primary btn-sm">Edit</a>

                                @if($expense->deleted_at)
                                    <form action="{{ route('expenses.restore', $expense->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-warning btn-sm">Restore</button>
                                    </form>
                                @else
                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No expenses found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $expenses->links() }}
            </div>

        </div>
    </div>
</div>

@endsection
