<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar">
  <nav class="navbar top-navbar navbar-expand-md navbar-dark">
    <!-- ============================================================== -->
    <!-- Logo -->
    <!-- ============================================================== -->
    <div class="navbar-header">
      <a class="navbar-brand" href="{{'/'}}">
        <!-- Logo icon --><b>
          <img
            src="/images/logo.png"
            alt="homepage"
            class="light-logo"
          />
        </b>
      </a>
    </div>
    <!-- ============================================================== -->
    <!-- End Logo -->
    <!-- ============================================================== -->
    <div class="navbar-collapse">
      <!-- ============================================================== -->
      <!-- toggle and nav items -->
      <!-- ============================================================== -->
      <ul class="navbar-nav mr-auto">
        <!-- This is  -->
        <li class="nav-item">
          <a
            class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark"
            href="javascript:void(0)"
            >
            <i class="ti-menu"></i>
          </a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark"
            href="javascript:void(0)"
            >
            <i class="icon-menu"></i>
          </a>
        </li>
        <!-- ============================================================== -->
      </ul>
      <!-- ============================================================== -->
      <!-- User profile and search -->
      <!-- ============================================================== -->
      <ul class="navbar-nav my-lg-0">
        <!-- ============================================================== -->
        <!-- User Profile -->
        <!-- ============================================================== -->
        <li class="nav-item dropdown u-pro">
          <a
            class="nav-link dropdown-toggle waves-effect waves-dark profile-pic"
            href=""
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            >
            <img src="/images/user.png" alt="user" class="" />
            <span class="hidden-md-down">
              {{ Auth::user()->name }} &nbsp;
              <i class="fa fa-angle-down"></i>
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right animated flipInY">
            <a href="{{'/'}}" class="dropdown-item">
              <i class="ti-user"></i> Dashboard
            </a>
            <a href="{{'/settings/admin'}}" class="dropdown-item">
              <i class="ti-settings"></i> Settings
            </a>
            <a href="javascript:;" class="dropdown-item" data-toggle="modal" data-target="#password_modal">
              <i class="ti-key"></i> Change Password
            </a>
            <a href="{{'/logout'}}" class="dropdown-item">
              <i class="fa fa-power-off"></i>
              Logout
            </a>
          </div>
        </li>
        <!-- ============================================================== -->
        <!-- End User Profile -->
        <!-- ============================================================== -->
        <li class="nav-item right-side-toggle">
          <a
            class="nav-link waves-effect waves-light"
            href="javascript:void(0)"
          ></a>
        </li>
      </ul>
    </div>
  </nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->

{{-- Add Grade Modal --}}
<div id="password_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Change Password</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form class="form-password" action="javascript:;">
        <div class="modal-body p-t-40">
          <div class="row">
            <label for="old_pass" class="col-sm-4 text-right control-label col-form-label">Old Password:</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="old_pass" name="old_pass" required pattern=".{5,}" title="Please input more than 5 characters">
            </div>
          </div>
          <div class="row mt-3">
            <label for="new_pass" class="col-sm-4 text-right control-label col-form-label">New Password:</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="password" name="password" required pattern=".{5,}" title="Please input more than 5 characters">
            </div>
          </div>
          <div class="row mt-3">
            <label for="new_pass1" class="col-sm-4 text-right control-label col-form-label">Confirm Password:</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="confirm_password" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect waves-light btn-location">Change</button>
        </div>
      </form>
    </div>
  </div>
</div>