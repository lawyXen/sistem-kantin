<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Tambahkan CSS dan JS yang diperlukan -->

    <link rel="stylesheet" href="{{asset('helper/css/toastr.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('helper/css/confirm.css')}}" type="text/css" />

    <style>
        .logo-img {
            width: 100px;
            /* Sesuaikan ukuran yang diinginkan */
            height: auto;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 16px solid;
            text-align: center;
            border-color: #461768;
            border-right-color: #0079C2;
            animation: s2 0.5s infinite linear;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -50px;
            /* Half of the spinner's height */
            margin-left: -50px;
            /* Half of the spinner's width */
        }

        @keyframes s2 {
            to {
                transform: rotate(1turn)
            }
        }
    </style>
</head>

<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>
    <!-- Konten lainnya -->
    <nav>
        @if(Session::has('user'))
        <p>Welcome, {{ Session::get('user')['username'] }}</p>
        @endif
        <!-- Menu lainnya -->
        <button id="button_id" onclick="do_logout('#button_id', '{{ route('logout') }}')">Logout</button>
    </nav>
    <!-- Konten lainnya -->

    <!-- Tambahkan jQuery jika belum ada -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Tambahkan toastr jika belum ada -->
    <script src="{{asset('helper/js/plugin.js')}}"></script>
    <script src="{{asset('helper/js/toastr.js')}}"></script>

</body>

</html>