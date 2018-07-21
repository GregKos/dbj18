<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('inc.head')
        @yield('head')
    </head>
    <body>
        @include('inc.top')
        @yield('top')
        <div class="container-fluid">
            <div class="row">
                @include('inc.left')
                @yield('main')
            </div>
        </div>
        @include('inc.bot')
        @yield('bot')
    </body>
</html>
