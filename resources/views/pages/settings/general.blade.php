@extends('layouts.common.index')

@section('page-title')
Settings <i class="breadcrumb-symbol"></i> General
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title">Personal Information</h3>
        <hr />
        <div class="col-md-6 offset-md-3">
          <form id="form_setting" action="javascript:;" novalidate>
            @csrf
            <div class="form-body">
              <div class="form-group text-primary font-weight-bold message">
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="username">Logo</label>
                  <div class="controls">
                    <div class="input-group mb-3">
                      <input
                        type="file"
                        id="logo"
                        class="dropify"
                        data-max-width="180"
                        data-max-height="65"
                        data-allowed-file-extensions="png"
                        data-default-file="{{ asset('/images/logo.png') }}"
                        required
                        data-validation-required-message="Logo image is required"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="username">Name</label>
                  <div class="controls">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"
                          ><i class="ti-user"></i
                        ></span>
                      </div>
                      <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        value="{{$name}}"
                        placeholder="Name"
                        aria-label="Name"
                        aria-describedby="basic-addon1"
                        required
                        data-validation-required-message="This field is required"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="username">Location</label>
                  <div class="controls">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"
                          ><i class="ti-user"></i
                        ></span>
                      </div>
                      <input
                        type="text"
                        class="form-control"
                        id="location"
                        name="location"
                        value="{{$location}}"
                        placeholder="Location"
                        aria-label="Location"
                        aria-describedby="basic-addon1"
                        required
                        data-validation-required-message="This field is required"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
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
                        class="form-control"
                        id="email"
                        name="email"
                        value="{{$user->email}}"
                        placeholder="Email"
                        aria-label="Email"
                        aria-describedby="basic-addon2"
                        required
                        data-validation-regex-regex="([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})"
                        data-validation-regex-message="Enter Valid Email"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
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
                      class="form-control"
                      id="phone"
                      name="phone"
                      value="{{$user->phone}}"
                      placeholder="123456789012"
                      aria-label="Phone"
                      aria-describedby="basic-addon2"
                      data-validation-regex-regex="^[0-9]{10,12}$"
                      data-validation-regex-message="Input correct phone number"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="form-actions row">
              <div class="col-md-6">
                <button
                  type="submit"
                  class="col-md-4 offset-md-4 btn btn-rounded btn-block btn-outline-success"
                >
                  <i class="fa fa-check"></i> Edit
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
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/system/validation.js') }}"></script>
<script>
  !(function (window, document, $) {
    "use strict";
    $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
  })(window, document, jQuery);
  
  $('.dropify').dropify();

</script>
<script src="{{ asset('js/settings-general.js') }}"></script>
@endsection