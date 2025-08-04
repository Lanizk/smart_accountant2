@extends('layouts.app')
@section('main')


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="row">
    <!-- Form Section -->
    <div class="col-md-12 mt-5">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Edit ExtraFee Category Information</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                 <form action=""  method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="amount">Name:</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $extrafee->name) }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount (Kes):</label>
                        <input type="number" id="amount" name="amount" value="{{ old('amount', $extrafee->amount) }}" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="is_quantity_based">Is Quantity Based?:</label>
                        <select id="is_quantity_based" name="is_quantity_based" class="form-control @error('is_quantity_based') is-invalid @enderror" required>
                            <option value="">Select is_quantity_based</option>
                            <option value="0" {{ old('is_quantity_based', $extrafee->is_quantity_based) == '0' ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('is_quantity_based', $extrafee->is_quantity_based) == '1' ? 'selected' : '' }}>Yes</option>
                        </select>
                        @error('is_quantity_based')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group mb-3">
                        <label for="status">Status:</label>
                        <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="">Select Status</option>
                            <option value="active" {{ old('status', $extrafee->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $extrafee->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="form-group">
                        <label for="name">Description:</label>
                        <input type="text" id="desccription" name="description" value="{{ old('description', $extrafee->description) }}" class="form-control" required>
                    </div>


                    
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection