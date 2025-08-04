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
                    <h2>Fee Amount Information</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                 <form action="{{ route('insertclassfee') }}"  method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="class_id">Grade:</label>
                        <select id="class_id" name="class_id" class="form-control @error('class_id') is-invalid @enderror" required>
                            <option value="">Select Grade</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="" id="amount" name="amount" value="{{ old('amount') }}" class="form-control" required>
                    </div>

                    
                    <div class="form-group mb-3">
                        <label for="gender">Status:</label>
                        <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="">Select Status</option>
                            <option value="active" {{ old('gender') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('gender') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
              

                    <div class="form-group mb-3">
                        <label for="term_id">Term:</label>
                        <select id="term_id" name="term_id" class="form-control @error('term_id') is-invalid @enderror" required>
                            <option value="">Select Term</option>
                            @foreach($terms as $term)
                                <option value="{{ $term->id }}" {{ old('term_id') == $term->id ? 'selected' : '' }}>
                                    {{ $term->name }}-{{ $term->year }}
                                </option>
                            @endforeach
                        </select>
                        @error('term_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="name">Description:</label>
                        <input type="text" id="desccription" name="description" value="{{ old('description') }}" class="form-control" required>
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