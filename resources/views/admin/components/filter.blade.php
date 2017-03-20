@php
$filters = Request::all();
@endphp
@foreach($filters as $filterKey => $filterValue)
    @php 
    if ($filterKey == 'date_range') $filterValue = str_replace('to', ' to ', $filterValue);
    if ($filterKey == 'orderby') 
        if($filterValue == 'asc') {
            $filterValue = 'Ascending';
        } else {
            $filterValue = 'Descending';
        }
    @endphp
    <span class="label label-primary"><b>{{ ucfirst(str_replace('_', ' ', $filterKey)) }}</b>: <i>{{ str_replace('_', ' ', $filterValue) }}</i></span>
@endforeach
