@if ( $errors->any() )
<div class="alert alert-important alert-warning">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Oops!</strong>
    <ul>
        @foreach ( $errors->all() as $error )
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif