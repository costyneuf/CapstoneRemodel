<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>       
        @include('partials._header') 
    </head>
    <body>
        @include('partials._nav')
        <div class="container"> 
            @yield('content')          
        </div>
        @include('partials._footer')
    </body>
</html>
