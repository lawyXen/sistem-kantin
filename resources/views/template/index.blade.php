<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    @yield('title')

    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('helper/css/toastr.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('helper/css/confirm.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('helper/css/pagination.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('helper/css/custom.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('editor/minified/themes/default.min.css')}}" type="text/css" />


    @yield('css')
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            @include('template.menu')
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
                                data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
                                data-bs-toggle="dropdown">
                                <img src="{{ asset('assets/images/avatars/avatar-2.jpg') }}"
                                    class="avatar img-fluid rounded me-1" alt="Axell" /> <span class="text-dark">{{
                                    Auth::user()->username }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                {{-- <a class="dropdown-item" href=" "><i class="align-middle me-1"
                                        data-feather="user"></i>
                                    Profile</a> --}}
                                {{-- <div class="dropdown-divider"></div> --}}
                                <a class="dropdown-item" id="button_id"
                                    onclick="do_logout('#button_id', '{{ route('logout') }}')">Log
                                    out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                @yield('content')
            </main>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="{{asset('helper/js/confirm.js')}}"></script>
    <script src="{{asset('helper/js/plugin.js')}}"></script>
    <script src="{{asset('helper/js/toastr.js')}}"></script>
    <script src="{{asset('helper/js/custom.js')}}"></script>

    <script src="{{asset('editor/minified/sceditor.min.js')}}"></script>
    <script src="{{asset('editor/minified/formats/bbcode.js')}}"></script>
    <script src="{{asset('editor/minified/formats/xhtml.js')}}"></script>


    @yield('scripts')
</body>

</html>