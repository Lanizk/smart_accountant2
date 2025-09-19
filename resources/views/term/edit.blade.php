@extends('layouts.app')
@section('main')

<div class="row">
    <!-- Form Section -->
    <div class="col-md-12 mt-5">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Edit Term</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                <form action="{{ route('editterm', $getRecord->id) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">Term Name:</label>
                        <input type="text" id="name" name="name" 
                            value="{{ old('name', $getRecord->name) }}" 
                            class="form-control" required>
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="term_year">Term Year:</label>
                        <input type="text" id="term_year" name="year" 
                            value="{{ old('year', $getRecord->year) }}" 
                            class="form-control" required>
                        @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" name="start_date" 
                            value="{{ old('start_date', $getRecord->start_date) }}" 
                            class="form-control" required>
                        @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" id="end_date" name="end_date" 
                            value="{{ old('end_date', $getRecord->end_date) }}" 
                            class="form-control">
                        @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Active Term:</label>
                        <div>
                            <label>
                                <input type="radio" name="active" value="1" 
                                    {{ old('active', $getRecord->active) == 1 ? 'checked' : '' }}> Yes
                            </label>
                            <label class="ml-3">
                                <input type="radio" name="active" value="0" 
                                    {{ old('active', $getRecord->active) == 0 ? 'checked' : '' }}> No
                            </label>
                        </div>
                        @error('active') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success">Update Term</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
