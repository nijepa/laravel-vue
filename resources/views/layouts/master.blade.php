<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>DONAU - Belgrade</title>

        <link rel="stylesheet" href="/css/app.css">
    </head>

    <body class="hold-transition sidebar-mini">
        <div class="wrapper" id="app">
            <admin :user="{{auth()->user()->load('notifications')}}"></admin>
        </div>
<!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    @auth
        <script>
            window.user = @json(
            [
                'user'=> auth()->user()->load('notifications'),
                'roles'=>auth()->user()->roles,
                'permissions'=> auth()->user()->getAllPermissions()
            ]
            );
            {{--window.user = @json(auth()->user())--}}
        </script>
    @endauth

    <script src="/js/app.js"></script>

    </body>
</html>
