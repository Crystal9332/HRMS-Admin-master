@extends('layouts.common.index')

@section('styles')
<style>
  div.card-body {
    min-height: 850px;
  }
</style>
@endsection

@section('page-title')
Site Mangement
@endsection

@section('content')
<div class="card">
  <div class="card-body p-md-5">
    <div class="col-md-12 row">
      <div class="col-md-5 offset-md-5 row">
        <div class="col-md-4 text-right pt-2">
          <h5 class="card-title">City : </h5>
        </div>
        <div class="col-md-8">
          <select class="form-control" id="select-city">
            <option value="">-Choose city-</option>
          </select>
        </div>
      </div>      
      <div class="col-md-2">
        <button class="btn btn-rounded btn-outline-info float-right" id="btn-add-site" data-toggle="modal" data-target="#site-modal">Add</button>
      </div>
    </div>
    <div class="table-responsive">
      <table id="site-table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th width="5%">#</th>
            <th>Name</th>
            <th>Office phone</th>
            <th>First manager</th>
            <th>First phone</th>
            <th>Second manager</th>
            <th>Second phone</th>
            <th>Reference email</th>
            <th>Address</th>
            <th width="8%">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Add Site Modal --}}
<div id="site-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Site</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-site" action="javascript:;">
        <div class="modal-body p-t-20">
          <input type="hidden" id="edit-site-id" value="0">
          <div class="form-group row">
            <label class="col-sm-4 text-right control-label col-form-label">City :</label>
            <div class="col-sm-8">
              <input type="text" class="form-control bg-white" id="selected_city_name" val="" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="site_name" class="col-sm-4 text-right control-label col-form-label">Site :</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="site_name" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="office_phone" class="col-sm-4 text-right control-label col-form-label">Office phone:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="office_phone" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="first_mng_name" class="col-sm-4 text-right control-label col-form-label">First Manager Name:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="first_mng_name" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="first_phone" class="col-sm-4 text-right control-label col-form-label">First phone:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="first_phone" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="second_mng_name" class="col-sm-4 text-right control-label col-form-label">Second Manager Name:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="second_mng_name" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="second_phone" class="col-sm-4 text-right control-label col-form-label">Second phone:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="second_phone" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="location" class="col-sm-4 text-right control-label col-form-label">Location:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="location" required autocomplete="off">
            </div>
          </div>
          <div class="form-group row">
            <label for="ref_email" class="col-sm-4 text-right control-label col-form-label">Reference Email :</label>
            <div class="col-sm-8">
              <input type="email" class="form-control" id="ref_email">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light btn-site">Add</button>
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
<script src="/js/site-manage.js"></script>
@endsection