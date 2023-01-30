@extends('layouts.common.index')

@section('styles')
<style>
  div.card-body {
    min-height: 850px;
  }
  
  .time-container {
    border: 1px solid grey;
  }
  
  .time-container > .form-group {
    position: absolute;
    top: -10%;
    background: white;
    padding: 0 10px;
  }

  .size-30 {
    width: 30px;
    height: 30px;
  }

</style>
@endsection

@section('page-title')
Schedule Mangement
@endsection

@section('content')
<div class="card">
  <div class="card-body p-md-5">
    <div class="col-md-12 row">
      <div class="col-md-3 offset-md-6">
        <select class="form-control" id="select-city">
          @foreach($cities as $key => $city)
            <option
              value="{{ $city->id }}"
            >{{ $city->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <button class="btn btn-rounded btn-outline-info float-right" id="btn-add-schedule" data-toggle="modal" data-target="#schedule-modal">Add</button>
      </div>
    </div>
    <div class="table-responsive">
      <table id="schedule-table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th width="5%">#</th>
            <th>Site Name</th>
            <th>Start time</th>
            <th>End time</th>
            <th>Reference Email</th>
            <th>Updated time</th>
            <th>Approved status</th>
            <th width="5%">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Add Edit Timer --}}
<div id="schedule-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Schedulde</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-schedule" action="javascript:;">
        <div class="modal-body p-t-20">
          <input type="hidden" id="edit_schedule_id" value="0">
          <div class="form-group row">
            <label class="col-sm-2 text-right control-label col-form-label">City :</label>
            <div class="col-sm-9">
              <input type="text" class="form-control bg-white" id="selected_city_name" val="" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 text-right control-label col-form-label">Site :</label>
            <div class="col-sm-9">
              <select
                class="form-control"
                id="select_site"
                required
              >
                <option value="">Choose Site</option>
              </select>
            </div>
          </div>
          <div class="col-12 rounded pt-3 mb-3 time-container" c-name="start">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="start_time">Start Time</label>
                  <div class="controls">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"
                          ><i class="ti-calendar"></i
                        ></span>
                      </div>
                      <input
                        type="time"
                        class="form-control"
                        id="start_time"
                        placeholder="dd/mm/yyyy"
                        required
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="end_time">End Time</label>
                  <div class="controls">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"
                          ><i class="ti-timer"></i
                        ></span>
                      </div>
                      <input
                        type="time"
                        class="form-control"
                        id="end_time"
                        placeholder="HH:MM"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light btn-schedule">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script src="/js/schedule-manage.js"></script>
@endsection