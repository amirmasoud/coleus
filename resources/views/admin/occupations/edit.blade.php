@extends('admin.includes.layout')
@section('header')
occupation
@endsection
@section('desc')
@include('admin.occupations.includes.delete', compact('occupation'))
@endsection
@section('breadcrumb')
<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">occupation</li>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">{{ $occupation->title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                {!! Form::model($occupation, ['method' => 'PATCH',
                                'action' => ['Admin\OccupationController@update', $occupation],
                                'class' => 'form-horizontal']) !!}
                @include('admin.occupations.includes.form')
                {!!  Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection