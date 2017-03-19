<div class="panel panel-default">
    <div class="panel-heading">خرید اکانت</div>
    <div class="panel-body">
        <form class="form-horizontal" action="{{ route('pay', ['product' => $product]) }}" method="get">
            <div class="form-group">
                <div class="col-sm-9">
                    <select class="form-control" id="inputEmail3">
                        <option>درگاه شتاب</option>
                    </select>
                </div>
                <label for="inputEmail3" class="col-sm-3 control-label">درگاه بانک</label>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">پرداخت</button>
                </div>
            </div>
        </form>
    </div>
</div>