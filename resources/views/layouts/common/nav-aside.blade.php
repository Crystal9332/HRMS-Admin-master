<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
@php
//  print_r(Auth::user());exit;
 $role = Auth::user()->role->name=='Admin'? true: false;
//  $role = false;
@endphp
<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div class="scroll-sidebar">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
      <ul id="sidebarnav">
        <li class="user-pro">
          <a href="javascript:void(0)">
            <img src="/images/user.png" alt="user-img" class="img-circle" />
            <span class="hide-menu">
              Welcome <strong>{{ Auth::user()->name }}</strong>!
            </span>
          </a>
        </li>
        <li>
          <a
            class="has-arrow waves-effect waves-dark"
            href="javascript:void(0)"
            aria-expanded="false"
            >
            <i class="icon-people"></i>
            <span class="hide-menu">User Management</span>
          </a>
          <ul aria-expanded="false" class="collapse">
            <li><a href="{{'/users/create'}}">New User</a></li>
            <li><a href="{{'/users'}}">All Users</a></li>
          </ul>
        </li>
        @if($role)
          <li>
            <a
              class="has-arrow waves-effect waves-dark"
              href="javascript:;"
              aria-expanded="false"
              >
              <i class="ti-layout-grid2"></i>
              <span class="hide-menu">City & Site</span>
            </a>
            <ul aria-expanded="false" class="collapse">
              <li>
                <a href="{{'/cities'}}">City</a>
                <a href="{{'/sites'}}">Site</a>
              </li>
            </ul>
          </li>
          <li>
            <a
              class="has-arrow waves-effect waves-dark"
              href="javascript:void(0)"
              aria-expanded="false"
              >
              <i class="ti-layout-grid2-thumb"></i>
              <span class="hide-menu">QR Code</span>
            </a>
            <ul aria-expanded="false" class="collapse">
              <li>
                <a href="{{'/qrs/create'}}">New</a>
                <a href="{{'/qrs'}}">All</a>
                <a href="{{'/schedules'}}">Schedule Management</a>
              </li>
            </ul>
          </li>
        @else
          <li>
            <a
              class="waves-effect waves-dark"
              href="{{'/qrs/create'}}"
              aria-expanded="false"
              >
              <i class="ti-layout-grid2-thumb"></i>
              <span class="hide-menu">QR Code</span>
            </a>
          </li>
        @endif
        <li>
          <a
            class="has-arrow waves-effect waves-dark"
            href="javascript:void(0)"
            aria-expanded="false"
            >
            <i class="ti-book"></i>
            <span class="hide-menu">Report</span>
          </a>
          <ul aria-expanded="false" class="collapse">
            <li>
              <a href="{{'/reports/orders'}}">Orders</a>
              <a href="{{'/reports/schedules'}}">Schedules</a>
              {{-- <a href="{{'/reports/offer'}}">Offer time</a> --}}
            </li>
          </ul>
        </li>
        <li>
          <a
            class="has-arrow waves-effect waves-dark"
            href="javascript:void(0)"
            aria-expanded="false"
            >
            <i class="ti-settings"></i>
            <span class="hide-menu">Settings</span>
          </a>
          <ul aria-expanded="false" class="collapse">
            <li>
              @if ($role)
                {{-- <a href="{{'/settings/admin'}}">Admin Setting</a> --}}
                <a href="{{'/settings/general'}}">General Setting</a>
                <a href="{{'/settings/group'}}">Group Setting</a>
                <a href="{{'/settings/permission'}}">Permission Setting</a>
              @else
                <a href="{{'/settings/admin'}}">User Setting</a>
              @endif
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->