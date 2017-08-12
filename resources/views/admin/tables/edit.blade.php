@extends('admin.includes.layout')
@section('header')
book
@endsection
@section('breadcrumb')
<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">Table</li>
@endsection
@section('content')
<div class="row">
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
@push('js')
<script src="{{ mix('admin/js/json-editor.js') }}"></script>
<script type="text/javascript">
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
