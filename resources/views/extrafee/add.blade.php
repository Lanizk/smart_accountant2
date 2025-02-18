@extends('layouts.app')

@section('main')
<div class="row">
    <!-- Form Section -->
    <div class="col-md-12 mt-5">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Add Extra Fee</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                <form action="{{ route('extrafeeinsert') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Fee Name:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="term">Term:</label>
                        <select id="term" name="term" class="form-control">
                            <option value="Term 1">Term 1</option>
                            <option value="Term 2">Term 2</option>
                            <option value="Term 3">Term 3</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="number" id="amount" name="amount" class="form-control" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label>
                             <input type="hidden" name="for_entire_school" value="0">
                            <input type="checkbox" id="entireSchoolCheckbox" name="for_entire_school" value="1">
                            Apply to Entire School
                        </label>
                    </div>

                    <div class="form-group" id="classSelection">
                        <label for="classmodels_id">Select Classes:</label>
                        <select id="classmodels_id" name="classmodels_id[]" class="form-control" multiple>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success">Add Fee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('entireSchoolCheckbox').addEventListener('change', function() {
        document.getElementById('classSelection').style.display = this.checked ? 'none' : 'block';
    });
</script>

@endsection
