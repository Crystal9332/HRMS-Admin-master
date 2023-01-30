@extends('layouts.common.index')

@section('page-title')
QrCode <i class="breadcrumb-symbol"></i> View
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

</style>    
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <form class="form-qr" action="javascript:;" novalidate>
          <div class="form-body">
            <div class="row">
              <div class="col-md-8">
                <h3 class="card-title">Information</h3>
              </div>
              <div class="col-md-4 d-flex justify-content-end align-items-center">
                <a
                  class="col-md-4 btn btn-rounded btn-info"
                  href="{{route('qrs.create')}}"
                >
                  New
                </a>
                <a
                  class="col-md-4 offset-md-1 btn btn-rounded btn-outline-secondary"
                  href="{{route('qrs.index')}}"
                >
                  View All
                </a>
              </div>
            </div>
            <hr />
            <!--/row-->
            <div class="col-md-10 offset-md-1 row">
              <div class="col-md-6">
                <div class="message"></div>
                <div class="form-group">
                  <label for="title">Title</label>
                  <div class="controls">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon2"
                          ><i class="ti-layout-cta-btn-left"></i
                        ></span>
                      </div>
                      <input
                        type="text"
                        class="form-control bg-white"
                        value="{{$qr->title??$qr->title}}"
                        placeholder="{{!isset($qr->title)? 'NONE': ''}}"
                        readonly
                      />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label text-right">Sender</label>
                  <div class="controls">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon2"
                          ><i class="ti-user"></i
                        ></span>
                      </div>
                      <input
                        type="text"
                        class="form-control bg-white"
                        value="{{$sender}}"
                        readonly
                      />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label text-right">City</label>
                  <div class="controls">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon2"
                          ><i class="fas fa-building"></i
                        ></span>
                      </div>
                      <input
                        type="text"
                        class="form-control bg-white"
                        value="{{$qr->city}}"
                        readonly
                      />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label text-right">Site</label>
                  <div class="controls">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon2"
                          ><i class="ti-world"></i
                        ></span>
                      </div>
                      <input
                        type="text"
                        class="form-control bg-white"
                        value="{{$qr->site}}"
                        readonly
                      />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="email">Reference email address</label>
                  <div class="controls">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon2"
                          ><i class="ti-email"></i
                        ></span>
                      </div>
                      <input
                        type="text"
                        class="form-control bg-white"
                        value="{{$qr->email}}"
                        readonly
                      />
                    </div>
                  </div>
                </div>

                @if (isset($qr->start_time))
                  <div class="col-12 rounded pt-3 mb-3 time-container">
                    <div class="form-group">
                      <label>Start</label>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="date">Date</label>
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"
                                ><i class="ti-calendar"></i
                              ></span>
                            </div>
                            <input
                              type="text"
                              class="form-control"
                              value="{{ explode(' ', $qr->start_time)[0] }}"
                              readonly
                            />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="time">Time</label>
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"
                                ><i class="ti-timer"></i
                              ></span>
                            </div>
                            <input
                              type="text"
                              class="form-control"
                              value="{{ explode(' ', $qr->start_time)[1] }}"
                              placeholder="HH:MM"
                              readonly
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endif

                @if (isset($qr->end_time))
                  <div class="col-12 rounded pt-3 mb-3 time-container">
                    <div class="form-group">
                      <label>End</label>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="date">Date</label>
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"
                                ><i class="ti-calendar"></i
                              ></span>
                            </div>
                            <input
                              type="text"
                              class="form-control"
                              value="{{ explode(' ', $qr->end_time)[0] }}"
                              readonly
                            />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="time">Time</label>
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"
                                ><i class="ti-timer"></i
                              ></span>
                            </div>
                            <input
                              type="text"
                              class="form-control"
                              value="{{ explode(' ', $qr->end_time)[1] }}"
                              placeholder="HH:MM"
                              readonly
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endif

              </div>
              <!--/span-->
              <div class="col-md-6 pt-5">
                <div class="text-center mt-5">
                  <h3>Qr Code</h3>
                </div>
                <div>
                  <div class="d-flex justify-content-center align-content-center mb-3" id="qr-code">
                    {!! $qr->code !!}
                  </div>
                  <div class="d-flex justify-content-center align-content-center">
                    <a href="javascript:;" class="text-info" id="download" download="qrcode.jpg">Download QrCode</a>
                  </div>
                </div>
              </div>
            </div>
            <!--/row-->
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/qr-view.js') }}"></script>
@endsection