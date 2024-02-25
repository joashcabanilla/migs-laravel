<div class="sidebar">
    <nav>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @switch(Auth::user()->UserType)
                @case(1)
                    <li class="nav-item mt-2">
                        <a href="{{route("admin.user")}}" class="nav-link nav-main-tab active tabLink">
                            <i class="nav-icon fas fa-users fa-lg"></i>
                            <p>User Account</p>
                        </a>
                    </li>

                    <li class="nav-item mt-2">
                        <a href="{{route("admin.maintenance")}}" class="nav-link nav-main-tab tabLink  font-weight-bold">
                            <i class="nav-icon fas fa-cogs fa-lg"></i>
                            <p>Maintenance</p>
                        </a>
                    </li>

                    <li class="nav-item mt-2">
                        <a href="{{route("utility.dashboard")}}" class="nav-link nav-main-tab tabLink font-weight-bold">
                            <i class="nav-icon fa fa-th-large fa-lg"></i>
                            <p>Utility Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{route("utility.member")}}" class="nav-link nav-main-tab tabLink font-weight-bold">
                            <i class="nav-icon fas fa-users fa-lg"></i>
                            <p>Member Information</p>
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{route("utility.status")}}" class="nav-link nav-main-tab tabLink font-weight-bold">
                            <i class="nav-icon fas fa-users fa-lg"></i>
                            <p>Member Status</p>
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{route("utility.verification")}}" class="nav-link nav-main-tab tabLink font-weight-bold">
                            <i class="nav-icon fas fa-user-check fa-lg"></i>
                            <p>Utility Verification</p>
                        </a>
                    </li>
                @break

                @case(2)
                @break

                @case(3)
                <li class="nav-item mt-2">
                    <a href="{{route("utility.dashboard")}}" class="nav-link nav-main-tab tabLink active font-weight-bold">
                        <i class="nav-icon fa fa-th-large fa-lg"></i>
                        <p>Utility Dashboard</p>
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{route("utility.member")}}" class="nav-link nav-main-tab tabLink font-weight-bold">
                        <i class="nav-icon fas fa-users fa-lg"></i>
                        <p>Member Information</p>
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{route("utility.status")}}" class="nav-link nav-main-tab tabLink font-weight-bold">
                        <i class="nav-icon fas fa-users fa-lg"></i>
                        <p>Member Status</p>
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{route("utility.verification")}}" class="nav-link nav-main-tab tabLink font-weight-bold">
                        <i class="nav-icon fas fa-user-check fa-lg"></i>
                        <p>Utility Verification</p>
                    </a>
                </li>
                @break
            @endswitch
        </ul>
    </nav>
</div>