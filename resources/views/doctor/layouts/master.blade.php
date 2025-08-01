<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ config('settings.site_name') }} | {{ trans('messages.doctor') }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset(config('settings.favicon')) }}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">

    <!-- DataTable CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/2.0.1/css/select.dataTables.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <!-- Start GA -->

    <style>
        :root {
            --primary: {{ config('settings.site_color') }};
        }

        .active-lang {
            font-weight: bold !important;
            color: {{ config('settings.site_color') }};
            /* Bootstrap primary color for example */
        }

        .activities {
            word-wrap: break-word;
            /* Ensures long words or URLs break and wrap to the next line */
        }

        .activity-detail p {
            word-break: break-word;
            /* Ensures long words within paragraphs break and wrap to the next line */
        }

        .activity-detail {
            overflow-wrap: break-word;
            /* Ensures the activity details do not overflow and wrap properly */
        }

        /* Ensures the select dropdown does not exceed the page width on smaller screens */
        .select2-container {
            width: 100% !important;
        }

        /* Additional styling to ensure proper word wrapping within the select options */
        .select2-selection__rendered {
            white-space: normal !important;
            word-wrap: break-word !important;
        }
    </style>

    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        var pusherKey = "{{ config('settings.pusher_key') }}";
        var pusherCluster = "{{ config('settings.pusher_cluster') }}";
        var loggedInUserId = "{{ auth()->user()->id }}";
    </script>
    <!-- /END GA -->
    @vite(['resources/js/app.js', 'resources/js/doctor.js'])
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">

            <!-- Navbar -->
            @include('doctor.layouts.navbar')

            <!-- Sidebar -->
            @include('doctor.layouts.sidebar')

            <!-- Main Content -->
            <div class="main-content">

                @if ($errors->any())
                    <div class="container mt-3">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>


            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2024
                </div>
                <div class="footer-right">

                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Datatable Specific JS File -->
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> --}}
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.1/js/dataTables.select.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.1/js/select.dataTables.js"></script>

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- Toastr JS  -->
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>

    <!-- Toastr Error  -->
    {{-- <script>
        toastr.options.closeButton = true;

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script> --}}

    @stack('scripts')
</body>

</html>
