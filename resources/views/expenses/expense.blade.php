@extends('layouts.app')

@section('main')
<div class="row column_title mb-3">
  <div class="col-md-12">
    <div class="d-flex justify-content-between align-items-center page_title">
      <h2 class="m-0">Expense Categories</h2>
      <button class="btn btn-outline-primary fw-bold" data-toggle="modal" data-target="#addCategoryModal">
        + Add Category
      </button>
    </div>
  </div>
</div>

<div class="row w-100">
  <div class="col-md-12">
    <div class="white_shd full margin_bottom_30">
      <div class="full graph_head">
        <div class="heading1 margin_0"><h2>All Categories</h2></div>
      </div>

      <div class="table_section padding_infor_info">
        <div class="table-responsive-lg">
          <table class="table align-middle table-hover">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th style="min-width:150px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Salaries</td>
                <td>Teacher and staff wages</td>
                <td>
                  <button class="btn btn-sm btn-outline-secondary">Edit</button>
                  <button class="btn btn-sm btn-outline-danger">Delete</button>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td>Stationery</td>
                <td>Books, pens, supplies</td>
                <td>
                  <button class="btn btn-sm btn-outline-secondary">Edit</button>
                  <button class="btn btn-sm btn-outline-danger">Delete</button>
                </td>
              </tr>
              <!-- More rows later from DB -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Add Category Modal --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form>
        <div class="modal-header">
          <h5 class="modal-title" id="addCategoryModalLabel">Add Expense Category</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" class="form-control" placeholder="e.g. Transport" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" rows="3" placeholder="Optional"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Category</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
