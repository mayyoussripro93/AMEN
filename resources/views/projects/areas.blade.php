@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Areas')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
            <div class="row">
                @include('includes.employee_dashboard_menu')

                <div class="col-md-9 col-sm-8">
				
					<h3>المناطق</h3>
                    <div class="paypackages">
						<!-- Start Projects List -->
						<div class="four-plan">
							<div class="row">
								<div class="col-md-3 col-sm-6 col-xs-12">
									<ul class="boxes">
										<li class="icon" style="padding: 5px 0;"><i class="fa fa-map-marker" aria-hidden="true" style="color: #11AF4F;"></i></li>
										<li class="plan-name" style="font-size: 14px;">الرياض</li>
										<li class="plan-pages">
											<a href="{{route('project.area_projects')}}" class="btn btn-default" style="border: 1px solid #11AF4F;">مشاهدة المشاريع</a>
										</li>
									</ul>
								</div>
								<div class="col-md-3 col-sm-6 col-xs-12">
									<ul class="boxes">
										<li class="icon" style="padding: 5px 0;"><i class="fa fa-map-marker" aria-hidden="true" style="color: #11AF4F;"></i></li>
										<li class="plan-name" style="font-size: 14px;">مكة المكرمة</li>
										<li class="plan-pages">
											<a href="{{route('project.area_projects')}}" class="btn btn-default" style="border: 1px solid #11AF4F;">مشاهدة المشاريع</a>
										</li>
									</ul>
								</div>
								<div class="col-md-3 col-sm-6 col-xs-12">
									<ul class="boxes">
										<li class="icon" style="padding: 5px 0;"><i class="fa fa-map-marker" aria-hidden="true" style="color: #11AF4F;"></i></li>
										<li class="plan-name" style="font-size: 14px;">المنطقة الشرقية</li>
										<li class="plan-pages">
											<a href="{{route('project.area_projects')}}" class="btn btn-default" style="border: 1px solid #11AF4F;">مشاهدة المشاريع</a>
										</li>
									</ul>
								</div>
								<div class="col-md-3 col-sm-6 col-xs-12">
									<ul class="boxes">
										<li class="icon" style="padding: 5px 0;"><i class="fa fa-map-marker" aria-hidden="true" style="color: #11AF4F;"></i></li>
										<li class="plan-name" style="font-size: 14px;">المدينة المنورة</li>
										<li class="plan-pages">
											<a href="{{route('project.area_projects')}}" class="btn btn-default" style="border: 1px solid #11AF4F;">مشاهدة المشاريع</a>
										</li>
									</ul>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-3 col-sm-6 col-xs-12">
									<ul class="boxes">
										<li class="icon" style="padding: 5px 0;"><i class="fa fa-map-marker" aria-hidden="true" style="color: #11AF4F;"></i></li>
										<li class="plan-name" style="font-size: 14px;">الجوف</li>
										<li class="plan-pages">
											<a href="{{route('project.area_projects')}}" class="btn btn-default" style="border: 1px solid #11AF4F;">مشاهدة المشاريع</a>
										</li>
									</ul>
								</div>
								<div class="col-md-3 col-sm-6 col-xs-12">
									<ul class="boxes">
										<li class="icon" style="padding: 5px 0;"><i class="fa fa-map-marker" aria-hidden="true" style="color: #11AF4F;"></i></li>
										<li class="plan-name" style="font-size: 14px;">الباحة</li>
										<li class="plan-pages">
											<a href="{{route('project.area_projects')}}" class="btn btn-default" style="border: 1px solid #11AF4F;">مشاهدة المشاريع</a>
										</li>
									</ul>
								</div>
								<div class="col-md-3 col-sm-6 col-xs-12">
									<ul class="boxes">
										<li class="icon" style="padding: 5px 0;"><i class="fa fa-map-marker" aria-hidden="true" style="color: #11AF4F;"></i></li>
										<li class="plan-name" style="font-size: 14px;">عسير</li>
										<li class="plan-pages">
											<a href="{{route('project.area_projects')}}" class="btn btn-default" style="border: 1px solid #11AF4F;">مشاهدة المشاريع</a>
										</li>
									</ul>
								</div>
								<div class="col-md-3 col-sm-6 col-xs-12">
									<ul class="boxes">
										<li class="icon" style="padding: 5px 0;"><i class="fa fa-map-marker" aria-hidden="true" style="color: #11AF4F;"></i></li>
										<li class="plan-name" style="font-size: 14px;">القصيم</li>
										<li class="plan-pages">
											<a href="{{route('project.area_projects')}}" class="btn btn-default" style="border: 1px solid #11AF4F;">مشاهدة المشاريع</a>
										</li>
									</ul>
								</div>								
							</div>
						</div>
						<!-- End Projects List -->
					</div>

				</div>
			</div>
		</div>
	</div>
    @include('includes.footer')
@endsection