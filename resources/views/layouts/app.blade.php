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
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                    @yield('main')
                </main>
            </div>
        </div>
        @include('inc.bot')
        @yield('bot')
    </body>
</html>
