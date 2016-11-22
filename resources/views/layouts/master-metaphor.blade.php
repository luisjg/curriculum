<!DOCTYPE HTML>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
        <meta name="description" content="@yield('description')">
        <title>Curriculum Web Service</title>
        <link rel="icon" href="{!! asset('favicon.png') !!}" type="image/png">
        <link rel="icon" href="{!! asset('favicon.ico') !!}" type="image/x-icon">
        {!! HTML::script('https://use.typekit.net/gfb2mjm.js') !!}
        {!! HTML::style('https://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic') !!}
        {!! HTML::style('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css') !!}
        {!! HTML::style('css/metaphor.css') !!}
        {!! Html::style('css/tomorrow.min.css') !!}
        <style type="text/css">
            .metalab-footer .metalab-branding img {
              width: 110px; }
        </style>
    </head>
    <body>
        <div class="section section--sm">
          <div class="container type--center">
            <h1 class="giga type--thin">Curriculum Web Service</h1>
            <h3 class="h1 type--thin type--gray">Delivering CSUN course information</h3>
          </div>
        </div>
        <div class="section" id="menu">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3" id="sidebar">
                        @include('layouts.partials.side-nav')
                    </div>
                    <div class="col-sm-9" id="page">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        {{-- @include('layouts.partials.csun-footer') --}}
        @include('layouts.partials.metalab-footer')
        <script>try{Typekit.load();}catch(e){}</script>
        {!! HTML::script('js/metaphor.js') !!}
        {!! Html::script('https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js') !!}
    </body>
</html>