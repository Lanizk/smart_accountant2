@extends('layouts.app')
@section('main')

<div class="row column_title">
    <div class="col-md-12">
        <div class="page_title">
            <h2>Add Expense</h2>
        </div>
    </div>
</div>

<div class="row w-100">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full inner_elements">
                <form action="{{ isset($expense) ? route('expenses.update', $expense->id) : route('expenses.store') }}" method="POST">
                    @csrf
                    @if(isset($expense))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="expense_category_id" class="form-label">Category</label>
                        <select name="expense_category_id" id="expense_category_id" class="form-control">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ (isset($expense) && $expense->expense_category_id == $cat->id) ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('expense_category_id')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" name="description" id="description" class="form-control"
                               value="{{ $expense->description ?? old('description') }}">
                        @error('description')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control"
                               value="{{ $expense->amount ?? old('amount') }}" step="0.01">
                        @error('amount')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-control">
                            <option value="">-- Select Method --</option>
                            <option value="cash" {{ (isset($expense) && $expense->payment_method=='cash') ? 'selected' : '' }}>Cash</option>
                            <option value="mpesa" {{ (isset($expense) && $expense->payment_method=='mpesa') ? 'selected' : '' }}>M-Pesa</option>
                            <option value="bank" {{ (isset($expense) && $expense->payment_method=='bank') ? 'selected' : '' }}>Bank</option>
                        </select>
                        @error('payment_method')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="expense_date" class="form-label">Expense Date</label>
                        <input type="date" name="expense_date" id="expense_date" class="form-control"
                               value="{{ optional($expense)->expense_date?->format('Y-m-d') ?? old('expense_date') }}">
                        @error('expense_date')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">{{ isset($expense) ? 'Update' : 'Save' }}</button>
                        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
