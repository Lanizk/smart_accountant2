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
    <div class="page_title">
   <a href="{{ route('addStudents') }}" class="btn btn-success px-4 py-2 fw-bold">+ Add New</a> 
    </div>
</div>



<div class="row w-100">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Search Filters</h2>
            </div>
         </div>

         <div class="full inner_elements">
            <div class="row">
               <div class="col-md-12">
                  <form method="GET" action="{{ route('listStudents') }}" class="row px-4 py-3">
                     {{-- Class Filter --}}
                     <div class="col-md-3 mb-3">
                        <label for="class_id" class="form-label">Class</label>
                        <select name="class_id" id="class_id" class="form-control">
                           <option value="">-- All Classes --</option>
                           @foreach($classes as $class)
                              <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                 {{ $class->name }}
                              </option>
                           @endforeach
                        </select>
                     </div>

                     {{-- Term Filter --}}
                     <div class="col-md-3 mb-3">
                        <label for="term_id" class="form-label">Term</label>
                        <select name="term_id" id="term_id" class="form-control">
                           <option value="">-- All Terms --</option>
                           @foreach($terms as $term)
                              <option value="{{ $term->id }}" {{ request('term_id') == $term->id ? 'selected' : '' }}>
                                 {{ $term->name }}
                              </option>
                           @endforeach
                        </select>
                     </div>

                     {{-- Admission No Filter --}}
                     <div class="col-md-3 mb-3">
                        <label for="admission" class="form-label">Admission No</label>
                        <input type="text" name="admission" id="admission" class="form-control" value="{{ request('admission') }}">
                     </div>

                     {{-- Name Filter --}}
                     <div class="col-md-3 mb-3">
                        <label for="name" class="form-label">Student Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}">
                     </div>

                     {{-- Buttons --}}
                     <div class="col-12 d-flex justify-content-start align-items-center">
                        <button type="submit" class="btn btn-primary me-2">Search</button>
                        <a href="{{ route('listStudents') }}" class="btn btn-secondary">Reset</a>
                     </div>
                  </form>
               </div>
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
               <h2>Student List</h2>
            </div>
         </div>
     

            <div class="table-responsive-lg">
               <table class="table">
                  <thead>
                     <tr>
                        
                        <th>Full Name</th>
                        <th>Phone No</th>
                        <th>Admission No</th>
                        <th>Gender</th>
                        <th>Class</th>
                        <th>Term</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($getRecord as $value)
                     <tr>
                        
                        <td>{{$value->name}}</td>
                        <td>{{$value->phone}}</td>
                        <td>{{$value->admission}}</td>
                        <td>{{$value->gender}}</td>
                        <td>{{$value->class->name}}</td>
                        <td>{{$value->term->name}}</td>
                        <td style="min-width: 150px;">
                                      <a href="{{url('/editstudent/' . $value->id)}}"
                                         class="btn btn-primary btn-sm">Edit</a>
                                      <a href="{{url('/deletestudent/' . $value->id)}}"
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