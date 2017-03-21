@include('admin/includes/head')
@include('admin/includes/header')
@include('admin/includes/sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('header')
        <small>@yield('desc', '')</small>
      </h1>
      <ol class="breadcrumb">
        @yield('breadcrumb')
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('flash::message')
      @include('admin.includes.validation')
      @yield('content')
    </section>
  </div>
  <!-- /.content-wrapper -->
@include('admin/includes/footer')
