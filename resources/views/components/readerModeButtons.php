<button v-on:click="increaseFontSize()"
    class="btn btn-default"
    :disabled="fontSize >= 30"
    data-toggle="tooltip"
    data-placement="bottom"
    title="افزایش فونت">
  <i class="fa fa-plus" aria-hidden="true"></i>
</button>
<button v-on:click="decreaseFontSize()"
    class="btn btn-default"
    :disabled="fontSize <= 10"
    data-toggle="tooltip"
    data-placement="bottom"
    title="کاهش فونت">
    <i class="fa fa-minus" aria-hidden="true"></i>
</button>
<button v-on:click="increaseLineHeight()"
    class="btn btn-default"
    :disabled="lineHeight >= 4.1"
    data-toggle="tooltip"
    data-placement="bottom"
    title="کاهش فاصله بین سطرها">
    <i class="fa fa-expand fa-rotate-135" aria-hidden="true"></i>
</button>
<button v-on:click="decreaseLineHeight()"
    class="btn btn-default"
    :disabled="lineHeight <= 1.6"
    data-toggle="tooltip"
    data-placement="bottom"
    title="افزایش فاصله بین سطرها">
    <i class="fa fa-compress fa-rotate-135" aria-hidden="true"></i>
</button>
<button v-on:click="increaseWidth()"
    class="btn btn-default"
    :disabled="width >= 1140"
    data-toggle="tooltip"
    data-placement="bottom"
    title="افزایش عرض">
    <i class="fa fa-expand fa-rotate-45" aria-hidden="true"></i>
</button>
<button v-on:click="decreaseWidth()"
    class="btn btn-default"
    :disabled="width <= 500"
    data-toggle="tooltip"
    data-placement="bottom"
    title="کاهش عرض">
    <i class="fa fa-compress fa-rotate-45" aria-hidden="true"></i>
</button>
<button v-on:click="goDark()"
    class="btn btn-default dark-btn"
    :disabled="!sepia && dark"
    data-toggle="tooltip"
    data-placement="bottom"
    title="حالت مشکی">
    <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
</button>
<button v-on:click="goSepia()"
    class="btn btn-default speia-btn"
    :disabled="sepia && !dark"
    data-toggle="tooltip"
    data-placement="bottom"
    title="حالت زرد">
    <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
</button>
<button v-on:click="goLight()"
    class="btn btn-default light-btn"
    :disabled="!sepia && !dark"
    data-toggle="tooltip"
    data-placement="bottom"
    title="حالت روشن">
    <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
</button>
