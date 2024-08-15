<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <title>Login</title>

    <!-- Menggunakan jalur absolut untuk asset CSS -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
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

    <link rel="stylesheet" href="{{asset('helper/css/toastr.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('helper/css/confirm.css')}}" type="text/css" />
</head>

<body>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100 justify-content-center align-items-center">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-body">
                            <form id="form_id">
                                <div class="text-center mb-4">
                                    <h1 class="h2">{{ env('APP_NAME') }}</h1>
                                    <img src="{{ asset('assets/images/del2.png') }}" alt="Logo with text 'del'"
                                        class="logo-img">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input class="form-control form-control-lg" type="text" name="username"
                                        placeholder="Enter your Username" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input class="form-control form-control-lg" type="password" name="password"
                                        placeholder="Enter your password" />
                                </div>
                                <div class="d-grid gap-2 mt-3">
                                    <button type="submit" class="btn btn-lg btn-primary" id="button_id"
                                        onclick="do_login('#form_id','#button_id','{{ route('do_login')}}','POST');">Sign
                                        in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="{{asset('helper/js/plugin.js')}}"></script>
    <script src="{{asset('helper/js/toastr.js')}}"></script>
</body>

</html>