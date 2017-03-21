@extends('admin.includes.layout')
@section('header')
Sliders
@endsection
@section('desc')
@include('admin.sliders.includes.delete', compact('slider'))
@endsection
@section('breadcrumb')
<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">Slider</li>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">{{ $slider->title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                {{ Html::image($slider->image(), 'slider',['class' => 'img-responsive center-block', 'width' => '800']) }}
                <hr>
                {!! Form::model($slider, ['method' => 'PATCH',
                                'action' => ['Admin\SliderController@update', $slider],
                                'class' => 'form-horizontal',
                                'files' => true]) !!}
                @include('admin.sliders.includes.form')
                {!!  Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection