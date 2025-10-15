<nav class="navbar navbar-expand-lg " style="background: #14929b99; width:100vw;">

    <div class="container-fluid">

        <a class="navbar-brand" href="{{url('admin/dashboard')}}">
            <img src="{{ asset('images/Logo.png') }}" width="360" height="100%" class="d-inline-block align-center" id="nav-image-logo"alt="" >
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto " >
            @auth
                {{-- Home --}}
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{url('admin/dashboard')}}" aria-current="page">
                    Home</a>
                </li>

                {{-- Initial Data Dropdown Menu --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('event_create','event_type','employees') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Initial Data
                        <i class='bx bx-chevron-down' style="margin-top: 4px;margin-left:2px" ></i>
                    </a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item {{ request()->is('event_create') ? 'dropdown_active' : '' }}" href="{{ url('/event_create') }}">Initial Event Types</a></li>
                    <li><a class="dropdown-item {{ request()->is('event_type') ? 'dropdown_active' : '' }}" href="{{ url('/event_type') }}">Initial Events</a></li>
                    <li><a class="dropdown-item {{ request()->is('employees') ? 'dropdown_active' : '' }}" href="{{ url('/employees') }}">Employees</a></li>
                    {{-- <li><a class="dropdown-item {{ request()->is('task') ? 'dropdown_active' : '' }}" href="{{ url('/task') }}">Tasks</a></li> --}}
                    </ul>
                </li>


            {{-- Process Data Dropdown Menu --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ Request::is('space_events','assgn_employees','reports/registeredlist') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Process Data
                    <i class='bx bx-chevron-down' style="margin-top: 4px;margin-left:2px"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item {{ request()->is('space_events') ? 'dropdown_active' : '' }}" href="{{ url('/space_events') }}">Manage Events</a></li>
                    <li><a class="dropdown-item {{ request()->is('assgn_employees') ? 'dropdown_active' : '' }}" href="{{ url('/assgn_employees') }}">Assigned Employees</a></li>
{{--                     <li><a class="dropdown-item {{ request()->is('assgn_employees') ? 'dropdown_active' : '' }}" href="{{ route('reports.showRegisteredList') }}">Register Students</a></li> --}}
                </ul>
                </li>


            {{-- Registered Students-Reports --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ Request::is('admin/invitations') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Documents
                    <i class='bx bx-chevron-down' style="margin-top: 4px;margin-left:2px" ></i>
                </a>
                <ul class="dropdown-menu">
                    {{-- <li><a class="dropdown-item {{ request()->is('admin/certificates') ? 'dropdown_active' : '' }}" href="{{url('admin/certificates')}}">Certificates</a></li> --}}
                    <li><a class="dropdown-item {{ request()->is('admin/invitations') ? 'dropdown_active' : '' }}" href="{{url('admin/invitations')}}">Invitations</a></li>
                    {{-- clear the routes and function reports.store <harindu> --}}
                </ul>
            </li>

            {{-- Guidline for the user Help--}}
            <li class="nav-item">
                <a class="nav-link dropdown-toggle {{ Request::is('admin/help') ? 'active' : '' }}" href="{{url('admin/help')}}" aria-current="page"> Help</a>
            </li>


            {{-- Profile --}}
            <li class="dropdown">
                <a class="profile" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bx bxs-user-circle' style="font-size:40px;margin-top:3px;color:#fff" ></i>
                </a>
                    <ul class="dropdown-menu dropdown-menu-lg-end">
                        {{-- <li><a class="dropdown-item" href="{{ url('/admin/profile') }}">Profile</a></li> --}}
                        <li><a class="dropdown-item" href="{{ url('/admin/settings') }}">Settings</a></li>
                        <li><a class="dropdown-item" href="{{ url('logout') }}">LogOut</a></li>
                    </ul>
            </li>

         @endauth

        </ul>
      </div>
    </div>
  </nav>
