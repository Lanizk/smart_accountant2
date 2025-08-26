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

<div class="row column_title mb-3">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center page_title">
            <h2 >Student ExtraFee Assignment List</h2>
            <a href="{{ route('assignextrafee') }}" class="btn btn-success px-4 py-2 fw-bold">
                + Assign Extra Fee
            </a>
        </div>
    </div>
</div>


<form method="GET" action="{{ route('listextrafeestudents') }}">
    <div class="row mb-4">
        <!-- Extra Fee Filter -->
        <div class="col-md-4">
            <label for="extra_fee_id" class="form-label">Extra Fee</label>
            <select name="extra_fee_id" id="extra_fee_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Filter by Extra Fee --</option>
                @foreach($extraFees as $extraFee)
                    <option value="{{ $extraFee->id }}" 
                        {{ request('extra_fee_id') == $extraFee->id ? 'selected' : '' }}>
                        {{ $extraFee->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Student Name Filter -->
        <div class="col-md-4">
            <label for="student_name" class="form-label">Search Student</label>
            <input type="text" name="student_name" id="student_name" 
                   value="{{ request('student_name') }}" 
                   class="form-control" placeholder="Name or Admission No.">
        </div>

        <!-- Buttons -->
        <div class="col-md-4 d-flex align-items-end" style="gap: 1rem;">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
            <a href="{{ route('listextrafeestudents') }}" class="btn btn-secondary w-100">Reset</a>
        </div>
    </div>
</form>


<div class="row w-100">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Students Assigned</h2>
            </div>
         </div>
         <div class="table_section padding_infor_info">
            <div class="table-responsive-lg">
               <table class="table">
                  <thead>
                     <tr>
                        <th>Extra Fee</th>
                        <th>Student Name</th>
                        <th>Term</th>
                        <th>Year</th>
                        <th>Amount</th>
                        <th>Quantity </th>
                        <th>Created By</th>
                        <th>Action</th>
                     </tr>
                  </thead>

                  <tbody>
                     @foreach($extraFeeStudents as $extraFeeStudent)
                     <tr>
                        <td> {{$extraFeeStudent->extraFee->name}}</td>
                        <td> {{$extraFeeStudent->student->name}}</td>
                        
                        <td> {{$extraFeeStudent->extraFee->term->name}}</td>
                        <td> {{$extraFeeStudent->extraFee->year}}</td>
                        <td>Kes {{$extraFeeStudent->amount,2}}</td>
                        <td> {{$extraFeeStudent->quantity}}</td>
                        <td> {{$extraFeeStudent->creator->admin_name}}</td>

                           <td style="min-width: 150px;">
                                      <a href="{{url('/assign-extra-fee/edit/' . $extraFeeStudent->id)}}"
                                         class="btn btn-primary btn-sm">Edit</a>
                                      <a href="{{url('/assign-extra-fee/delete/' . $extraFeeStudent->id)}}"
                                         class="btn btn-danger btn-sm">Delete</a>
                                   </td>
                     </tr>
                     @endforeach
                  </tbody>
                 
            </div>
         </div>
      </div>
   </div>
</div>
@endsection