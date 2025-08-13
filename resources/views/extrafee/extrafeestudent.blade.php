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

<div class="row column_title">
 
<div class="col-md-12">
   <div class="col-md-12">
       
   <div class="d-flex justify-content-end align-items-center py-3 px-4 white_shd border rounded mb-3 mt-3">
    
   <!-- <a href="{{ route('addextrafee') }}" class="btn btn-success px-4 py-2 fw-bold">+ Add New</a> -->
    <div class="dropdown">
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Dropright button</button>
            <div class="dropdown-menu">
               
               <a class="dropdown-item" href="{{ route('assignextrafee') }}">Assign Extra Fee</a>
               
            </div>
       </div>
   </div>
</div>
</div>
<div class="row w-100">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Responsive Tables</h2>
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