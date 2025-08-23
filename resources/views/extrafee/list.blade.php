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
    <div class="page_title d-flex justify-content-end align-items-center py-3 px-4 rounded mb-3 ">
    <a href="{{ route('addextrafee') }}" class="btn btn-success px-4 py-2 fw-bold">+ Add New</a> 
   </div>
</div>
</div>
<div class="row w-100">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Extra Fee List</h2>
            </div>
         </div>
         <div class="table_section padding_infor_info">
            <div class="table-responsive-lg">
               <table class="table">
                  <thead>
                     <tr>
                       
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Quantity Based?</th>
                        <th>Description</th>
                        <td>Term</td>
                        <td>Year</td>
                        <th>Created By</th>
                        <th>Action</th>
                     </tr>
                  </thead>

                  <tbody>
                     @foreach($extraFees as $extraFee)
                     <tr>
                        <td> {{$extraFee->name}}</td>
                        <td>Kes {{$extraFee->amount,2}}</td>
                        <td> {{$extraFee->is_quantity_based ? 'yes':'No'}}</td>
                        <td> {{$extraFee->description}}</td>
                        <td>{{$extraFee->term->name}}</td>
                        <td>{{$extraFee->year}}</td>
                        <td> {{$extraFee->creator->admin_name}}</td>

                           <td style="min-width: 150px;">
                                      <a href="{{url('/editextrafee/' . $extraFee->id)}}"
                                         class="btn btn-primary btn-sm">Edit</a>
                                      <a href="{{url('/deleteextrafee/' . $extraFee->id)}}"
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