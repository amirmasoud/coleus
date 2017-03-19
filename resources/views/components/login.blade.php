<div class="panel panel-default">
    <div class="panel-heading">ورود</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="col-md-8">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <label for="email" class="col-md-4 control-label">پست الکترونیکی</label>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="col-md-8">
                    <input id="password" type="password" class="form-control" name="password" required>
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>

                <label for="password" class="col-md-4 control-label">رمز عبور</label>
            </div>
            <div class="form-group">
                <div class="col-md-8">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> من را فراموش نکن
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                    ورود
                    </button>
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        رمز عبور خود را فراموش کرده اید؟
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>