@extends('admin.includes.layout')
@section('header')
Comment
@endsection
@section('breadcrumb')
<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">Comment</li>
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
                @if (!$comments->isEmpty())
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Text</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($comments as $comment)
                        <tr onclick="window.document.location='{{ route('comments.edit', ['category' => $comment]) }}';" class="tr-hover">
                            <td>{{ $comment->name }}</td>
                            <td>{{ $comment->email }}</td>
                            <td>{{ $comment->text }}</td>
                            <td>{!! $comment->is_moderated ? '<span class="label label-success">Publish</span>' : '<span class="label label-warning">Pending</span>' !!}</td>
                            <td title="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</td>
                            <td title="{{ $comment->updated_at }}">{{ $comment->updated_at->diffForHumans() }}</td>
                            <td>@include('admin.comments.includes.delete', compact('comment'))</td>
                            {{ dd(\App\Models\Content::find($comment->content_id)->index) }}
                            <td><a href="{{ route('reads.show', []) }}"><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
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
            @include('admin.includes.pagination', ['resource' => $comments])
        </div>
    </div>
    <!-- /.box -->
</div>
</div>
@endsection
