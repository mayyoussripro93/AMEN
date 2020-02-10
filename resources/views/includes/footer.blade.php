<!--Footer-->
<div class="largebanner shadow3">
    <div class="adin">
        {!! $siteSetting->above_footer_ad !!}
    </div>
    <div class="clearfix"></div>
</div>


<div class="footerWrap">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="am-title" style="margin-right: 15px; color: #555;">روابط تهمك</h3>
            </div>
        </div>
        <div class="row">
            <!-- Civil Defense -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <a href="https://www.998.gov.sa/Ar/Pages/Default.aspx" style="text-decoration: none;" target="_blank"
                   title="{{__('Civil Defense Website')}}">
                    <div class="footer-card text-center">
                        <img id="CDLogo" src="{{ asset('/') }}images/civil_defence_logo.png" width="110"
                             style="margin-bottom: 15px;">
                        {{--<p class="green-color"><strong>{{__('Technical Support')}}</strong></p>--}}
                    </div>
                </a>
            </div>

            <!-- End Civil Defense -->

            <!-- Support -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <a href="{{route('tech.support')}}" style="text-decoration: none;">
                    <div class="footer-card text-center">
                        <img src="{{ asset('/') }}images/support.png" width="60" style="margin-bottom: 15px;">
                        <p class="green-color"><strong>{{__('Technical Support')}}</strong></p>
                    </div>
                </a>
            </div>
            <!-- Support -->
            <!-- Contact Us -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <a href="{{route('contact.us')}}" style="text-decoration: none;">
                    <div class="footer-card text-center">
                        <img src="{{ asset('/') }}images/call.png" width="60" style="margin-bottom: 15px;">
                        <p class="green-color"><strong>{{__('Contact Us')}}</strong></p>
                    </div>
                </a>
            </div>
            <!-- End Contact Us -->

            <!-- Terms & Conditions -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <a href="{{route('terms-conditions')}}" style="text-decoration: none;">
                    <div class="footer-card text-center">
                        <img src="{{ asset('/') }}images/accept.png" width="60" style="margin-bottom: 15px;">
                        <p class="green-color"><strong>{{__('Terms & Conditions')}}</strong></p>
                    </div>
                </a>
            </div>

            <!-- End Terms & Conditions -->

        </div>
    </div>
</div>
<!--Footer end-->
</div>
<!--Copyright-->
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center" style="float: none !important;">
                <div class="bttxt">{{__('Copyright')}} &copy; {{date('Y')}} {{ $siteSetting->site_name }}
                    . {{__('All Rights Reserved')}}.
                </div>
            </div>
        </div>

    </div>
</div>
