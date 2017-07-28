@extends('admin.includes.layout')
@section('header')
publisher
@endsection
@section('desc')
@include('admin.publishers.includes.delete', compact('publisher'))
@endsection
@section('breadcrumb')
<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">Publisher</li>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">{{ $publisher->name }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="publisher">
                {!! Form::model($publisher, ['method' => 'PATCH',
                                'action' => ['Admin\PublisherController@update', $publisher],
                                'class' => 'form-horizontal']) !!}
                @include('admin.publishers.includes.form')
                {!!  Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection
