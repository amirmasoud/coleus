{!! Form::open(['action' => ['Admin\PublisherController@destroy', $publisher], 'method' => 'DELETE']) !!}
<button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> delete</button>
{!! Form::close() !!}