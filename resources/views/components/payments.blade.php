<div class="panel panel-default">
    <div class="panel-heading">اطلاعات پرداخت</div>
    <div class="panel-body">
        <table class="table table-responsive table-bordered">
            <thead>
                <tr>
                    <th>انجام شده</th>
                    <th>شماره ارجاع</th>
                    <th>جزییات</th>
                </tr>
            </thead>
            <tbody>
                @foreach(Auth::user()->payments as $payment)
                <tr>
                    <td>{{ $payment->created_at->diffForHumans() }}</td>
                    <td>{{ $payment->ref }}</td>
                    <td><pre>{{ print_r($payment->detail) }}</pre></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>