@extends('admin.includes.layout')
@section('header')
book
@endsection
@section('breadcrumb')
<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">Table</li>
@endsection
@section('content')
<div class="row" id="table">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">{{ $table->title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="table">
                {!! Form::model($table, ['method' => 'PATCH',
                                'action' => ['Admin\TableController@update', $table],
                                'class' => 'form-horizontal']) !!}
                    <div class="form-group">
                        {!! Form::label('title', 'Title: ', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('title', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('slug', 'Slug: ', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('slug', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('type', 'Type: ', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('type', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </div>
                    </div>
                {!!  Form::close() !!}
                @if (($table->isLeaf()))
                {!! Form::model($table->content, ['method' => 'PATCH',
                                'action' => ['Admin\ContentController@update', $table->content],
                                'class' => 'form-horizontal']) !!}
                    <div class="form-group">
                        {!! Form::label('slug', 'Slug: ', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('slug', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('order', 'Order: ', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('order', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('text', 'Text: ', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('text', json_encode($table->content->text), ['class' => 'form-control', 'dir' => 'auto']) !!}
                            <div id="editor_holder"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('html', 'HTML: ', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            <textarea id="summernote" name="html" class="form-control" dir="ltr">{!! $table->content->html !!}</textarea>
                            <!-- <div id="editor_holder"></div> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </div>
                    </div>
                {!!  Form::close() !!}
                @endif
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection
@push('style')
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.css" rel="stylesheet">
<style type="text/css">
    .m1, .m2 {
        width: 50%;
        display: inline-block;
        float: right;
    }
    .m1 {
        text-align: left;
        padding-left: 50px;
    }

    .m2 {
        text-align: right;
        padding-right: 50px;
        margin-bottom: 20px;
    }
    @media (max-width: 768px) {
        .m1, .m2 {
            text-align: center !important;
            width: 100%;
            padding-right: 0 !important;
            padding-left: 0 !important;
        }
    }
</style>
@endpush
@push('js')
<script src="{{ mix('admin/js/json-editor.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
$('#summernote').summernote({
  height: 300,
  minHeight: null,
  maxHeight: null,
  focus: true,
  toolbar: [
    ['style', ['bold', 'clear']],
    ['height', ['height']],
    ['misc', ['fullscreen', 'codeview', 'undo', 'redo', 'help']]
  ],
  disableDragAndDrop: true
});
    });
      var editor = new JSONEditor(document.getElementById('editor_holder'),{
        schema: {
          type: "object",
          title: "Car",
          properties: {
            make: {
              type: "string",
              enum: [
                "Toyota",
                "BMW",
                "Honda",
                "Ford",
                "Chevy",
                "VW"
              ]
            },
            model: {
              type: "string"
            },
            year: {
              type: "integer",
              enum: [
                1995,1996,1997,1998,1999,
                2000,2001,2002,2003,2004,
                2005,2006,2007,2008,2009,
                2010,2011,2012,2013,2014
              ],
              default: 2008
            }
          }
        }
      });
</script>
@endpush
