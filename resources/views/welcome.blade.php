@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end -->
<!-- Search start -->
{{--@include('includes.search')--}}
<!-- Search End -->
<!-- Top Employers start -->
{{--@include('includes.top_employers')--}}
<!-- Top Employers ends -->
<!-- Popular Searches start -->
{{--@include('includes.popular_searches')--}}
<!-- Popular Searches ends -->

<!-- Featured Jobs start -->
{{--@include('includes.featured_jobs')--}}
<!-- Featured Jobs ends -->

<!-- How it Works start -->
{{--@include('includes.how_it_works')--}}
<!-- How it Works Ends -->

<!-- Video start -->
{{--@include('includes.video')--}}
<!-- Video end -->
<!-- Latest Jobs start -->
{{--@include('includes.latest_jobs')--}}
<!-- Latest Jobs ends -->
<!-- Testimonials start -->
{{--@include('includes.testimonials')--}}
<!-- Testimonials End -->
<!-- Subscribe start -->
{{--@include('includes.subscribe')--}}
<!-- Subscribe End -->

<!-- Map Start -->
<?php             $map['show'] = true;?>
<?php
// Default Map's values
$map = [
    'show' 				=> false,
    'backgroundColor' 	=> 'transparent',
    'border' 			=> '#c7c5c1',
    'hoverBorder' 		=> '#c7c5c1',
    'borderWidth' 		=> 4,
    'color' 			=> '#f2f0eb',
    'hover' 			=> '#4682B4',
    'width' 			=> '300px',
    'height' 			=> '300px',
];

// Blue Theme values
if (config('app.skin') == 'skin-blue') {
    $map = [
        'show' 				=> false,
        'backgroundColor' 	=> 'transparent',
        'border' 			=> '#4682B4',
        'hoverBorder' 		=> '#4682B4',
        'borderWidth' 		=> 4,
        'color' 			=> '#d5e3ef',
        'hover' 			=> '#4682B4',
        'width' 			=> '300px',
        'height' 			=> '300px',
    ];
}

// Green Theme values
//if (config('app.skin') == 'skin-green') {
    $map = [

        'backgroundColor' 	=> 'transparent',
        'border' 			=> '#17ad68',
        'hoverBorder' 		=> '#17ad68',
        'borderWidth' 		=> 2.5,
        'color' 			=> '#fff',
//        'color' 			=> '#cae7ca',
        'hover' 			=> '#ccc',
        'width' 			=> '850px',
        'height' 			=> '600px',
    ];
//}

// Red Theme values
if (config('app.skin') == 'skin-red') {
    $map = [
        'show' 				=> false,
        'backgroundColor' 	=> 'transparent',
        'border' 			=> '#fa2320',
        'hoverBorder' 		=> '#fa2320',
        'borderWidth' 		=> 4,
        'color' 			=> '#f0d9d8',
        'hover' 			=> '#fa2320',
        'width' 			=> '300px',
        'height' 			=> '300px',
    ];
}

// Yellow Theme values
if (config('app.skin') == 'skin-yellow') {
    $map = [
        'show' 				=> false,
        'backgroundColor' 	=> 'transparent',
        'border' 			=> '#ffd005',
        'hoverBorder' 		=> '#ffd005',
        'borderWidth' 		=> 4,
        'color' 			=> '#fcf8e3',
        'hover' 			=> '#2ecc71',
        'width' 			=> '300px',
        'height' 			=> '300px',
    ];
}
$map['show'] = true;


?>

@include('includes.map')
<!-- Map End -->

@include('includes.footer')
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document" style="margin-top: 100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <img src="../images/civil_defence_logo.png" width="150" style="margin-bottom: 15px">
                <p style="font-size: 16px; color: #555; line-height: 1.5; padding-bottom: 15px;">النسخة التجريبية لبرنامج آمن تحت إشراف إدارة الأمن والسلامة بالدفاع المدني بمكة المكرمة
                    شاكرين لهم جهودهم وتعاونهم للرقي بمستوى السلامة والصحة المهنية بالمملكة ومساهمتهم الفعالة في خدمة الوطن.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

