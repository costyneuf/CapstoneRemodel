<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>       
        <style>
            th {
                cursor: pointer;
            }

        </style>
        @include('partials._header') 
    </head>
    <body>
        @include('partials._nav')
        <div class="container">
            @yield('content')   
            <br><br><br>
            <input align = "left" type="button" value="Return" id="return" class='btn btn-md btn-success' onclick="goBack();">
            <script>function goBack() { window.history.back(); }</script>
            <script>
                if (window.location.pathname == "/" || window.location.pathname.includes("true"))
                {
                    document.getElementById("return").style.visibility = "hidden";
                }
            </script>       
        </div>

        @include('partials._footer')
        
    </body>
</html>
