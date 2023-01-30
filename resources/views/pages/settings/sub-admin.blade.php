@extends('layouts.common.index')

@section('page-title')
Settings <i class="breadcrumb-symbol"></i> Admin
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <form method="post" action="{{ route('users.update', $user->id) }}" novalidate>
          @csrf
          @method('PUT')
          <div class="form-body">
            <div class="col">
              <h3 class="card-title">My Information</h3>
            </div>
            <hr />
            @if (session('success'))
              <div class="form-group text-info font-weight-bold">
                <h3>
                  {{session('success')}}
                </h3>
              </div>
            @endif
            <input type="hidden" name="site_id" value="{{ $user->site_id }}"/>
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
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nation">National ID</label>
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
                        id="nation"
                        name="nation"
                        value="{{ $user->nation }}"
                        placeholder="National ID"
                        aria-label="National ID"
                        aria-describedby="basic-addon1"
                        required
                        data-validation-required-message="This field is required"
                        minlength="5"
                        maxlength="10"
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
                            <option
                              value="{{ $job->id }}"
                              @if ($job->id == $user->job_id)
                                selected
                              @endif
                            >
                              {{ $job->name }}
                            </option>
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
                        value="{{ $user->phone }}"
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
                        value="{{ $user->birthday }}"
                        placeholder="dd/mm/yyyy"
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
                        <option 
                          value="male"
                          @if ($user->gender == 'male')
                            selected
                          @endif
                        >
                          Male
                        </option>
                        <option
                          value="female"
                          @if ($user->gender == 'female')
                            selected
                          @endif
                        >
                          Female
                        </option>
                      </select>
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
                        value="{{ $user->expiry_date }}"
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
                <i class="fa fa-check"></i> Update
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
@endsection