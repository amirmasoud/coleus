<div class="panel panel-default">
    <div class="panel-heading">ثبت نام</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="col-md-6 col-md-offset-2">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <label for="email" class="col-md-2 control-label text-left">پست الکترونیکی</label>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="col-md-6 col-md-offset-2">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <label for="password" class="col-md-2 control-label">رمز عبور</label>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-2">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>

                <label for="password-confirm" class="col-md-2 control-label">تکرار رمز عبور</label>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-2">
                    <button type="submit" class="btn btn-primary">
                        ثبت نام
                    </button>
                    <a class="btn btn-link" href="{{ route('login') }}">
                        حساب کاربری دارید؟
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>