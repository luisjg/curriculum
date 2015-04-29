<!DOCTYPE HTML>
<html class="no-js" lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
        <meta name="description" content="@yield('description')">
        <title>Curriculum Web Service</title>
        <link rel="icon" href="{!! asset('favicon.png') !!}" type="image/x-icon">

        {!! HTML::style('css/wiki.css') !!}

    </head>

    <body>
        
        <div class="wrapper" id="content">
            <div class="container">
                <div class="row">

                    <div class="col-sm-2" id="sidebar">
                        <h2>Curriculum</h2><h4>Web Service</h4>
                        @yield('sidebar')
                    </div>

                    <div class="col-sm-9 col-sm-offset-3" id="page">
                        @yield('content')
                    </div>

                </div>
            </div>
        </div>


        {{-- APP SCRIPTS --}}
        {!! HTML::script('js/app.js') !!}
    

        <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>

    </body>

</html>