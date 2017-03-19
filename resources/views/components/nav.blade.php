<div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'Negarin') }}
    </a>
</div>
<div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <li class="#"><a href="{{ route('login') }}">Login</a></li>
        <li class="#"><a href="{{ route('register') }}">Register</a></li>
    </ul>
</div>