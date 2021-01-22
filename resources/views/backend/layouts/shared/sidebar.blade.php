
<!--
  ====================================
  ——— LEFT SIDEBAR WITH FOOTER
  =====================================
-->
<aside class="left-sidebar bg-sidebar">
    <div id="sidebar" class="sidebar sidebar-with-footer">
        <!-- Aplication Brand -->
        <div class="app-brand">
            <a href="{{ route('dashboard.index') }}" title="{{ env('APP_NAME') }}">
                <svg
                    class="brand-icon"
                    xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="xMidYMid"
                    width="30"
                    height="33"
                    viewBox="0 0 30 33"
                >
                    <g fill="none" fill-rule="evenodd">
                        <path
                            class="logo-fill-blue"
                            fill="#7DBCFF"
                            d="M0 4v25l8 4V0zM22 4v25l8 4V0z"
                        />
                        <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                    </g>
                </svg>
                <span class="brand-name text-truncate">{{ env('APP_NAME') }}</span>
            </a>
        </div>
        <!-- begin sidebar scrollbar -->
        <div class="sidebar-scrollbar">

            <!-- sidebar menu -->
            <ul class="nav sidebar-inner" id="sidebar-menu">



                @foreach(config('sidebar.links') as $link )
                    @php
                        $link['active'] = in_array(Request::route()->getName(),collect($link['sub'])->pluck('route')->toArray());
                    @endphp

                    <li  class="has-sub {{$link['active']?'active expand':''}} ">
                        <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#{{$link['name']}}"
                           aria-expanded="false" aria-controls="{{$link['name']}}">
                            <i class="{{$link['icon']}}"></i>
                            <span class="nav-text">{{__('backend.'.$link['name'])}}</span> <b class="caret"></b>
                        </a>
                        <ul  class="collapse"  id="{{$link['name']}}"
                             data-parent="#sidebar-menu">
                            <div class="sub-menu">

                                    @foreach($link['sub'] as $sub)
                                    <li >
                                        <a class="sidenav-item-link" href="{{route($sub['route'])}}">
                                            <span class="nav-text">{{__('backend.'.$sub['name'])}}</span>
                                            @if($sub['new'])
                                                <span class="badge badge-{{$sub['color']}}">new</span>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </div>
                        </ul>
                    </li>
                @endforeach

            </ul>

        </div>

        <div class="sidebar-footer">
            <hr class="separator mb-0" />
{{--            <div class="sidebar-footer-content">--}}
{{--                <h6 class="text-uppercase">--}}
{{--                    Cpu Uses <span class="float-right">40%</span>--}}
{{--                </h6>--}}
{{--                <div class="progress progress-xs">--}}
{{--                    <div--}}
{{--                        class="progress-bar active"--}}
{{--                        style="width: 40%;"--}}
{{--                        role="progressbar"--}}
{{--                    ></div>--}}
{{--                </div>--}}
{{--                <h6 class="text-uppercase">--}}
{{--                    Memory Uses <span class="float-right">65%</span>--}}
{{--                </h6>--}}
{{--                <div class="progress progress-xs">--}}
{{--                    <div--}}
{{--                        class="progress-bar progress-bar-warning"--}}
{{--                        style="width: 65%;"--}}
{{--                        role="progressbar"--}}
{{--                    ></div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
</aside>
<div class="page-wrapper">
    @include('backend.layouts.shared.navbar')
    <div class="content-wrapper">
        <div class="content">
