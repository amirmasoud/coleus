<transition name="fade">
<div class="panel panel-default" id="comment-form" v-if="show">
    <div class="panel-body">
        <div class="col-md-8 col-md-offset-2 zero-padding">
            @include('flash::message')
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ route('comment') }}">
            {{ csrf_field() }}
            <input type="hidden" name="content_id" value="{{ $content->id }}">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <div class="col-md-6 col-md-offset-2 col-xs-10">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required dir="auto">
                </div>
                <label for="password" class="col-md-2 col-xs-2 control-label">نام&zwnj;*</label>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="col-md-6 col-md-offset-2 col-xs-10">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required dir="ltr">
                    <span class="help-block">پست الکترونیک شما منتشر نخواهد شد.</span>
                </div>
                <label for="email" class="col-md-2 col-xs-2 control-label">ایمیل&zwnj;*</label>
            </div>

            <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                <div class="col-md-6 col-md-offset-2 col-xs-10">
                    <textarea id="text" class="form-control" name="text" rows="3" required dir="auto">{{ old('text') }}</textarea>
                </div>
                <label for="email" class="col-md-2 col-xs-2 control-label">دیدگاه&zwnj;*</label>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-2 col-xs-10">
                    <button type="submit" class="btn btn-primary">
                        ارسال دیدگاه
                    </button>
                    <span class="help-block pull-left">فیلدهای ستاره‌دار (*) الزامی است.</span>
                </div>
            </div>
        </form>
    </div>
</div>
</transition>
