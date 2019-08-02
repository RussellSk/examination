<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TDIU Testing</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/offcanvas.css') }}" rel="stylesheet">
</head>

<body class="bg-light">
    <div id="app">
        <!-- Begin Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if (session('flash_success') || session('flash_error'))
                        @if (session('flash_success'))
                            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                <strong>Done!</strong> {{ session('flash_success') }}
                            </div>
                        @endif
                        @if (session('flash_error'))
                            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                <strong>Error!</strong> {{ session('flash_error') }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        @yield('content')

    </div>
    <!-- development version, includes helpful console warnings -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="{{ asset('/js/axios.min.js') }}"></script>
    <script src="{{ asset('/js/lodash.min.js') }}"></script>
    @yield('custom-script')
</body>
</html>