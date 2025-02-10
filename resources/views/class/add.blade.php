@extends('layouts.app')
@section('main')
<div class="row column_title">
<div class="col-md-12">
   <div class="col-md-12">
   <div class="d-flex justify-content-end align-items-center py-3 px-4 white_shd border rounded mb-3 mt-3">
    
   <a href="{{ route('addclass') }}" class="btn btn-success px-4 py-2 fw-bold">+ Add New</a>
   </div>
</div>
</div>
</div>
<div class="row">
    <!-- Form Section -->
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Application Form</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                <form action="submit.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" id="phone" name="phone" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="position">Position Applying For:</label>
                        <select id="position" name="position" class="form-control">
                            <option value="app_support_officer">Application Support Officer</option>
                            <option value="software_engineer">Software Engineer</option>
                            <option value="it_support">IT Support</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="resume">Upload Resume:</label>
                        <input type="file" id="resume" name="resume" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Cover Letter:</label>
                        <textarea id="message" name="message" rows="4" class="form-control" required></textarea>
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