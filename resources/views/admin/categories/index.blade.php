@extends('admin.includes.layout')
@section('header')
Category
@endsection
@section('desc')
<a href="{{ route('categories.create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> New</a>
@endsection
@section('breadcrumb')
<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">Category</li>
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
                @if (!$categories->isEmpty())
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Children</th>
                            <th>Thumbnail</th>
                        </tr>
                        @foreach($categories as $category)
                        <tr onclick="window.document.location='{{ route('categories.edit', ['category' => $category]) }}';" class="tr-hover">
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                @unless($category->children()->get()->isEmpty())
                                @foreach($category->children()->get() as $category)
                                <p>
                                <a href="{{ route('categories.edit', ['category' => $category]) }}">
                                    {{ $category->name }}
                                </a>
                                </p>
                                @endforeach
                                @endunless
                            </td>
                            <td>{{ Html::image($category->thumbnail(), 'slider',['class' => 'img-responsive']) }}</td>
                        </tr>
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
            @include('admin.includes.pagination', ['resource' => $categories])
        </div>
    </div>
    <!-- /.box -->
</div>
</div>
@endsection