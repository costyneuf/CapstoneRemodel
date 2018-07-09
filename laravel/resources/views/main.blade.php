<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>       
        @include('partials._header') 
    </head>
    <body>
        @include('partials._nav')
        <div class="container">
            <h1>Hello, <?php echo $_SERVER["HTTP_DISPLAYNAME"]; ?></h1> 
            <br><br>
            @yield('content')   
            <br><br><br>
            <input align = "left" type="button" value="Return" id="return" class='btn btn-md btn-success' onclick="goBack();">
            <script>function goBack() { window.history.back(); }</script>
            <script>
                if (window.location.pathname == "/")
                {
                    document.getElementById("return").style.visibility = "hidden";
                }
            </script>       
        </div>

        @include('partials._footer')
        
    </body>
</html>
