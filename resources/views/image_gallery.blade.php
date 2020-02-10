@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <div class="listpgWraper">
    @php $number_of_element=6;@endphp
    <!-- Header end -->
        @if($images_count>0 )
            <h3 class="green-color text-center">{{__('Images Gallery')}}</h3>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="container">
                            <div class="content">
                                @php $v=1 @endphp
                                @foreach($images as $image)

                                    <a class="elem"
                                       href="{{$storage_url}}amen_home_page_media/{{$image->media_type}}/{{$image->upload_file}}"
                                       title="{{$image->title}}">
                                        <span style="background-image: url({{$storage_url}}amen_home_page_media/{{$image->media_type}}/{{$image->upload_file}});"></span>
                                    </a>

                                    @if($v>1 && fmod($v,$number_of_element)==0  && $v<$images_count)
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class='container'>
                            <div class="content">
                                @endif
                                @if($v==$images_count)
                            </div>
                        </div>
                    </div>
                    @endif
                    @php $v++ @endphp
                    @endforeach


                </div>
            @if($images_count > $number_of_element)
                <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                @endif
            </div>
        @else
            <div class="col-md-6 col-md-offset-3">
                <div class="userccount">
                    <div class="text-center">
                        <img src="../images/amen_logo.png" alt="Amen" height="120">
                        <h4 class="green-color text-center" style="margin: 10px auto;"><i class="fa fa-info-circle"
                                                                                          aria-hidden="true"></i> {{__('No Results!!')}}
                        </h4>
                        <p style="color: #999;"> {{__('No images uploaded in this section.')}}</p>
                        <div class="newuser"><a href="/"><i class="fa fa-arrow-circle-right"
                                                            aria-hidden="true"></i> {{__('Home')}}</a></div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @include('includes.footer')
