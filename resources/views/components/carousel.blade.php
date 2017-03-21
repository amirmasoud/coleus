<div class="panel panel-default">
    <div class="panel-body">
        <div class="owl-carousel owl-theme">
            @foreach($sliders as $slider)
            <div>
                {{ Html::image($slider->image(), $slider->title, ['class' => 'img-responsive']) }}
                <h1 class="text-center">{{ $slider->title }}</h1>
                <p class="text-center">{{ $slider->sub }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>