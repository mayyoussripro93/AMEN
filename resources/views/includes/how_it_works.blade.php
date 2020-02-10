<div class="section howitwrap">
    <div class="container">
        <!-- title start -->
        <div class="titleTop">
            <div class="subtitle">{{__('Join Us')}}</div>
            <h3>{{__('Initiatives')}} <span>{{__('Amen')}}</span></h3>
        </div>
        <!-- title end -->
        <ul class="howlist row flex">
            <!--step 1-->
            <a href="{{url('/initiatives')."?Initiatives_type=Learning"}}">
                <li class="col-md-4 col-sm-4">
                    <div class="iconcircle"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
                    </div>
                    <h4>{{__('Learning')}}</h4>
                    <p>{{__('The program aims to teach Saudi engineers and graduates of technical and industrial colleges occupational safety and health rules.')}}</p>
                </li>
            </a>
            <!--step 1 end-->
            <!--step 2-->
            <a href="{{url('/initiatives')."?Initiatives_type=Training"}}">
                <li class="col-md-4 col-sm-4">
                    <div class="iconcircle"><i class="fa fa-cogs" aria-hidden="true"></i>
                    </div>
                    <h4>{{__('Training')}}</h4>
                    <p>{{__('The program aims to train Saudi engineers and graduates of technical and industrial colleges in occupational safety and health.')}}</p>
                </li>
            </a>
            <!--step 2 end-->
            <!--step 3-->
            <a href="{{url('/jobs')}}">
                <li class="col-md-4 col-sm-4">
                    <div class="iconcircle"><i class="fa fa-black-tie" aria-hidden="true"></i>
                    </div>
                    <h4>{{__('Recruiting')}}</h4>
                    <p>{{__('The program contributes to the recruitment of Saudi engineers and technicians to work in projects registered on Amen platform.')}}</p>
                </li>
            </a>
            <!--step 3 end-->
        </ul>
    </div>
</div>