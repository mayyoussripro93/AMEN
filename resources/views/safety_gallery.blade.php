@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <div class="listpgWraper">
    @php $number_of_element=3;@endphp
    <!-- Header end -->
        @if($papers_count>0 ||$videos_count>0)

            {{--Start PDF Partition--}}
            @if($papers_count>0)
                <h3 class="am-title green-color text-center">{{__('Safety and Health Rules Files')}}</h3>
                <div id="myPDF" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="container">
                                @php $v=1 @endphp
                                @foreach($papers as $paper)
                                    <div class="text-center col-md-4 col-sm-4 col-xs-12 media-cont">
                                        <iframe src="https://docs.google.com/viewer?url={{$storage_url}}amen_home_page_media/{{$paper->media_type}}/{{$paper->upload_file}}&embedded=true"
                                                frameborder="0"></iframe>
                                        {{--                    <a href="{{$storage_url}}amen_home_page_media/{{$paper->media_type}}/{{$paper->upload_file}}" target="_blank"><embed src="{{$storage_url}}amen_home_page_media/{{$paper->media_type}}/{{$paper->upload_file}}#toolbar=1&navpanes=1&scrollbar=0" width="200px" height="200px" /></a>--}}

                                    </div>
                                    @if($v>1 && fmod($v,$number_of_element)==0  && $v<$papers_count)
                            </div>
                        </div>
                        <div class="item">
                            <div class='container'>
                                @endif
                                @if($v==$papers_count)
                            </div>
                        </div>
                        @endif
                        @php $v++ @endphp
                        @endforeach
                    </div>
                    <!-- Left and right controls -->
                    @if($papers_count > $number_of_element)
                        <a class="left carousel-control" href="#myPDF" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myPDF" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    @endif
                </div>
            @endif
            {{--End PDF Partition--}}


            {{--Start Videos Partition--}}
            @if($videos_count>0)
                <h3 class="am-title green-color text-center">{{__('Safety and Health Rules Videos')}}</h3>
                <div id="myVideos" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="container">
                                <div data-title="Landscape" class="t">
                                    @php $v=1 @endphp
                                    @foreach($videos as $video)
                                        <div class="col-md-4 col-sm-4 col-xs-12 text-center" style="margin-bottom: 15px;"><a class="alb_item"
                                                                                      href="{{$video->youtube_link}}">{{$video->title}}</a>
                                        </div>
                                        @if($v>1 && fmod($v,$number_of_element)==0  && $v<$videos_count)
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="container">
                                <div data-title="Landscape" class="t">
                                    @endif
                                    @if($v==$videos_count)
                                </div>
                            </div>
                        </div>
                        @endif
                        @php $v++ @endphp
                        @endforeach
                    </div>
                    <!-- Left and right controls -->
                    @if($videos_count > $number_of_element)
                        <a class="left carousel-control" href="#myVideos" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myVideos" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    @endif
                </div>
            @endif
            {{--End Videos Partition--}}
        @else
            <div class="col-md-6 col-md-offset-3">
                <div class="userccount">
                    <div class="text-center">
                        <img src="../images/amen_logo.png" alt="Amen" height="120">
                        <h4 class="green-color text-center" style="margin: 10px auto;"><i class="fa fa-info-circle"
                                                                                          aria-hidden="true"></i> {{__('No Results!!')}}
                        </h4>
                        <p style="color: #999;"> {{__('No Videos or PDFs uploaded in this section.')}}</p>
                        <div class="newuser"><a href="/"><i class="fa fa-arrow-circle-right"
                                                            aria-hidden="true"></i> {{__('Home')}}</a></div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body text-center">
                    <img src="../images/amen_logo.png" width="150" style="margin-bottom: 15px">
                    <p style="font-size: 16px; color: #555; line-height: 1.5; padding-bottom: 15px;">فيديوهات توعوية ومنشورات إرشادية تثري معلومات المستخدمين وتعزز من ثقافة السلامة والصحة المهنية لدى الفرد.</p>
                </div>

            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection
@push('styles')

    <link rel="stylesheet" href="{{ asset('/') }}admin_assets/Image-Youtube-Gallery/src/ALightBox.css">
    <style media="screen">
        .t img {
            width: 200px;
            height: auto;
        }

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
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('/') }}admin_assets/Image-Youtube-Gallery/src/ALightBox.js"></script>
    <script type="text/javascript">
        $('body').ALightBox({
            showYoutubeThumbnails: true
        });
        $(document).ready(function(){
            setTimeout(function(){ $('#exampleModal').modal('show'); }, 3000);
            setTimeout(function(){ $('#exampleModal').modal('hide'); }, 10000);
        });
    </script>

@endpush