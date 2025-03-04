<div class="sidebar">
    <nav>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @switch(Auth::user()->UserType)
                @case(1)
                    {{-- SUPERADMIN TAB --}}
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
                    
                    {{-- ELECTION TAB --}}
                    <li class="nav-item mt-2">
                        <a href="{{route("election.dashboard")}}" class="nav-link nav-main-tab tabLink font-weight-bold">
                            <i class="nav-icon fa fa-th-large fa-lg"></i>
                            <p>Election Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{route("election.position")}}" class="nav-link nav-main-tab tabLink  font-weight-bold">
                            <i class="nav-icon fas fa-cogs fa-lg"></i>
                            <p>Election Positions</p>
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{route("election.candidate")}}" class="nav-link nav-main-tab tabLink  font-weight-bold">
                            <i class="nav-icon fas fa-users fa-lg"></i>
                            <p>Election Candidates</p>
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{route("election.tickets")}}" class="nav-link nav-main-tab tabLink font-weight-bold">
                            <i class="nav-icon fas fa-print fa-lg"></i>
                            <p>Tickets Printing</p>
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{route("election.summary")}}" class="nav-link nav-main-tab tabLink font-weight-bold">
                            <i class="nav-icon fas fa-print fa-lg"></i>
                            <p>Election Summary</p>
                        </a>
                    </li>

                    {{-- UTILITY TAB --}}
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

                    {{-- F2F ELECTION TAB --}}
                    <li class="nav-item mt-2">
                        <a href="{{route("F2Felection.index")}}" class="nav-link nav-main-tab tabLink font-weight-bold">
                            <i class="nav-icon fas fa-vote-yea fa-lg"></i>
                            <p>F2F Election</p>
                        </a>
                    </li>
                    
                    {{-- SUPPLIES TAB --}}
                    <li class="nav-item mt-2">
                        <a href="{{route("supplies.index")}}" class="nav-link nav-main-tab tabLink font-weight-bold">
                            <i class="nav-icon fas fa-shopping-basket fa-lg"></i>
                            <p>GA Items</p>
                        </a>
                    </li>
                @break

                @case(2)
                    <li class="nav-item mt-2">
                        <a href="{{route("election.tickets")}}" class="nav-link nav-main-tab tabLink active font-weight-bold">
                            <i class="nav-icon fas fa-print fa-lg"></i>
                            <p>Tickets Printing</p>
                        </a>
                    </li>
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

                @case(4)
                    <li class="nav-item mt-2">
                        <a href="{{route("F2Felection.index")}}" class="nav-link nav-main-tab tabLink active font-weight-bold">
                            <i class="nav-icon fas fa-vote-yea fa-lg"></i>
                            <p>F2F Election</p>
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{route("supplies.index")}}" class="nav-link nav-main-tab tabLink font-weight-bold">
                            <i class="nav-icon fas fa-shopping-basket fa-lg"></i>
                            <p>GA Items</p>
                        </a>
                    </li>
                @break

                @case(5)
                    <li class="nav-item mt-2">
                        <a href="{{route("member.voting")}}" class="nav-link nav-main-tab tabLink active font-weight-bold">
                            <i class="nav-icon fas fa-vote-yea fa-lg"></i>
                            <p>Election Voting</p>
                        </a>
                    </li>
                @break

                @case(6)
                    {{-- UTILITY TAB --}}
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

                    {{-- F2F ELECTION TAB --}}
                    <li class="nav-item mt-2">
                        <a href="{{route("F2Felection.index")}}" class="nav-link nav-main-tab tabLink font-weight-bold">
                            <i class="nav-icon fas fa-vote-yea fa-lg"></i>
                            <p>F2F Election</p>
                        </a>
                    </li>

                    {{-- SUPPLIES TAB --}}
                    <li class="nav-item mt-2">
                        <a href="{{route("supplies.index")}}" class="nav-link nav-main-tab tabLink font-weight-bold">
                            <i class="nav-icon fas fa-shopping-basket fa-lg"></i>
                            <p>GA Items</p>
                        </a>
                    </li>
                @break
            @endswitch
        </ul>
    </nav>
</div>