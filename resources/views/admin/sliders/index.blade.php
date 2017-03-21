@extends('admin.includes.layout')
@section('header')
Sliders
@endsection
@section('desc')
<a href="{{ route('sliders.create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> New</a>
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
                <h3 class="box-title">Sliders</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                @if (!$sliders->isEmpty())
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <th>Title</th>
                            <th>Sub-header</th>
                            <th>link</th>
                            <th>Image</th>
                        </tr>
                        @foreach($sliders as $slider)
                        <tr onclick="window.document.location='{{ route('sliders.edit', ['slider' => $slider]) }}';" class="tr-hover">
                            <td>{{ $slider->title }}</td>
                            <td>{{ $slider->sub }}</td>
                            <td><a href="{{ $slider->link }}">{{ $slider->link }}</a></td>
                            <td>{{ Html::image($slider->thumbnail(), 'slider thumbnail', ['class'=>'img-responsive']) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                @include('admin.components.empty')
                @endif
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                @include('admin.includes.pagination', ['resource' => $sliders])
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection