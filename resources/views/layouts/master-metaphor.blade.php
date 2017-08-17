<!DOCTYPE HTML>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
        <meta name="description" content="@yield('description')">
        <title>Curriculum Web Service</title>
        <link rel="icon" href="//www.csun.edu/sites/default/themes/csun/favicon.ico" type="image/x-icon" />
        {!! HTML::script('//use.typekit.net/gfb2mjm.js') !!}
        <script>try{Typekit.load();}catch(e){}</script>
        {!! HTML::style('//fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic') !!}
        {!! HTML::style('css/metaphor.css') !!}
        {!! Html::style('css/tomorrow.css.min') !!}
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
                    <div class="col-md-3" id="sidebar">
                        @include('layouts.partials.side-nav')
                    </div>
                    <div class="col-md-9" id="page">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        {{-- @include('layouts.partials.csun-footer') --}}
        @include('layouts.partials.metalab-footer')
        {!! HTML::script('js/metaphor.js') !!}
        {!! Html::script('js/run_prettify.js') !!}
    </body>
</html>