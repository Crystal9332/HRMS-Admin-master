@extends('layouts.common.index')

@section('page-title')
Reporter Mangement <i class="breadcrumb-symbol"></i> Orders
@endsection

@section('styles') 
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="row justify-content-end">
          <div class="col-md-4 col-sm-6 col-xs-12">
            <input class="form-control" id="daterange" type="text" name="daterange" value="" autocomplete="off" />
          </div>
        </div>
        <div class="table-responsive mt-3">
          <table id="attend-table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="3%">No</th>
                <th width="20%">City</th>
                <th width="20%">Site</th>
                <th>Start time</th>
                <th>End time</th>
                <th width="5%">Attend</th>
                <th width="5%">Late</th>
                <th width="5%">Timeout</th>
                <th width="5%">Actions</th>
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
  <script src="{{ asset('js/report-orders.js') }}"></script>
@endsection