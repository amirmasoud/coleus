<div class="card container" id="comment-form" v-if="show">
    <div class="card-body">
        <div class="col-md-8 offset-md-2 zero-padding">
            @include('flash::message')
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ route('comment') }}">
            {{ csrf_field() }}
            <input type="hidden" name="content_id" value="{{ $content->id }}">
            <div class="form-group text-right{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="password" class="col-md-2 col-xs-2 control-label">نام&zwnj;*</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required dir="auto">
            </div>

            <div class="form-group text-right{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-2 col-xs-2 control-label">ایمیل&zwnj;*</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required dir="ltr">
                <small class="form-text text-muted">پست الکترونیک شما منتشر نخواهد شد.</small>
            </div>

            <div class="form-group text-right{{ $errors->has('text') ? ' has-error' : '' }}">
                <label for="email" class="col-md-2 col-xs-2 control-label">دیدگاه&zwnj;*</label>
                <textarea id="text" class="form-control" name="text" rows="3" required dir="auto">{{ old('text') }}</textarea>
            </div>

            <div class="form-group text-right">
                <button type="submit" class="btn btn-outline-primary">
                    ارسال دیدگاه
                </button>
                <small class="text-muted pull-left">فیلدهای ستاره‌دار (*) الزامی است.</small>
            </div>
        </form>
    </div>
</div>
