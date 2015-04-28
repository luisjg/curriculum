<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ url('/') }}">
      	Curriculum
      </a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      @if(Auth::check())
      <ul class="nav navbar-nav">

        <li><a href="{{ url('/admin/courses') }}"><span class="glyphicon glyphicon-book"></span> Courses</a></li>

      </ul>
      @endif
      
      <ul class="nav navbar-nav navbar-right">
        @if (!Auth::check())
        <li><a href="{{ url('/auth/login') }}"><span class="glyphicon glyphicon-off"></span> Login</a></li>
        @else
        <li><p class="navbar-text">{{{ Auth::user()->individual->common_name }}}</p></li>
        <li><a href="{{ url('/auth/logout') }}"><span class="glyphicon glyphicon-off"></span> Logout</a></li>        
        @endif
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>