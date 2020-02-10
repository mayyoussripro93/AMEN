<?php
if (!isset($seo)) {
    $seo = (object) array('seo_title' => $siteSetting->site_name, 'seo_description' => $siteSetting->site_name, 'seo_keywords' => $siteSetting->site_name, 'seo_other' => '');
}
?>
        <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ (session('localeDir', 'rtl'))}}" dir="{{ (session('localeDir', 'rtl'))}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{__($seo->seo_title) }}</title>
    <meta name="Description" content="{!! $seo->seo_description !!}">
    <meta name="Keywords" content="{!! $seo->seo_keywords !!}">
{!! $seo->seo_other !!}
<!-- Fav Icon -->
    <link rel="shortcut icon" href="{{asset('/')}}favicon.ico">
    <!-- Slider -->
    <link href="{{asset('/')}}js/revolution-slider/css/settings.css" rel="stylesheet">
    <!-- Owl carousel -->
    <link href="{{asset('/')}}css/owl.carousel.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="{{asset('/')}}css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('/')}}css/font-awesome.css" rel="stylesheet">
    <!-- Custom Style -->
    <link href="{{asset('/')}}css/main.css" rel="stylesheet">
@if((session('localeDir', 'rtl') == 'rtl'))
    <!-- Rtl Style -->
        <link href="{{asset('/')}}css/rtl-style.css" rel="stylesheet">
    @endif
    <link href="{{ asset('/') }}admin_assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/') }}admin_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
{{--    <link href="{{ asset('/') }}admin_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{{ asset('/') }}admin_assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{{ asset('/') }}admin_assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />--}}
    <link href="{{ asset('/') }}admin_assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/') }}admin_assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
{{--    current-used-calender--}}
    <link href="{{ asset('/') }}NewCalendar/daterangepicker.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}plugins/formvaliadtor/theme-default.min.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="{{asset('/')}}js/html5shiv.min.js"></script>
    <script src="{{asset('/')}}js/respond.min.js"></script>
    <![endif]-->
    @stack('styles')

    <style>
        #load{
            width:100%;
            height:100%;
            position:fixed;
            z-index:9999;
            /*background:url("https://www.creditmutuel.fr/cmne/fr/banques/webservices/nswr/images/loading.gif") no-repeat center center rgba(255,255,255,1)*/
            background: #f0f0f0;
            padding-top: 10%;
        }
        .loader {
            border: 5px solid #f0f0f0;
            border-radius: 50%;
            border-top: 5px solid #17ad68;
            border-bottom: 5px solid #17ad68;
            width: 50px;
            height: 50px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            margin: 15px auto;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<div id="load" class="text-center">
    <img src="{{ asset('/') }}images/amen_logo.png" width="150">
    <h5 style="color: #999;">{{__('Loading ...')}}</h5>
    <div class="loader"></div>
</div>
{{--<link href="https://cdn.rawgit.com/kbwood/calendars/2.1.0/dist/css/jquery.calendars.picker.css" rel="stylesheet"/>--}}
@yield('content')
<!-- Bootstrap's JavaScript -->
{{--<script src="{{asset('/')}}js/jquery-2.1.4.min.js"></script>--}}
<script src="{{asset('/')}}js/jquery-3.2.1.min.js" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" crossorigin="anonymous"></script>
<script src="{{asset('/')}}plugins/formvaliadtor/jquery.form-validator.min.js"></script>
<script src="{{asset('/')}}js/bootstrap.min.js"></script>
{{--<script src="{{asset('/')}}js/html2canvas.js"></script>--}}
{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>--}}
{{--<script src="https://cdn.rawgit.com/kbwood/calendars/2.1.0/dist/js/jquery.calendars.js"></script>--}}
{{--<script src="https://cdn.rawgit.com/kbwood/calendars/2.1.0/dist/js/jquery.calendars.plus.min.js"></script>--}}
{{--<script src="https://cdn.rawgit.com/kbwood/calendars/2.1.0/dist/js/jquery.plugin.min.js"></script>--}}
{{--<script src="https://cdn.rawgit.com/kbwood/calendars/2.1.0/dist/js/jquery.calendars.picker.js"></script>--}}
{{--<script src="https://cdn.rawgit.com/kbwood/calendars/2.1.0/dist/js/jquery.calendars.picker-ar.js"></script>--}}
{{--<script src="https://cdn.rawgit.com/kbwood/calendars/2.1.0/dist/js/jquery.calendars.lang.js"></script>--}}
{{--<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>--}}
{{--<script src="{{asset('/')}}js/jquery.calendars.islamic.js"></script>--}}





<!-- Owl carousel -->
<script src="{{asset('/')}}js/owl.carousel.js"></script>

{{--    current-used-calender--}}
<script type="text/javascript" src="{{ asset('/') }}NewCalendar/moment.min.js"></script>
<script type="text/javascript" src="{{ asset('/') }}NewCalendar/daterangepicker.min.js"></script>
<script src="{{ asset('/') }}admin_assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="{{ asset('/') }}admin_assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="{{ asset('/') }}admin_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
{{--<script src="{{ asset('/') }}admin_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>--}}
{{--<script type="text/javascript" src="{{ asset('/') }}admin_assets/global/plugins/bootstrap-datetimepicker/js/moment.js"></script>--}}

{{--<script type="text/javascript" src="{{ asset('/') }}admin_assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.ar.min.js" charset="UTF-8"></script>--}}
{{--<script type="text/javascript" src="{{ asset('/') }}admin_assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>--}}
<script src="{{ asset('/') }}admin_assets/global/plugins/Bootstrap-3-Typeahead/bootstrap3-typeahead.min.js" type="text/javascript"></script>
{{--<script src="{{ asset('/') }}admin_assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>--}}
<!-- END PAGE LEVEL PLUGINS -->

<script src="{{ asset('/') }}admin_assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="{{ asset('/') }}admin_assets/global/plugins/jquery.scrollTo.min.js" type="text/javascript"></script>
<!-- Revolution Slider -->
<script type="text/javascript" src="{{ asset('/') }}js/revolution-slider/js/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="{{ asset('/') }}js/revolution-slider/js/jquery.themepunch.revolution.min.js"></script>
{!! NoCaptcha::renderJs() !!}
@stack('scripts')
<!-- Custom js -->
<script src="{{asset('/')}}js/script.js"></script>

<script type="text/JavaScript">
    $(document).ready(function(){
        $(document).scrollTo('.has-error', 2000);
    });
    function showProcessingForm(btn_id){
        $("#"+btn_id).val( 'Processing .....' );
        $("#"+btn_id).attr('disabled','disabled');
    }
    $('textarea').keypress(function(e) {
        var tval = $('textarea').val(),
            tlength = tval.length,
            set = 1000,
            remain = parseInt(set - tlength);
        // $('#remaining_letters').text(remain);
        if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
            $('textarea').val((tval).substring(0, tlength - 1))
            $('#remaining_letters').text(' {{__('Text Exceed Valid Characters')}}');
        }
    })

        $.validate({
            form:'#studyModalForm',
            modules : 'file',
            addValidClassOnAll : true,
            errorMessagePosition : 'top', // Instead of 'inline' which is default
        });
    $('#studyModalForm').submit(function(){
        if($("#studyFormControlFile1").val()=='' && $("#studyFormControlFile2").val()=='' && $("#studyFormControlFile3").val()=='' && $("#studyFormControlFile4").val()=='')
        {
            alert('Set Inputs');
            return false;
        }
        else{
            $('button[type="submit"]').attr('disabled',true);
        }
    });

    $.validate({
        modules : 'file',
        addValidClassOnAll : true,
        errorMessagePosition : 'top' ,// Instead of 'inline' which is default
        validateOnBlur : false,
        showHelpOnFocus : false,
        addSuggestions : false,
        onSuccess : function() {
            $('button[type="submit"]').attr('disabled',true);
            $('input[type="submit"]').attr('disabled',true);
        },
    });
</script>

<!-- Loader -->
<script>
    document.onreadystatechange = function () {
      var state = document.readyState;

        if (state == 'interactive') {
            // document.getElementById('contents').style.visibility="hidden";
        } else if (state == 'complete') {
            setTimeout(function(){
                document.getElementById('interactive');
                document.getElementById('load').style.visibility="hidden";
                // document.getElementById('contents').style.visibility="visible";
            },1000);
        }
    }
</script>

<!-- Highlight Active Links -->
<script>
    $(document).ready(function () {
        // Open Sidebar Menu based on page URL
        window.addEventListener('load', function () {
            if (window.location.href.indexOf("employee-home") > -1) {
                $("#s-dash").addClass("active");
            }
            if (window.location.href.indexOf("employee-show") > -1) {
                $("#s-prof").addClass("active");
            }
            if (window.location.href.indexOf("projects-show") > -1) {
                $("#s-proj").addClass("active");
            }
            if (window.location.href.indexOf("project_detail") > -1) {
                $("#s-proj").addClass("active");
                $('.back-to-project').css('display','none');
            }
            if (window.location.href.indexOf("project_violations") > -1) {
                $("#s-proj").addClass("active");
            }
            if (window.location.href.indexOf("project_violation_detail") > -1) {
                $("#s-proj").addClass("active");
            }
            if (window.location.href.indexOf("employee-create") > -1) {
                $("#c-user").addClass("active");
            }
            if (window.location.href.indexOf("employee-employees") > -1) {
                $("#v-emp").addClass("active");
            }

            if (window.location.href.indexOf("posted-initiatives?Initiatives_type=Education") > -1) {
                $("#s-edu").addClass("active");
                $("#s-edu").parent(".sub-menu").addClass("in");
            }
            if ((window.location.href.indexOf("edit-front-initiatives") > -1) && (window.location.href.indexOf("?Initiatives_type=Education") > -1)) {
                $("#s-edu").addClass("active");
                $("#s-edu").parent(".sub-menu").addClass("in");
            }
            if (window.location.href.indexOf("posted-initiatives?Initiatives_type=Training") > -1) {
                $("#s-train").addClass("active");
                $("#s-train").parent(".sub-menu").addClass("in");
            }
            if ((window.location.href.indexOf("edit-front-initiatives") > -1) && (window.location.href.indexOf("?Initiatives_type=Training") > -1)) {
                $("#s-train").addClass("active");
                $("#s-train").parent(".sub-menu").addClass("in");
            }
            if (window.location.href.indexOf("posted-initiatives?Initiatives_type=Recruiting") > -1) {
                $("#s-recr").addClass("active");
                $("#s-recr").parent(".sub-menu").addClass("in");
            }
            if ((window.location.href.indexOf("edit-front-initiatives") > -1) && (window.location.href.indexOf("?Initiatives_type=Recruiting") > -1)) {
                $("#s-recr").addClass("active");
                $("#s-recr").parent(".sub-menu").addClass("in");
            }

            if (window.location.href.indexOf("create-project-form") > -1) {
                $("#c-proj").addClass("active");
            }
            if (window.location.href.indexOf("new-employees-view") > -1) {
                $("#s-users").addClass("active");
            }
            if (window.location.href.indexOf("projects.for.evaluation") > -1) {
                $("#c-evalu").addClass("active");
            }
            if (window.location.href.indexOf("project.staff.evaluation") > -1) {
                $("#c-evalu").addClass("active");
            }
            if (window.location.href.indexOf("events_create") > -1) {
                $("#c-event").addClass("active");
            }
            if (window.location.href.indexOf("employee.evaluation.all") > -1) {
                $("#all-evalu").addClass("active");
            }
            if (window.location.href.indexOf("employee.evaluation.show") > -1) {
                $("#s-evalu").addClass("active");
            }


            if (window.location.href.indexOf("post-initiatives?Initiatives_type=Education") > -1) {
                $("#c-edu").addClass("active");
                $("#c-edu").parent(".sub-menu").addClass("in");
            }
            if (window.location.href.indexOf("post-initiatives?Initiatives_type=Training") > -1) {
                $("#c-train").addClass("active");
                $("#c-train").parent(".sub-menu").addClass("in");
            }
            if (window.location.href.indexOf("post-initiatives?Initiatives_type=Recruiting") > -1) {
                $("#c-recr").addClass("active");
                $("#c-recr").parent(".sub-menu").addClass("in");
            }

            if (window.location.href.indexOf("events-users") > -1) {
                $("#s-event").addClass("active");
            }
            if (window.location.href.indexOf("employee-messages") > -1) {
                $("#s-mess").addClass("active");
            }
            if (window.location.href.indexOf("employee-contacts") > -1) {
                $("#s-cont").addClass("active");
            }
            if (window.location.href.indexOf("report-abuse-company") > -1) {
                $("#s-abuse").addClass("active");
            }
            if (window.location.href.indexOf("employee-delete-account") > -1) {
                $("#s-delete").addClass("active");
            }
        });
    })
</script>


</body>
</html>