<script>
    $(document).ready(function ($) {
        $("form").submit(function () {
            $(this).find(":input").filter(function () {
                return !this.value;
            }).attr("disabled", "disabled");
            return true;
        });
        $("form").find(":input").prop("disabled", false);
    });
</script>
<script src="{{ url('plugins/twism/jquery.twism.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#hiddden_detail').hide();
        @if($map['show'])

        $('#countryMap').css('cursor', 'pointer');
        $('#countryMap').twism("create",
            {
                map: "custom",
                {{--                    {{ asset('/') }}images/file.png--}}
                customMap: '{{  'images/maps/sa.php' }}',
                backgroundColor: '{{ $map['backgroundColor'] }}',
                border: '{{ $map['border'] }}',
                hoverBorder: '{{ $map['hoverBorder'] }}',
                borderWidth: '{{ $map['borderWidth'] }}',
                color: '{{ $map['color'] }}',
                width: '{{ $map['width'] }}',
                height: '{{ $map['height'] }}',
                click: function(regionId) {

                    var selectedIdObj = document.getElementById(regionId);


                    {{--window.location.href =' {{url(Request::url())}}'+'/initiatives?Initiatives_type=all&country_id%5B%5D=191&state_id%5B%5D='+regionId--}}
                        window.location.href =' {{url(Request::url())}}'+'/login'
                },
                hover: function(regionId) {

                    if (typeof regionId == "undefined") {
                        return false;
                    }
                    var selectedIdObj = document.getElementById(regionId);
                    if (typeof selectedIdObj == "undefined") {
                        return false;
                    }
                    $('#hiddden_detail').show();
                    $.post("{{ route('filter.initiatives') }}", {
                        region_Id: regionId,
                        _method: 'POST',
                        _token: '{{ csrf_token() }}'
                    })
                        .done(function (response) {
                            {{--$('#hiddden_detail').append("<ul class='list-group' id='map-init'><li class='list-group-item d-flex justify-content-between align-items-center' >" + "<i class='fa fa-graduation-cap green-color' aria-hidden='true'></i> {{__('Learning Initiative')}}" + "<span class='badge badge-primary badge-pill en-num pull-left' id='education_initi'>" + response.jobs_1 + "</span></li>" +--}}
                            {{--    "<li class='list-group-item d-flex justify-content-between align-items-center'>" + "<i class='fa fa-cogs green-color' aria-hidden='true'></i> {{__('Training Initiative')}}" + " <span class='badge badge-primary badge-pill en-num pull-left' id='trainer_initi'>"+ response.jobs_2 +"</span> </li>" +--}}
                            {{--    "<li class='list-group-item d-flex justify-content-between align-items-center'>"+"<i class='fa fa-black-tie green-color' aria-hidden='true'></i> {{__('Recruiting Initiative')}}"+ "<span class='badge badge-primary badge-pill en-num pull-left' id='job_initi'>"+ response.jobs_0 +"</span></li></ul>"--}}




                            {{--)--}}
                            {{--//--}}
                            {{--// document.getElementById('education_initi').innerText=  response.jobs_1;--}}
                            {{--// document.getElementById('trainer_initi').innerText=  response.jobs_2;--}}
                            {{--// document.getElementById('job_initi').innerText=  response.jobs_0;--}}

                        });
                    selectedIdObj.style.fill = '{{ $map['hover'] }}';
                    return;
                },
                unhover: function(regionId) {
                    $('#hiddden_detail').hide();

                    if (typeof regionId == "undefined") {
                        return false;
                    }
                    var selectedIdObj = document.getElementById(regionId);
                    if (typeof selectedIdObj == "undefined") {
                        return false;
                    }
                    selectedIdObj.style.fill = '{{ $map['color'] }}';





                    return;
                }


            });

        @endif

        //////modal-show///////////////////////////////////

        setTimeout(function(){ $('#exampleModal').modal('show'); }, 3000);
        setTimeout(function(){ $('#exampleModal').modal('hide'); }, 10000);
    });
</script>



@include('includes.country_state_city_js')
@endpush
