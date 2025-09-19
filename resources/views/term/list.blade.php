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
                <a href="{{ route('addterm') }}" class="btn btn-success px-4 py-2 fw-bold">+ Add New</a>
            </div>
        </div>
    </div>
</div>

<div class="row w-100">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Term List</h2>
                </div>
            </div>
            
            <div class="table-responsive-lg">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Term</th>
                            <th>Year</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th style="min-width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($getRecord as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->year }}</td>
                                <td>{{ \Carbon\Carbon::parse($value->start_date)->format('d M, Y') }}</td>
                                <td>
                                    @if($value->end_date)
                                        {{ \Carbon\Carbon::parse($value->end_date)->format('d M, Y') }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($value->active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('/editterm/' . $value->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="{{ url('/deleteterm/' . $value->id) }}" 
                                       onclick="return confirm('Are you sure you want to delete this term?')" 
                                       class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No terms available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
