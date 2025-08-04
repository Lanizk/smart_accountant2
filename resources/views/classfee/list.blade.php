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
    
   <a href="{{ route('addclassfee') }}" class="btn btn-success px-4 py-2 fw-bold">+ Add New</a>
   </div>
</div>
</div>






<div class="row w-100">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Fee Amount List</h2>
            </div>
         </div>
     

            <div class="table-responsive-lg">
               <table class="table">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Grade</th>
                        <th>Amount</th>
                        <th>Term</th>
                        <th>Year</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($classFees as $value)
                     <tr>
                        <td>{{$value->id}}</td>
                        <td>{{$value->class->name}}</td>
                        <td>{{$value->amount}}</td>
                        <td>{{$value->term->name}}</td>
                        
                        <td>{{$value->year}}</td>
                        <td>{{$value->description}}</td>
                        <td>{{$value->status}}</td>
                        
                        <td style="min-width: 150px;">
                                      <a href="{{url('/editclassfee/' . $value->id)}}"
                                         class="btn btn-primary btn-sm">Edit</a>
                                      <a href="{{url('/deleteclassfee/' . $value->id)}}"
                                         class="btn btn-danger btn-sm">Delete</a>
                                   </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   
</div>
                        @endsection