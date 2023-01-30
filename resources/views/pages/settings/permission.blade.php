@extends('layouts.common.index')

@section('styles')
<style>
  div.card-body {
    min-height: 850px;
  }
  
  .time-container {
    border: 1px solid grey;
  }
  
  .time-container div:first-child {
    position: absolute;
    top: -10%;
    background: white;
    padding: 0 10px;
  }

</style>
@endsection

@section('page-title')
Permission Mangement
@endsection

@section('content')
<div class="card">
  <div class="card-body p-md-5">
    <div class="col-md-12 row">
      <div class="col-md-4 row">
        <div class="col-md-3 text-right pt-2">
          <h5>
            City :
          </h5>
        </div>
        <div class="col-md-9">
          <select class="form-control" id="select_city">
          </select>
        </div>
      </div>
      <div class="col-md-8 row">
        <div class="col-md-7 row">
          <div class="col-md-5">
            <h5 class="text-right pt-2"> City Manager : </h5>
          </div>
          <div class="col-md-7 input-group mb-3">
            <input type="hidden" id="city_manager_id" value=""/>
            <input
              type="text"
              class="form-control bg-white"
              id="city_manager_name"
              value=""
              placeholder="Not Selected"
              readonly
            />
            <div class="input-group-append">
              <a href="javascript:;">
                <span class="input-group-text h-100" id="edit_city_manager" title="Change City Manager"
                  ><i class="ti-pencil text-info"></i
                ></span>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-5 text-right pt-2">
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table id="permission_table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th width="5%">#</th>
            <th>Site Name</th>
            <th>Manager Name</th>
            <th>Manager Email</th>
            <th width="8%">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Add Edit Timer --}}
<div id="modal_site_manager" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Site Manager</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-permission" action="javascript:;">
        <div class="modal-body p-t-20">
          <input type="hidden" id="edit_permission_id" value="0">
          <div class="form-group row">
            <label class="col-sm-2 text-right control-label col-form-label">City :</label>
            <div class="col-sm-9">
              <input type="text" class="form-control bg-white selected-city-name" val="" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 text-right control-label col-form-label">Site :</label>
            <div class="col-sm-9">
              <input type="text" class="form-control bg-white" id="site_name" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 text-right control-label col-form-label" for="site_manager">User :</label>
            <div class="col-sm-9">
              <select class="form-control" id="select_site_manager" required></select>
            </div>
          </div>
          <div class="site-manager-info"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light btn-permission">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Add Edit Timer --}}
<div id="modal_city_manager" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Site Manager</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-city-manager" action="javascript:;">
        <div class="modal-body p-t-20">
          <div class="form-group row">
            <label class="col-sm-2 text-right control-label col-form-label">City :</label>
            <div class="col-sm-9">
              <input type="text" class="form-control bg-white selected-city-name" val="" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 text-right control-label col-form-label" for="city_manager">User :</label>
            <div class="col-sm-9">
              <select class="form-control" id="select_city_manager" required></select>
            </div>
          </div>
          <div class="city-manager-info"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light btn-city-manager">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script src="/js/permission-manage.js"></script>
@endsection