@endsection
@push('styles')
    <style type="text/css">
        .elem, .elem * {
            box-sizing: border-box;
            margin: 0 !important;
        }

        .elem {
            display: inline-block;
            font-size: 0;
            width: 33%;
            border: 20px solid transparent;
            border-bottom: none;
            background: #fff;
            padding: 10px;
            height: auto;
            background-clip: padding-box;
        }

        .elem > span {
            display: block;
            cursor: pointer;
            height: 0;
            padding-bottom: 70%;
            background-size: cover;
            background-position: center center;
        }
    </style>
    <style type="text/css">
        .lcl_fade_oc.lcl_pre_show #lcl_overlay,
        .lcl_fade_oc.lcl_pre_show #lcl_window,
        .lcl_fade_oc.lcl_is_closing #lcl_overlay,
        .lcl_fade_oc.lcl_is_closing #lcl_window {
            opacity: 0 !important;
        }

        .lcl_fade_oc.lcl_is_closing #lcl_overlay {
            -webkit-transition-delay: .15s !important;
            transition-delay: .15s !important;
        }
    </style>
    {{--    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">--}}
    <link rel="stylesheet" href="{{ asset('/') }}admin_assets/galleryPopUp/css/lc_lightbox.css"/>

    <!-- SKINS -->
    <link rel="stylesheet" href="{{ asset('/') }}admin_assets/galleryPopUp/skins/light.css"/>
@endpush
@push('scripts')

    {{--    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" crossorigin="anonymous"></script>--}}
    <script src="{{ asset('/') }}admin_assets/galleryPopUp/js/lc_lightbox.lite.js" type="text/javascript"></script>
    <!-- ASSETS -->
    <script src="{{ asset('/') }}admin_assets/galleryPopUp/lib/AlloyFinger/alloy_finger.min.js"
            type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function (e) {

            // live handler
            lc_lightbox('.elem', {
                wrap_class: 'lcl_fade_oc',
                gallery: true,
                thumb_attr: 'data-lcl-thumb',

                skin: 'light',
                radius: 0,
                padding: 0,
                border_w: 0,
            });

        });
        lc_lightbox('.elem', {

            // whether to display a single element or compose a gallery
            gallery: false,

            // attribute grouping elements - use false to create a gallery with all fetched elements
            gallery_hook: 'rel',

            // if a selector is found, set true to handle automatically DOM changes
            live_elements: true,

            // whether to preload all images on document ready
            preload_all: false,

            // force elements type
            global_type: 'image',

            // attribute containing element's source
            src_attr: 'href',

            // attribute containing the title - is possible to specify a selector with this syntax: "> .selector" or "> span"
            title_attr: 'title',

            // attribute containing the description - is possible to specify a selector with this syntax: "> .selector" or "> span"
            txt_attr: 'data-lcl-txt',

            // attribute containing the author - is possible to specify a selector with this syntax: "> .selector" or "> span"
            author_attr: 'data-lcl-author',

            // whether to enable slideshow
            slideshow: true,

            // animation duration for lightbox opening and closing / 1000 = 1sec
            open_close_time: 500,

            // overlay's animation advance (on opening) and delay (on close) to window / 1000 = sec
            ol_time_diff: 100,

            // elements fading animation duration in millisecods / 1000 = 1sec
            fading_time: 150,

            // sizing animation duration in millisecods / 1000 = 1sec
            animation_time: 300,

            // slideshow interval duration in milliseconds / 1000 = 1sec
            slideshow_time: 6000,

            // autoplay slideshow - bool
            autoplay: false,

            // whether to display elements counter
            counter: false,

            // whether to display a progressbar when slideshow runs
            progressbar: true,

            // whether to create a non-stop pagination cycling elements
            carousel: true,

            // Lightbox maximum width.
            // Use a responsive percent value or an integer for static pixel value
            max_width: '93%',

            // Lightbox maximum height.
            // Use a responsive percent value or an integer for static pixel value
            max_height: '93%',

            // overlay opacity / value between 0 and 1
            ol_opacity: 0.7,

            // background color of the overlay
            ol_color: '#111',

            // overlay patterns - insert the pattern name or false
            ol_pattern: false,

            // width of the lightbox border in pixels
            border_w: 3,

            // color of the lightbox border
            border_col: '#ddd',

            // width of the lightbox padding in pixels
            padding: 10,

            // lightbox border radius in pixels
            radius: 4,

            // whether to apply a shadow around lightbox window
            shadow: true,

            // whether to hide page's vertical scroller
            remove_scrollbar: true,

            // custom classes added to wrapper - for custom styling/tracking
            wrap_class: '',

            // light / dark / Minimal
            skin: 'light',

            // over / under / lside / rside
            data_position: 'over',

            // inner / outer
            cmd_position: 'inner',

            // set closing button position for inner commands - normal/corner
            ins_close_pos: 'normal',

            // set arrows and play/pause position - normal/middle
            nav_btn_pos: 'normal',

            // whether to hide texts on lightbox opening - bool or int (related to browser's smaller side)
            txt_hidden: 500,

            // bool / whether to display titles
            show_title: true,

            // bool / whether to display descriptions
            show_descr: true,

            // bool / whether to display authors
            show_author: true,

            // enables thumbnails navigation (requires elements poster or images)
            thumbs_nav: true,

            // print type icons on thumbs if types are mixed
            tn_icons: true,

            // whether to hide thumbs nav on lightbox opening - bool or int (related to browser's smaller side)
            tn_hidden: 500,

            // width of the thumbs for the standard lightbox
            thumbs_w: 110,

            // height of the thumbs for the standard lightbox
            thumbs_h: 110,

            // attribute containing thumb URL to use or false to use thumbs maker
            thumb_attr: false,

            // script baseurl to create thumbnails (use src=%URL% w=%W% h=%H%)
            thumbs_maker_url: false,

            // Allow the user to expand a resized image. true/false
            fullscreen: true,

            // resize mode of the fullscreen image - smart/fit/fill
            fs_img_behavior: 'fit',

            // when directly open in fullscreen mode - bool or int (related to browser's smaller side)
            fs_only: 500,

            // whether to trigger or nor browser fullscreen mode
            browser_fs_mode: true,

            // bool
            socials: true,

            // use a specific string representing URL parameters + placeholders (they will be replaced by the lightbox)
            // it requires a server-side script handling those parameters and filling the page with <a href="https://www.jqueryscript.net/tags.php?/Facebook/">Facebook</a> Metadata.
            // a usage example could be: app_id=YOUR-APP-ID&redirect_uri=THE-REDIRECT-URI&lcsism_img=%IMG%&lcsism_title=%TITLE%&lcsism_descr=%DESCR%
            // the lightbox will replace %IMG% %TITLE% and %DESCR%
            fb_share_params: false,

            // bool / allow text hiding
            txt_toggle_cmd: true,

            // bool / whether to add download button
            download: true,

            // bool / Allow touch interactions for mobile (requires AlloyFinger)
            touchswipe: true,

            // bool / Allow elements navigation with mousewheel
            mousewheel: true,

            // enable modal mode (no closing on overlay click)
            modal: false,

            // whether to avoid right click on lightbox
            rclick_prevent: false

        });
    </script>
@endpush