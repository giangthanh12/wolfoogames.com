<div class='footer_wrapper_copyright'>
    <!-- canvas -->
    <div class='half_sin_wrapper'>
        <canvas class='half_sin' data-bg-color='23,108,129' data-line-color='23,108,129'></canvas>
    </div>
    <!-- / canvas -->
    <footer class='page_footer'>
        <div class='container'>
            <div class='footer_container'>
                <!-- widget post -->
                <div class="cws-widget">
                    <div class="widget-title">Our Channels</div>
                    <div class='widget_carousel'>
                        <div class='item'>
                            @foreach (\App\Models\Channel::show_channel_footer() as $channel)
                            @php
                            $title = json_decode($channel->title, true);
                            @endphp

                                <!-- post item -->
                                <div class='post_item'>
                                    <div class='post_preview clearfix'>
                                        <a href='{{$channel->link}}' class='post_thumb_wrapp pic'>
                                            <img class='post_thumb' width="50" src='{{asset($channel->image)}}' style="height:50px"  alt />
                                        </a>
                                        <div class='post_title'><a href='{{$channel->link}}'>{{ array_key_exists('en', $title) ? $title['en'] : '' }}</a></div>
                                        <div class='post_content'>
                                            <a href="{{$channel->link}}" style="color: #fff;"><i class="fa fa-arrow-right"></i> Link to my channel</a>
                                        </div>

                                    </div>
                                </div>
                                <!-- / post item -->
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- / widget post -->


                <!-- conatact form -->
                <div class="cws-widget">
                    <div class="widget-title">Shoot a Message</div>
                    <div class="textwidget">
                        <div role="form" class="cf" id="cf-f1705-o1" lang="en-US" dir="ltr">
                            <!-- <div class="screen-reader-response"></div> -->
                            {{-- id="form-lh" --}}
                            <form action="{{route("send-message")}}" method="post" class="" id="form-lh">
                               @csrf
                                <p><span style="width:100%" class="cf-form-control-wrap your-name"><input type="text" name="name" value="" placeholder="Name" /></span></p>
                                <p><span style="width:100%" class="cf-form-control-wrap your-email"><input type="email" name="email" value=""  placeholder="E-mail" /></span></p>
                                <p><span style="width:100%" class="cf-form-control-wrap your-message"><textarea name="message" cols="39" rows="6"  placeholder="Message"></textarea></span></p>
                                <p>
                                    <input type="submit" value="Send" class="cf-form-control cf-submit" />
                                </p>
                            </form>
                            <div class="email_server_responce"></div>
                        </div>
                    </div>
                </div>
                <!-- / contact form -->
            </div>
        </div>
    </footer>
    <!-- copyright -->

    <!-- / copyright -->
</div>
<style>
    #form-lh textarea.error {
        border-color: #ff6766;
    }
    #form-lh input.error {
        border-color: #ff6766;
    }
   .error {
        color:#ff6766 !important;
    }
 </style>
  <script src="{{asset("plugins/toastr/toastr.min.js")}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
         if(jQuery('.tp-banner').length >0) {
            jQuery('.tp-banner').revolution(
            {
                delay:9000,
                startwidth:1170,
                startheight:500,
                hideThumbs:10
            });
         }


          jQuery('#form-lh').validate({
        rules: {
            name: {
                required: true,
                maxlength:255
            },
            email: {
                required: true,
                email: true
            },
            message: {
                required: true,
                maxlength:255
            }
        },

    submitHandler: function(form) {
        jQuery.post('{{ route("send-message") }}', jQuery(form).serialize(), function(response) {
            console.log("ok");
             toastr.success(response.message);
             form.reset();
        });
    }
    });

    });
 </script>
