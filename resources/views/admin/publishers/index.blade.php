@extends('admin.includes.layout')
@section('header')
Publisher
@endsection
@section('desc')
<a href="{{ route('publishers.create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> New</a>
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
                <h3 class="box-title">List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                @if (!$publishers->isEmpty())
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <th>name</th>
                            <th>URL</th>
                        </tr>
                        @foreach($publishers as $publisher)
                        <tr onclick="window.document.location='{{ route('publishers.edit', ['publisher' => $publisher]) }}';" class="tr-hover">
                            <td>{{ $publisher->name }}</td>
                            <td>{{ $publisher->url }}</td>
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
                @include('admin.includes.pagination', ['resource' => $publishers])
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection