@extends('layouts.common.index')

@section('styles')
@endsection

@section('page-title')
Dashboard
@endsection

@section('content')
  Dashboard for Site Manager
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