<!-- Header -->
<header class="main-header " id="header">
    <nav class="navbar navbar-static-top navbar-expand-lg">
        <!-- Sidebar toggle button -->
        <button id="sidebar-toggler" class="sidebar-toggle">
            <span class="sr-only">{{ env('APP_NAME') }}</span>
        </button>
        <!-- search form -->
        <div class="search-form d-none d-lg-inline-block">
            {{-- <div class="input-group">
                <button type="button" name="search" id="search-btn" class="btn btn-flat">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <input type="text" name="query" id="search-input" class="form-control" placeholder="'button', 'chart' etc."
                       autofocus autocomplete="off" />
            </div> --}}
            <div id="search-results-container">
                <ul id="search-results"></ul>
            </div>
        </div>

        <div class="navbar-right ">
            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu">
                    <button class="dropdown-toggle" data-toggle="dropdown">
                        <i class="mdi mdi-bell-outline"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-header">You have 5 notifications</li>
                        <li>
                            <a href="#">
                                <i class="mdi mdi-account-plus"></i> New user registered
                                <span class=" font-size-12 d-inline-block float-right"><i class="mdi mdi-clock-outline"></i> 10 AM</span>
                            </a>
                        </li>
{{--                        --}}{{-- <li>--}}
{{--                            <a href="#">--}}
{{--                                <i class="mdi mdi-account-remove"></i> User deleted--}}
{{--                                <span class=" font-size-12 d-inline-block float-right"><i class="mdi mdi-clock-outline"></i> 07 AM</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#">--}}
{{--                                <i class="mdi mdi-chart-areaspline"></i> Sales report is ready--}}
{{--                                <span class=" font-size-12 d-inline-block float-right"><i class="mdi mdi-clock-outline"></i> 12 PM</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#">--}}
{{--                                <i class="mdi mdi-account-supervisor"></i> New client--}}
{{--                                <span class=" font-size-12 d-inline-block float-right"><i class="mdi mdi-clock-outline"></i> 10 AM</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#">--}}
{{--                                <i class="mdi mdi-server-network-off"></i> Server overloaded--}}
{{--                                <span class=" font-size-12 d-inline-block float-right"><i class="mdi mdi-clock-outline"></i> 05 AM</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="dropdown-footer">--}}
{{--                            <a class="text-center" href="#"> View All </a>--}}
{{--                        </li> --}}


                    </ul>
                </li>




                <li class="dropdown notifications-menu language-menu">
                    <button class="dropdown-toggle" data-toggle="dropdown">
                        <i class="mdi mdi-translate"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" style="width: 230px">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    <i class="flag-icon flag-icon-{{$properties['flag']}}" title="{{$localeCode}}" id="{{$localeCode}}"></i> {{$properties['native']}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
{{--                <li class="right-sidebar-in right-sidebar-2-menu">--}}
{{--                    <i class="mdi mdi-settings mdi-spin"></i>--}}
{{--                </li>--}}
                <!-- User Account -->
                <li class="dropdown user-menu">
                    <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <img src="{{ uploads(auth(ADMIN_GUARD)->user()->avatar) }}" class="user-image" alt="{{ auth(ADMIN_GUARD)->user()->name }} avatar" />
                        <span class="d-none d-lg-inline-block">{{ auth(ADMIN_GUARD)->user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <!-- User image -->
                        <li class="dropdown-header">
                            <img src="{{ uploads(auth(ADMIN_GUARD)->user()->avatar) }}" class="img-circle" alt="{{ auth(ADMIN_GUARD)->user()->name }} avatar" />
                            <div class="d-inline-block">
                                {{ auth(ADMIN_GUARD)->user()->name }} <small class="pt-1">{{ auth(ADMIN_GUARD)->user()->email }}</small>
                            </div>
                        </li>

                        <li>
                            <a href="{{ route('dashboard.account.show') }}">
                                <i class="mdi mdi-account"></i> My Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.permissions.refresh') }}">
                                <i class="mdi mdi-refresh"></i> Refresh
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="mdi mdi-email"></i> Message
                            </a>
                        </li>
                        <li class="right-sidebar-in">
                            <a href="javascript:0"> <i class="mdi mdi-settings"></i> Setting </a>
                        </li>

                        <li class="dropdown-footer">
                            <a href="{{ route('dashboard.logout') }}"> <i class="mdi mdi-logout"></i> Log Out </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>


</header>
