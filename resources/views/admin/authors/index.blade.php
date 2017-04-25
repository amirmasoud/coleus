@extends('admin.includes.layout')
@section('header')
Author
@endsection
@section('desc')
<a href="{{ route('authors.create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> New</a>
@endsection
@section('breadcrumb')
<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">Author</li>
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
                @if (!$authors->isEmpty())
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <th>name</th>
                            <th>age</th>
                            <th>extra</th>
                        </tr>
                        @foreach($authors as $author)
                        <tr onclick="window.document.location='{{ route('authors.edit', ['author' => $author]) }}';" class="tr-hover">
                            <td>{{ $author->name }}</td>
                            <td>{{ $author->age() }}</td>
                            @if($author->extra)
                            <td>
                                <table class="table table-striped table-responsive">
                                    @foreach($author->extra as $key => $value)
                                    <tbody>
                                        <tr>
                                            <td>{{ $key }}: {{ $value }}</td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                            </td>
                            @endif
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
                @include('admin.includes.pagination', ['resource' => $authors])
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection