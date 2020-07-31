<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#000">

        <title>{{$title ?? 'that_one_dev'}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Major+Mono+Display&amp;display=swap&family=Bebas+Neue&display=swap" rel="stylesheet">

        <style root>
            :root {
                --base-hue-color: {{$rand}};
                --total: 300;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height" id="app">
            @yield('body-content')
        </div>
        <script src="/js/app.js"></script>
    </body>
</html>
