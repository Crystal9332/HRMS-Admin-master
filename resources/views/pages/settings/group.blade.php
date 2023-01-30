@extends('layouts.common.index')

@section('page-title')
Settings <i class="breadcrumb-symbol"></i> Group
@endsection

@section('content')
  <div class="col-12 row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body p-md-5">
          <div class="col-md-12 row">
            <div class="col-md-8">
              <h3 class="card-title">Group</h3>
            </div>
            <div class="col-md-4">
              <button class="btn btn-rounded btn-outline-info float-right" data-toggle="modal" data-target="#group-modal">Add</button>
            </div>
          </div>
          <div class="table-responsive">
            <table id="group-table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5%">#</th>
                  <th>Name</th>
                  <th width="15%">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body p-md-5">
          <div class="col-md-12 row">
            <div class="col-md-8">
              <h3 class="card-title">Location</h3>
            </div>
            <div class="col-md-4">
              <button class="btn btn-rounded btn-outline-info float-right" data-toggle="modal" data-target="#location-modal">Add</button>
            </div>
          </div>
          <div class="table-responsive">
            <table id="location-table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5%">#</th>
                  <th>Address</th>
                  <th>Latitude</th>
                  <th>Longitude</th>
                  <th>Distance</th>
                  <th>Action</th>
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

{{-- Add Grade Modal --}}
<div id="group-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Group</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-group" action="javascript:;">
        <div class="modal-body p-t-40">
          <input type="hidden" id="edit-id" value="0">
          <div class="form-group row">
            <label for="group-text" class="col-sm-2 text-right control-label col-form-label">Group:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="group-text" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light btn-group">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Add Grade Modal --}}
<div id="location-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Location</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-location" action="javascript:;">
        <div class="modal-body p-t-40">
          <input type="hidden" id="location-edit-id" value="0">
          <div class="form-location row">
            <label for="location-text" class="col-sm-2 text-right control-label col-form-label">Address:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="location-address" required>
            </div>
          </div>
          <div class="form-location row mt-3">
            <label for="location-latitude" class="col-sm-2 text-right control-label col-form-label">Latitude:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="location-latitude" required>
            </div>
          </div>
          <div class="form-location row mt-3">
            <label for="location-longitude" class="col-sm-2 text-right control-label col-form-label">Longitude:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="location-longitude" required>
            </div>
          </div>
          <div class="form-location row mt-3">
            <label for="location-longitude" class="col-sm-2 text-right control-label col-form-label">Distance:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="location-distance" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light btn-location">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script src="/js/job-manage.js"></script>
<script src="/js/location-manage.js"></script>
@endsection