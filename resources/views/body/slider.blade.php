<div class="tp-banner-container" style="z-index: 1;">
    <div class="tp-banner">
        <ul>
            <!-- SLIDE  -->
            @forelse ($sliders as $slider)
                <li data-transition="fade" data-slotamount="7" data-masterspeed="1500">
                    <!-- MAIN IMAGE -->
                    <img data-bgposition="center" src="{{$slider}}" alt="slidebg1"
                        data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">
                    <!-- LAYERS -->
                </li>
                <!-- SLIDE  -->
            @empty
            @endforelse



        </ul>
    </div>
</div>
