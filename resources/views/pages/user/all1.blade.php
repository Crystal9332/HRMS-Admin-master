@extends('layouts.common.index')

@section('page-title')
Education Mangement <i class="breadcrumb-symbol"></i> All
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-end align-items-center">
          <a
            class="col-md-1 col-sm-2 btn btn-rounded btn-info"
            href="{{route('users.create')}}"
          >
            New
          </a>
        </div>
        <div class="table-responsive">
          <table id="user-table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="3%">ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>City</th>
                <th>Site</th>
                <th>Job Title</th>
                <th>Expiry Date</th>
                <th>Approved</th>
                <th width="90">Actions</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="/js/users.js"></script>
@endsection