<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{$title ?? 'that_one_dev'}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Major+Mono+Display&amp;display=swap&family=Bebas+Neue&display=swap" rel="stylesheet">

        <style>
            :root {
                --base-hue-color: <?
                $rand = rand(0,360);
                while($rand <= 90 && $rand >= 30)
                    $rand = rand(0,360);
                echo $rand;
                ?>;
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
