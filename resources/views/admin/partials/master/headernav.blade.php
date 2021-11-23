<nav class="navbar navbar-default navbar-fixed">
    <div class="container-fluid">
         <a class="navbar-brand" href="{{ url('/') }}">
                    {{ str_replace('_', ' ',config('app.name', 'SMS Campaign')) }}
                </a>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <p>
								{{ Auth::user()->name }}
								<b class="caret"></b>
							</p>

                      </a>
                      <ul class="dropdown-menu">
                        <li><a href="{{ route('signout') }}">Logout</a></li>
                      </ul>
                </li>
				<li class="separator hidden-lg"></li>
            </ul>
        </div>
    </div>
</nav>