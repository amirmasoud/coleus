@php 
parse_str(isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '', $query) 
@endphp
<div class="text-center">
{{ $resource->appends($query)->links() }}
</div>
