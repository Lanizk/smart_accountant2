@extends('layouts.app')
@section('main')
<div class="row column_title">
<div class="col-md-12">
   <div class="col-md-12">
   <div class="d-flex justify-content-end align-items-center py-3 px-4 white_shd border rounded mb-3 mt-3">
    
   <a href="{{ route('extrafeeadd') }}" class="btn btn-success px-4 py-2 fw-bold">+ Add New</a>
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
                        <th>#</th>
                        <th>Class</th>
                        <th>Term</th>
                        <th>Amount</th>
                     </tr>
                  </thead>
                 
            </div>
         </div>
      </div>
   </div>
</div>
                        @endsection