@extends('layouts.common.index')

@section('page-title')
Qr-Code <i class="breadcrumb-symbol"></i> All
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-end align-items-center">
          <a
            class="col-md-1 col-sm-2 btn btn-rounded btn-info"
            href="{{route('qrs.create')}}"
          >
            New
          </a>
        </div>
        <div class="table-responsive mt-3">
          <table id="qr-table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="3%">ID</th>
                <th>City</th>
                <th>Site</th>
                <th>Email</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Sent Time</th>
                <th width="10%">Actions</th>
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
<script src="{{ asset('js/qr-all.js') }}"></script>
@endsection