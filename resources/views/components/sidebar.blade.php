<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading">مزایا</div>
        <div class="panel-body">
            <ul>
                <li>بیش از ۲۰۰ سرور در کشورهای مختلف</li>
                <li>قابلیت اتصال همزمان از ۲ سیستم</li>
                <li>همراه با سرویس جدید Next VPN</li>
                <li>همراه با سرویس جدید Cisco</li>
                <li>همراه با سرویس جدید Kerio</li>
                <li>همراه با سرویس جدید Open VPN</li>
                <li>پورت های PPTP و L2TP و SSTP</li>
                <li>encryption یا رمز گذاری ۲۵۶ بیتی</li>
                <li>سرعت و کیفیت بالا</li>
                <li>پشتیبانی حرفه ای</li>
                <li>تعرفه ها</li>
            </ul>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">تعرفه ها</div>
        <div class="panel-body">
            @foreach($products as $product)
            <p>{{ $product->month }} (۲ کاربره): <b>{{ $product->price }}</b> ریال</p>
            @endforeach
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">آدرس و اخبار جدید</div>
        <div class="panel-body">
            <a class="btn btn-link social-links" href="#" role="button"><i class="fa fa-telegram telegram-color" aria-hidden="true"></i> تلگرام</a>
            <a class="btn btn-link social-links" href="#" role="button"><i class="fa fa-skype skype-color" aria-hidden="true"></i> اسکایپ</a>
        </div>
    </div>
</div>