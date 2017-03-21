{!! Form::open(['action' => ['Admin\SliderController@destroy', $slider], 'method' => 'DELETE']) !!}
<button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> delete</button>
{!! Form::close() !!}