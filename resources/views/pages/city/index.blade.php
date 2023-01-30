@extends('layouts.common.index')

@section('styles')
<style>
  div.card-body {
    min-height: 850px;
  }
</style>
@endsection

@section('page-title')
City Mangement
@endsection

@section('content')
<div class="card">
  <div class="card-body p-md-5">
    <div class="col-md-12 pull-right">
      <button class="btn btn-rounded btn-outline-info float-right" id="btn-add" data-toggle="modal" data-target="#city-modal">Add</button>
    </div>
    <div class="table-responsive">
      <table id="city-table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th width="5%">#</th>
            <th>City Name</th>
            <th>Country</th>
            <th>Office phone</th>
            <th>Manager Name</th>
            <th>Manager phone</th>
            <th>Second Manager Name</th>
            <th>Second Manager phone</th>
            <th>Location</th>
            <th width="10%">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Add Grade Modal --}}
<div id="city-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add City</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-city" action="javascript:;">
        <div class="modal-body p-t-40">
          <input type="hidden" id="edit-id" value="0">
          <div class="form-group row">
            <label for="city_name" class="col-sm-4 text-right control-label col-form-label">City:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="city_name" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="country" class="col-sm-4 text-right control-label col-form-label">Country:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="country" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="office_phone" class="col-sm-4 text-right control-label col-form-label">Office phone:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="office_phone" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="manager_name" class="col-sm-4 text-right control-label col-form-label">Manager Name:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="manager_name" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="manager_phone" class="col-sm-4 text-right control-label col-form-label">Manager phone:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="manager_phone" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="second_mng_name" class="col-sm-4 text-right control-label col-form-label">Second Manager Name:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="second_mng_name" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="second_mng_phone" class="col-sm-4 text-right control-label col-form-label">Second Manager phone:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="second_mng_phone" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="location" class="col-sm-4 text-right control-label col-form-label">Location:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="location" required autocomplete="off">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light btn-city">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  var route = "{{ url('searchLocations') }}";
</script>
<script src="/js/city-manage.js"></script>
@endsection