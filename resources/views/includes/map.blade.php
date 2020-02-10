<div class="container-fluid main-content">
    <div class="container section mapwrap">

        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="map-container">
                    <!-- Start Map -->
                                    <h3 class="am-title green-color text-center"><img src="{{ asset('/') }}images/keyhole.png"
                                                                                      width="55"
                                                                                      style="vertical-align: middle;"> {{__('login')}}
                                    </h3>
                                    <h5 class="text-center"
                                        style="color: #555; line-height: 1.5; padding: 0 5px;">{{__('Click on the project region, then enter your username and password to login')}}</h5>

                                    @if ($map['show'])
                                        <div style="position: relative;">
                                            <div id="hiddden_detail">
                                            </div>
                                            <div id="countryMap" class="page-sidebar col-thin-left no-padding"
                                                 style="margin: auto;">
                                            </div>
                                        </div>
                                @endif
                <!-- End Map -->
                </div>


            </div>

            <div class="col-md-12 col-xs-12">
                <a href="{{route('safety.gallery')}}" style="text-decoration: none">
                    <div class="formpanel init-info text-center rules-btn">
                        <h3 class="am-title" style="margin-bottom: 0;">{{__('Safety and Health Rules')}}</h3>
                    </div>
                </a>
            </div>
        </div>

    </div>


