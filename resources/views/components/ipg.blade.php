@if (isset($message))
@component('components.message')
@slot('title')
    خطا
@endslot
<p class="text-center">{{ $message }}</p>
@endcomponent
@else
@include('components.account', compact('account'))
<div class="panel panel-default">
    <div class="panel-heading">نتیجه تراکنش</div>
    <div class="panel-body">
    <table class="table table-bordered table-striped">
        <tbody>
            @if ($response->State == 'OK')
            <tr>
                <th>نتیجه</th>
                <td><spna class="label label-success">موفق</spna></td>
            </tr>
            <tr>
                <th>شماره ارجاع</th>
                <td>{{ $response->RefNum }}</td>
            </tr>
            <tr>
                <th>شماره پیگیری</th>
                <td>{{ $response->TraceNo }}</td>
            </tr>
            <tr>
                <th>شماره پیگیری مشتری</th>
                <td>{{ $response->CustomerRefNum }}</td>
            </tr>
            <tr>
                <th>مبلغ</th>
                <td>{{ number_format($response->transactionAmount) }} ریال</td>
            </tr>
            @else
            <tr>
                <th>نتیجه</th>
                <td><spna class="label label-danger">{{ $response->State }}</spna></td>
            </tr>
            <tr>
                <th>شماره رزرو</th>
                <td>{!! $response->RefNum or '<span class="badge"> بدون مقدار </span>' !!}</td>
            </tr>
            @endif
        </tbody>
    </table>
    </div>
</div>
@endif