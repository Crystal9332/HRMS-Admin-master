@extends('layouts.common.index')

@section('page-title')
Reporter Mangement <i class="breadcrumb-symbol"></i> User
@endsection

@section('styles') 
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <input type="hidden" id="user_id" value="{{$id}}" />
        <div class="row justify-content-end">
          <div class="col-md-2 col-sm-4 col-xs-12">
            <select class="form-control" id="select_type">
              <option value="qrs">QR Code</option>
              <option value="schedules">Schedule</option>
            </select>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <input class="form-control" id="daterange" type="text" name="daterange" value="" autocomplete="off" />
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            ID: <span class="font-weight-bold text-info">{{$user->userId}}</span>
          </div>
          <div class="col-md-2">
            Name: <span class="font-weight-bold text-info">{{$user->name}}</span>
          </div>
          <div class="col-md-2">
            Email: <span class="font-weight-bold text-info">{{$user->email}}</span>
          </div>
        </div>
        <div class="table-responsive mt-3">
          <table id="report-table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Name</th>
                <th>Start time</th>
                <th>End Time</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Status</th>
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
  <!-- start - This is for export functionality only -->
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
  <!-- end - This is for export functionality only -->
  <script>
    let title = 'User ID:'+'{{$user->userId}}'+'    User Name:'+'{{$user->name}}'+'    Email:'+'{{$user->email}}';
    let filename = 'user'+'-'+'{{$user->userId}}';
  </script>
  <script src="{{ asset('js/users-report.js') }}"></script>
@endsection