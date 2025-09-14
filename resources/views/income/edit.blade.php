@extends('layouts.app')

@section('main')
<div class="row column_title mb-3">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center page_title">
            <h2>Edit Other Income</h2>
            <a href="{{ route('other_incomes.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>

@if($errors->any())
  <div class="alert alert-danger">
      <ul class="mb-0">
          @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif

<div class="row w-100">
    <div class="col-md-8 offset-md-2">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head"><h2 class="heading1">Update Income Details</h2></div>
            <div class="full inner_elements">
                <form action="{{ route('other_incomes.update', $other_income->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label>Income Category</label>
                        <select name="income_category_id" class="form-control" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $other_income->income_category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" step="0.01" required value="{{ $other_income->amount }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>Payment Method</label>
                        <select name="payment_method" class="form-control">
                            <option value="">-- Select Payment Method --</option>
                            <option value="cash" {{ $other_income->payment_method=='cash' ? 'selected' : '' }}>Cash</option>
                            <option value="mpesa" {{ $other_income->payment_method=='mpesa' ? 'selected' : '' }}>M-Pesa</option>
                            <option value="bank" {{ $other_income->payment_method=='bank' ? 'selected' : '' }}>Bank</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Date</label>
                        <input type="date" name="income_date" class="form-control" value="{{ $other_income->income_date }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ $other_income->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Income</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
