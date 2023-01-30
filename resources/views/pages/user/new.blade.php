@extends('layouts.common.index')

@section('page-title')
User Mangement <i class="breadcrumb-symbol"></i> New
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('users.store') }}" novalidate>
          @csrf
          <div class="form-body">
            <h3 class="card-title">Personal Information</h3>
            <hr />
            @if (session('success'))
              <div class="form-group text-primary font-weight-bold">
                {{session('success')}}
              </div>
            @endif
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
                        class="form-control"
                        id="userId"
                        name="userId"
                        placeholder="User ID"
                        aria-label="User ID"
                        required
                        data-validation-required-message="This field is required"
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
                  <label for="nation">National ID</label>
                  <div class="controls">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"
                          ><i class="far fa-address-book"></i
                        ></span>
                      </div>
                      <input
                        type="text"
                        class="form-control"
                        id="nation"
                        name="nation"
                        placeholder="National ID"
                        aria-label="National ID"
                        required
                        data-validation-required-message="This field is required"
                        minlength="5"
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
                      <select
                        class="form-control"
                        name="gender"
                        required
                      >
                        <option value="">Choose Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                      </select>
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
                        class="form-control"
                        id="username"
                        name="name"
                        placeholder="Username"
                        aria-label="Username"
                        aria-describedby="basic-addon1"
                        required
                        data-validation-required-message="This field is required"
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
                      <select
                        class="form-control"
                        id="city"
                        required
                      >
                        <option value="">Choose City</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                      </select>
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
                        class="form-control"
                        id="phone"
                        name="phone"
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
                      <select
                        class="form-control"
                        id="site"
                        name="site_id"
                        required
                      >
                        <option value="">Choose Site</option>
                      </select>
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
                        class="form-control"
                        id="email"
                        name="email"
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
                      <select
                        class="form-control"
                        name="job_id"
                        required
                      >
                        <option value="">Choose Job</option>
                        @foreach($jobs as $job)
                            <option value="{{ $job->id }}">{{ $job->name }}</option>
                        @endforeach
                      </select>
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
                        class="form-control"
                        id="birthday"
                        name="birthday"
                        placeholder="dd/mm/yyyy"
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
                        class="form-control"
                        id="expiry_date"
                        name="expiry_date"
                        placeholder="dd/mm/yyyy"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <!--/span-->
            </div>
            <!--/row-->
          </div>
          <div class="form-actions row">
            <div class="col-md-6">
              <button
                type="submit"
                class="col-md-4 offset-md-4 btn btn-rounded btn-block btn-outline-success"
              >
                <i class="fa fa-check"></i> Add
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