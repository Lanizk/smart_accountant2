@extends('layouts.app')
@section('main')

<div class="row">
    <!-- Form Section -->
    <div class="col-md-12 mt-5">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Application Form</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                <form action="{{ route('insertclass') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="form-group">
                        <label for="name">Class Name:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="term">Term:</label>
                        <input type="text" id="term" name="term" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="Amount">Amount:</label>
                        <input type="number" id="Amount" name="Amount" class="form-control" required>
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