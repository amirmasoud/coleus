@extends('layouts.blog')
@section('content')
<div class="row">
    <div class="panel-heading">ورود</div>
    <div class="col-md">
        <form role="form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="col-md-6 offset-md-3">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus dir="ltr">
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <label for="email" class="col-md-2 text-left-important control-label">رایانامه</label>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="col-md-4 offset-md-3">
                    <input id="password" type="password" class="form-control" name="password" required dir="ltr">
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <label for="password" class="col-md-2 text-left-important control-label">گذرواژه</label>
            </div>
            <div class="form-group">
                <div class="col-md-6 offset-md-3">
                    <div class="checkbox pull-right">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> مرا به خاطر بسپار
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default pull-left">
                    ورود
                    </button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 offset-md-3">
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        گذر واژه خود را فراموش کرده‌اید؟
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
