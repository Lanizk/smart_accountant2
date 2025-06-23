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
                    <h2>Student Information</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                 <form action=""  method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $student->phone) }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="admission">Admission Number:</label>
                        <input type="text" id="admission" name="admission" value="{{ old('admission', $student->admission) }}" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="gender">Gender:</label>
                        <select id="gender" name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="class_id">Class:</label>
                        <select id="class_id" name="class_id" class="form-control @error('class_id') is-invalid @enderror" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group mb-3">
    <label for="term_id">Term:</label>
    <select id="term_id" name="term_id" class="form-control @error('term_id') is-invalid @enderror" required>
        <option value="">Select Term</option>
        @foreach($terms as $term)
            <option value="{{ $term->id }}" {{ old('term_id', $student->term_id) == $term->id ? 'selected' : '' }}>
                {{ $term->name }}
            </option>
        @endforeach
    </select>
    @error('term_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
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