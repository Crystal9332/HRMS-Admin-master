@extends('layouts.common.index')

@section('styles')
<style>
  div.card {
    min-height: fit-content;
  }
</style>
@endsection

@section('page-title')
Dashboard
@endsection

@section('content')
<div>
  <div class="card-group">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <a class="d-flex no-block align-items-center" href="/users">
              <div>
                <h3><i class="icon-screen-desktop"></i></h3>
                <p class="text-muted">All Users</p>
              </div>
              <div class="ml-auto">
                <h2 class="counter text-primary">{{$users-1}}</h2>
              </div>
            </a>
          </div>
          <div class="col-12">
            <div class="progress">
              <div class="progress-bar bg-primary" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <a class="d-flex no-block align-items-center" href="/cities">
              <div>
                <h3><i class="icon-note"></i></h3>
                <p class="text-muted">Cities</p>
              </div>
              <div class="ml-auto">
                <h2 class="counter text-cyan">{{$cities}}</h2>
              </div>
            </a>
          </div>
          <div class="col-12">
            <div class="progress">
              <div class="progress-bar bg-cyan" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <a class="d-flex no-block align-items-center" href="/sites">
              <div>
                <h3><i class="icon-note"></i></h3>
                <p class="text-muted">Sites</p>
              </div>
              <div class="ml-auto">
                <h2 class="counter text-cyan">{{$sites}}</h2>
              </div>
            </a>
          </div>
          <div class="col-12">
            <div class="progress">
              <div class="progress-bar bg-purple" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <a class="d-flex no-block align-items-center" href="/qrs">
              <div>
                <h3><i class="icon-note"></i></h3>
                <p class="text-muted">Qr-codes</p>
              </div>
              <div class="ml-auto">
                <h2 class="counter text-cyan">{{$qrs}}</h2>
              </div>
            </a>
          </div>
          <div class="col-12">
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function () {
    "use strict";
    //This is for the Notification top right
    $.toast({
        heading: 'Welcome to admin panel',
        // text: 'Use the predefined ones, or specify a custom position object.',
        position: 'top-right',
        loaderBg: '#ff6849',
        icon: 'info',
        hideAfter: 3500,
        stack: 6
    })
  });
</script>
@endsection