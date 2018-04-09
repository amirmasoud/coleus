<div class="row">
    <div class="col">
        <a class="custom-navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}"
                alt="{{ config('app.name', 'Negar') }}"
                style="width: 45px;"
                data-toggle="tooltip"
                data-placement="bottom"
                title="{{ config('app.name', 'Negar') }}"
                data-pagespeed-no-transform/>
        </a>
    </div>
    <div class="col search-nav">
        <form action="#" method="GET">
            <div class="form-group">
                <search></search>
            </div>
        </form>
    </div>
</div>
