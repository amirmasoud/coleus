  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          {{-- {{ HTML::image(Auth::user()->web->picture, 'User Image', ['class' => 'img-circle']) }} --}}
          <img src="../../node_modules/admin-lte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Admin</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-user text-default"></i> Admin</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <!-- Optionally, you can add icons to the links -->
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i><span> Dashboard</span></a></li>
{{--         <li class="{{ (str_contains(Request::url(), route('dashboard'))) ? 'active' : '' }}"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i><span> Dashboard</span></a></li>
        <li class="{{ (str_contains(Request::url(), route('drivers.index'))) ? 'active' : '' }}"><a href="{{ route('drivers.index') }}"><i class='ion-model-s'></i><span> Drivers</span></a></li>
        <li class="{{ (str_contains(Request::url(), route('clients.index'))) ? 'active' : '' }}"><a href="{{ route('clients.index') }}"><i class='ion-android-walk'></i><span> Clients</span></a></li>
        <li class="{{ (str_contains(Request::url(), route('trips.index'))) ? 'active' : '' }}"><a href="{{ route('trips.index') }}"><i class='ion-android-navigate'></i><span> Trips</span></a></li>
        <li class="{{ (str_contains(Request::url(), route('maps.index'))) ? 'active' : '' }}"><a href="{{ route('maps.index') }}"><i class='ion-map'></i><span> Maps</span></a></li>
        <li class="{{ (str_contains(Request::url(), 'admin/payments')) ? 'treeview active' : 'treeview' }}">
          <a href="#"><i class="ion-card"></i> <span>Payments</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ (ends_with(Request::url(), route('payments.index'))) ? 'active' : '' }}"><a href="{{ route('payments.index') }}">All</span></a></li>
            <li class="{{ (ends_with(Request::url(), 'drivers') || ends_with(Request::url(), 'trips')) ? 'active' : '' }}"><a href="{{ route('payments.drivers') }}">Drivers</span></a></li>
          </ul>
        </li>
        <li class="{{ (str_contains(Request::url(), 'admin/settings')) ? 'treeview active' : 'treeview' }}">
          <a href="#"><i class="ion-gear-a"></i> <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ (str_contains(Request::url(), route('settings.backup.index'))) ? 'active' : '' }}"><a href="{{ route('settings.backup.index') }}">Backup</a></li>
            <li class="{{ (str_contains(Request::url(), route('settings.logs.index'))) ? 'active' : '' }}"><a href="{{ route('settings.logs.index') }}">Logs</a></li>
            <li class="{{ (str_contains(Request::url(), route('settings.fcm.index'))) ? 'active' : '' }}"><a href="{{ route('settings.fcm.index') }}">FCM</a></li>
            <li class="{{ (str_contains(Request::url(), route('settings.requests.index'))) ? 'active' : '' }}"><a href="{{ route('settings.requests.index') }}">Requests</a></li>
          </ul>
        </li> --}}
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
