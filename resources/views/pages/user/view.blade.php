@extends('layouts.common.index')

@section('page-title')
User Mangement <i class="breadcrumb-symbol"></i> Detail
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="form-body">
          <div class="row">
            <div class="col-md-8">
              <h3 class="card-title">Personal Information</h3>
            </div>
            <div class="col-md-4 d-flex justify-content-end align-items-center">
              <a
                class="col-md-4 offset-md-4 btn btn-rounded btn-block btn-outline-success"
                href="{{route('users.edit', $user->id)}}"
              >
                Edit
              </a>
            </div>
          </div>
          <hr />
          <div class="row p-t-20">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nation">User ID</label>
                <div class="controls">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"
                        ><i class="ti-id-badge"></i
                      ></span>
                    </div>
                    <input
                      type="text"
                      class="form-control bg-white"
                      value="{{ $user->userId }}"
                      readonly
                    />
                  </div>
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          <div class="row p-t-20">
            <div class="col-md-6">
              <div class="form-group">
                <label for="national_id">National ID</label>
                <div class="controls">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"
                        ><i class="far fa-address-book"></i
                      ></span>
                    </div>
                    <input
                      type="text"
                      class="form-control bg-white"
                      value="{{ $user->nation }}"
                      readonly
                    />
                  </div>
                </div>
              </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Gender</label>
                <div class="controls">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"
                        ><i class="icon-people"></i
                      ></span>
                    </div>
                    <input
                      type="text"
                      class="form-control bg-white"
                      value=" @if($user->gener=='male') Male @else Female @endif"
                      readonly
                    />
                  </div>
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="username">User Name</label>
                <div class="controls">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"
                        ><i class="ti-user"></i
                      ></span>
                    </div>
                    <input
                      type="text"
                      class="form-control bg-white"
                      value="{{ $user->name }}"
                      readonly
                    />
                  </div>
                </div>
              </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
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
                      value="{{ $user->city }}"
                      readonly
                    />
                  </div>
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="phone">Phone</label>
                <div class="controls">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon2"
                        ><i class="icon-phone"></i
                      ></span>
                    </div>
                    <input
                      type="text"
                      class="form-control bg-white"
                      value="{{ $user->phone }}"
                      readonly
                    />
                  </div>
                </div>
              </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
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
                      value="{{ $user->site }}"
                      readonly
                    />
                  </div>
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="email">Email address</label>
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
                      value="{{ $user->email }}"
                      readonly
                    />
                  </div>
                </div>
              </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label text-right">Job Title</label>
                <div class="controls">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon2"
                        ><i class="ti-search"></i
                      ></span>
                    </div>
                    <input
                      type="text"
                      class="form-control bg-white"
                      value="{{ $user->job }}"
                      readonly
                    />
                  </div>
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="birthday">Date of Birth</label>
                <div class="controls">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"
                        ><i class="ti-calendar"></i
                      ></span>
                    </div>
                    <input
                      type="date"
                      class="form-control bg-white"
                      value="{{ $user->birthday }}"
                      placeholder="dd/mm/yyyy"
                      readonly
                    />
                  </div>
                </div>
              </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group">
                <label for="expiry_date">Expiry date</label>
                <div class="controls">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"
                        ><i class="ti-calendar"></i
                      ></span>
                    </div>
                    <input
                      type="date"
                      class="form-control bg-white"
                      value="{{ $user->expiry_date }}"
                      placeholder="dd/mm/yyyy"
                      readonly
                    />
                  </div>
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/system/validation.js') }}"></script>
<script>
  !(function (window, document, $) {
    "use strict";
    $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
  })(window, document, jQuery);
</script>
<script src="{{ asset('js/users-new.js') }}"></script>
@endsection