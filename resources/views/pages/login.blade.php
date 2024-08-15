<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>The Bright Learning Center || Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('/plugins/css/adminlte.css') }}">
    <link href="{{ asset('/plugins/vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/vendor/lightgallery/css/lightgallery.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/plugins/vendor/select2/css/select2.min.css') }}">
    <link href="{{ asset('/plugins/vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0;
            /* Ganti dengan warna yang diinginkan */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-center my-4">
            <h1 class="text-center">The Bright Learning Center</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control" id="email" placeholder="idan@arz.com"
                                    name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="password"
                                    name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('/plugins/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('/plugins/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('/plugins/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('/plugins/js/custom.min.js') }}"></script>
    <script src="{{ asset('/plugins/js/dlabnav-init.js') }}"></script>
    <script src="{{ asset('/plugins/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/plugins/js/plugins-init/datatables.init.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('/plugins/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('/plugins/vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/plugins/js/plugins-init/select2-init.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#loginForm').on('submit', function (e) {
                e.preventDefault();
                $('#email').remove('is-invalid');
                $('#password').remove('is-invalid');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{route("login-action")}}',
                    data: {
                        email: $('input[name="email"]').val(),
                        password: $('input[name="password"]').val(),
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            text: response.message,
                            showCloseButton: true,
                            confirmButtonText: 'Lanjutkan',
                        })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    window.location.replace('/');
                                }

                            });
                    },
                    error: function (xhr, status, error) {
                        $('#email').addClass('is-invalid');
                        $('#password').addClass('is-invalid');
                        Swal.fire({
                            icon: "error",
                            text: xhr.responseJSON.message,
                            showCloseButton: true,
                            confirmButtonText: 'Coba Lagi',
                        });
                    }
                })
            })
        })
    </script>
</body>

</html>