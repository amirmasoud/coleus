@extends('admin.includes.layout')
@section('header')
Movement
@endsection
@section('desc')
@include('admin.movements.includes.delete', compact('movement'))
@endsection
@section('breadcrumb')
<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">Movement</li>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">{{ $movement->title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                {!! Form::model($movement, ['method' => 'PATCH',
                                'action' => ['Admin\MovementController@update', $movement],
                                'class' => 'form-horizontal']) !!}
                @include('admin.movements.includes.form')
                {!!  Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection