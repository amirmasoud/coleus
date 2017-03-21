@extends('admin.includes.layout')
@section('header')
Sliders
@endsection
@section('desc')
Home page sliders
@endsection
@section('breadcrumb')
<li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
<li class="active">Slider</li>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                @if (!$sliders->isEmpty())
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <tr>
                                <th>Title</th>
                                <th>Sub-header</th>
                                <th>link</th>
                                <th>Image</th>
                            </tr>
                            @foreach($sliders as $slider)
                            <tr onclick="window.document.location='#';" class="tr-hover">
                                <td>{{ $slider->title }}</td>
                                <td>{{ $slider->sub }}</td>
                                <td>{{ $slider->link }}</td>
                                <td>{{ $slider->image }}</td>
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