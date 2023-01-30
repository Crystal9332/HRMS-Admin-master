@extends('layouts.common.index')

@section('page-title')
QrCode <i class="breadcrumb-symbol"></i> New
@endsection

@section('styles')
<style>
  .time-container {
    border: 1px solid grey;
  }
  
  .time-container > .form-group {
    position: absolute;
    top: -10%;
    background: white;
    padding: 0 10px;
  }

  .hidden {
    display: none;
  }
  
  .show {
    display: block;
  }
</style>    
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <form class="form-qr" action="javascript:;" novalidate>
          @csrf
          <div class="form-body">
            <div class="row">
              <div class="col-md-8">
                <h3 class="card-title">Information</h3>
              </div>
            </div>
            <hr />
            @if (session('success'))
              <div class="form-group text-primary font-weight-bold">
                {{session('success')}}
              </div>
            @endif
            <!--/row-->
            <div class="col-md-10 offset-md-1 row">
              <div class="col-md-6">
                <div class="message my-5"></div>
                <input type="hidden" id="site" value="{{ $site_id }}" />
                <div class="col-12 rounded pt-3 mb-3 time-container" c-name="start">
                  <div class="form-group">                    
                    <input type="checkbox" class="check mr-1" id="start-time" checked data-checkbox="icheckbox_flat-red">
                    <label for="start-time">Start</label>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="date">Date</label>
                        <div class="controls">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"
                                ><i class="ti-calendar"></i
                              ></span>
                            </div>
                            <input
                              type="date"
                              class="form-control"
                              e-name="date"
                              placeholder="dd/mm/yyyy"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="time">Time</label>
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
                              e-name="time"
                              placeholder="HH:MM"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 rounded pt-3 mb-3 time-container" c-name="end">
                  <div class="form-group">                    
                    <input type="checkbox" class="check mr-1" id="end-time" data-checkbox="icheckbox_flat-red">
                    <label for="end-time">End</label>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="date">Date</label>
                        <div class="controls">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"
                                ><i class="ti-calendar"></i
                              ></span>
                            </div>
                            <input
                              type="date"
                              class="form-control"
                              e-name="date"
                              placeholder="dd/mm/yyyy"
                              disabled
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="time">Time</label>
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
                              e-name="time"
                              placeholder="HH:MM"
                              disabled                              
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="mb-3 validate-error"></div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="text-center">
                  <h3>Qr Code</h3>
                </div>
                <div>
                  <div class="d-flex justify-content-center align-content-center mb-3">
                    <img
                      class="img-responsive"
                      id="img-qr-code"
                      src="https://via.placeholder.com/250x250"
                      alt=""
                      width="250"
                      height="250"
                    />
                  </div>
                  <div class="d-flex justify-content-center align-content-center">
                    <a href="javascript:;" class="hidden text-info" id="download" download="qrcode.jpg">Download QrCode</a>
                  </div>
                </div>
              </div>
            </div>
            <!--/row-->
          </div>
          <div class="form-actions row my-4">
            <div class="col-md-6">
              <button
                type="submit"
                class="col-md-4 offset-md-4 btn btn-rounded btn-block btn-outline-success"
              >
                <i class="fa fa-check"></i> Generate
              </button>
            </div>
            <div class="col-md-6">
              <button
                type="reset"
                class="col-md-4 offset-md-4 btn btn-rounded btn-block btn-outline-secondary"
              >
                Cancel
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Edit Reference Email Modal --}}
<div id="email-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Reference Email</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-email" action="javascript:;">
        <div class="modal-body p-t-20">
          <div class="form-group">
            <input type="hidden" id="edit-site-id" value="0">
            <div class="col-md-12 row">
              <label class="col-sm-3 text-right control-label col-form-label">City :</label>
              <div class="col-sm-9">
                <input type="text" class="form-control bg-white" id="selected-city-text" required readonly>
              </div>
            </div>
            <div class="col-md-12 m-t-20 row">
              <label for="site-text" class="col-sm-3 text-right control-label col-form-label">Site :</label>
              <div class="col-sm-9">
                <input type="text" class="form-control bg-white" id="selected-site-text" required readonly>
              </div>
            </div>
            <div class="col-md-12 m-t-20 row">
              <label for="ref-email" class="col-sm-3 text-right control-label col-form-label">Reference Email :</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="ref-email" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light btn-site">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/system/validation.js') }}"></script>
<script>
  !(function (window, document, $) {
    "use strict";
    $("input,select").not("[type=submit]").jqBootstrapValidation();
  })(window, document, jQuery);
</script>
<script src="{{ asset('js/qr-new.js') }}"></script>
@endsection