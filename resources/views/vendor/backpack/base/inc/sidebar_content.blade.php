<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="nav-icon fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

@php
        $deviceIds = App\Models\Device::pluck('id');
        $deviceNames = App\Models\Device::pluck('name');



@endphp

<li class="nav-title">Device Settings</li>
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('device') }}'><i class='nav-icon fa fa-gear'></i> Schemas</a></li>
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('client') }}'><i class='nav-icon fa fa-desktop'></i> Clients</a></li>
      <li class="nav-title">Miscellaneous</li>
      {{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('alert') }}'><i class='nav-icon fa fa-bell'></i> Alerts</a></li> --}}
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('topic') }}'><i class='nav-icon fa fa-book'></i> Logs</a></li>
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('widget') }}'><i class='nav-icon fa fa-tachometer'></i> Widgets</a></li>

      <li class="nav-title">Account Settings</li>
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('edit-account-info') }}'><i class='nav-icon fa fa-user'></i> Account</a></li>
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('logout') }}'><i class='nav-icon fa fa-lock'></i> Logout</a></li>

@php

@endphp





{{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('custom_metrics') }}'><i class='nav-icon fa fa-question'></i> Custom_metrics</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('custom_metric') }}'><i class='nav-icon fa fa-question'></i> Custom_metrics</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('metric') }}'><i class='nav-icon fa fa-question'></i> Metrics</a></li> --}}


