@extends('layouts.blog')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">ثبت نام</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <div class="col-md-6 col-md-offset-3">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus dir="auto">
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <label for="name" class="col-md-2 text-left-important control-label">نام</label>
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="col-md-6 col-md-offset-3">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required dir="ltr">
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <label for="email" class="col-md-2 text-left-important control-label">رایانامه</label>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="col-md-6 col-md-offset-3">
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
                <div class="col-md-6 col-md-offset-3">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required dir="ltr">
                </div>
                <label for="password-confirm" class="col-md-2 text-left-important control-label">تکرار گذرواژه</label>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-default">
                    ثبت نام
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection