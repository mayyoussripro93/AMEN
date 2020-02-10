@extends('admin.layouts.admin_layout')
@section('content')
    <style type="text/css">
        .table td, .table th {
            font-size: 12px;
            line-height: 2.42857 !important;
        }
    </style>
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li> <a href="{{ route('admin.home') }}">{{__('Home')}}</a> <i class="fa fa-circle"></i> </li>
                    @if(urldecode($_GET['Initiatives_type']) == 'Learning')
                        <li> <span>مبادرات التعليم</span> </li>
                    @elseif(urldecode($_GET['Initiatives_type']) == 'Training')
                        <li> <span>مبادرات التوظيف</span> </li>
                    @endif
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            @if(urldecode($_GET['Initiatives_type']) == 'Learning')
                <h3 class="page-title">التعليم</h3>
            @elseif(urldecode($_GET['Initiatives_type']) == 'Training')
                <h3 class="page-title">التدريب</h3>
            @endif

            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable bordered">
                        <div class="portlet-title">
                            <div class="caption"> <i class="icon-settings font-red-sunglo"></i>
                                @if(urldecode($_GET['Initiatives_type']) == 'Learning')
                                    <span class="caption-subject font-red-sunglo sbold uppercase">قائمة مبادرات التعليم</span>
                                @elseif(urldecode($_GET['Initiatives_type']) == 'Training')
                                    <span class="caption-subject font-red-sunglo sbold uppercase">قائمة مبادرات التدريب</span>
                                @endif

                            </div>
                            <div class="actions">


                                @if(urldecode($_GET['Initiatives_type']) == 'Learning')
                                <a href="{{url('admin/create-initiatives').'?Initiatives_type=Learning'}}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> {{__('Add Learning Initiative')}}</a>

                                @elseif(urldecode($_GET['Initiatives_type']) == 'Training')
                                <a href="{{url('admin/create-initiatives').'?Initiatives_type=Training'}}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> {{__('Add Training Initiative')}}</a>
                                @endif
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <form method="post" role="form" id="job-search-form">
                                    <table class="table table-striped table-bordered table-hover"  id="jobDatatableAjax">
                                        <thead>
                                        <tr role="row" class="filter">
{{--                                            <td>{!! Form::select('company_id', ['' => 'Select Company']+$companies, null, array('id'=>'company_id', 'class'=>'form-control')) !!}</td>--}}
                                            <td><input type="text" class="form-control" name="company_name" id="company_name" autocomplete="off" placeholder="Company Organization"></td>
                                            <td><input type="text" class="form-control" name="title" id="title" autocomplete="off" placeholder="title"></td>
                                            <td><input type="text" class="form-control" name="description" id="description" autocomplete="off" placeholder="description"></td>
                                            <td>
                                                <?php $default_country_id = Request::query('country_id', $siteSetting->default_country_id); ?>
                                                {!! Form::select('country_id', ['' => 'Select Country']+$countries, $default_country_id, array('id'=>'country_id', 'class'=>'form-control')) !!}
                                                <span id="default_state_dd">
                                                    {!! Form::select('state_id', ['' => 'Select State'], null, array('id'=>'state_id', 'class'=>'form-control')) !!}
                                                </span>
                                                <span id="default_city_dd">
                                                    {!! Form::select('city_id', ['' => 'Select City'], null, array('id'=>'city_id', 'class'=>'form-control')) !!}
                                                </span></td>
                                            <td><input type="text" class="form-control" name="start_data" id="start_data" autocomplete="off" placeholder="Date Start(2019-08-24)"></td>
                                            <td><input type="text" class="form-control" name="end_data" id="end_data" autocomplete="off" placeholder="Date End 2019-08-30"></td>
                                            <td>
{{--                                                <select name="is_active" id="is_active" class="form-control">--}}
{{--                                                    <option value="-1">Is Active?</option>--}}
{{--                                                    <option value="1" selected="selected">Active</option>--}}
{{--                                                    <option value="0">In Active</option>--}}
{{--                                                </select>--}}
{{--                                                <select name="is_featured" id="is_featured" class="form-control">--}}
{{--                                                    <option value="-1">Is Featured?</option>--}}
{{--                                                    <option value="1">Featured</option>--}}
{{--                                                    <option value="0">Not Featured</option>--}}
{{--                                                </select>--}}
                                            </td>
                                        </tr>
                                        <tr role="row" class="heading">
{{--                                            <th>Company</th>--}}
                                            <th>Company Organization</th>
                                            <th>title</th>
                                            <th>description</th>
                                            <th>City</th>
                                            <th>Date Start</th>
                                            <th>Date End</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            var  Initiatives_type =  new URLSearchParams(window.location.search).get('Initiatives_type') ;

          if (Initiatives_type =="Learning"){
              var oTable = $('#jobDatatableAjax').DataTable({
                  processing: true,
                  serverSide: true,
                  stateSave: true,
                  searching: false,
                  /*
                   "order": [[1, "asc"]],
                   paging: true,
                   info: true,
                   */

                  ajax: {

                      url: '{!!url("admin/fetch-initiatives"."?Initiatives_type=Learning") !!}',
                      data: function (d) {
                          // d.company_id = $('#company_id').val();
                          d.company_name = $('#company_name').val();
                          d.title = $('#title').val();
                          d.description = $('#description').val();
                          d.country_id = $('#country_id').val();
                          d.state_id = $('#state_id').val();
                          d.city_id = $('#city_id').val();
                          d.start_data = $('#start_data').val();
                          d.end_data = $('#end_data').val();
                          // d.is_active = $('#is_active').val();
                          // d.is_featured = $('#is_featured').val();
                      }
                  }, columns: [
                      // {data: 'company_id', name: 'company_id'},
                      {data: 'company_name', name: 'company_name'},
                      {data: 'title', name: 'title'},
                      {data: 'description', name: 'description'},
                      {data: 'city_id', name: 'city_id'},
                      {data: 'start_data', name: 'start_data'},
                      {data: 'end_data', name: 'end_data'},
                      {data: 'action', name: 'action', orderable: false, searchable: false}
                  ]
              });
          } else if (Initiatives_type =="Training"){
              var oTable = $('#jobDatatableAjax').DataTable({
                  processing: true,
                  serverSide: true,
                  stateSave: true,
                  searching: false,
                  /*
                   "order": [[1, "asc"]],
                   paging: true,
                   info: true,
                   */

                  ajax: {

                      url: '{!!url("admin/fetch-initiatives"."?Initiatives_type=Training") !!}',
                      data: function (d) {
                          // d.company_id = $('#company_id').val();
                          d.company_name = $('#company_name').val();
                          d.title = $('#title').val();
                          d.description = $('#description').val();
                          d.country_id = $('#country_id').val();
                          d.state_id = $('#state_id').val();
                          d.city_id = $('#city_id').val();
                          d.start_data = $('#start_data').val();
                          d.end_data = $('#end_data').val();
                          // d.is_active = $('#is_active').val();
                          // d.is_featured = $('#is_featured').val();
                      }
                  }, columns: [
                      // {data: 'company_id', name: 'company_id'},
                      {data: 'company_name', name: 'company_name'},
                      {data: 'title', name: 'title'},
                      {data: 'description', name: 'description'},
                      {data: 'city_id', name: 'city_id'},
                      {data: 'start_data', name: 'start_data'},
                      {data: 'end_data', name: 'end_data'},
                      {data: 'action', name: 'action', orderable: false, searchable: false}
                  ]
              });
          }

            $('#job-search-form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            // $('#company_id').on('change', function (e) {
            //     oTable.draw();
            //     e.preventDefault();
            // });
            $('#company_name').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            })
            $('#title').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#description').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#country_id').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
                filterDefaultStates(0);
            });
            $(document).on('change', '#state_id', function (e) {
                oTable.draw();
                e.preventDefault();
                filterDefaultCities(0);
            });
            $(document).on('change', '#city_id', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#start_data').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#end_data').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            // $('#is_active').on('change', function (e) {
            //     oTable.draw();
            //     e.preventDefault();
            // });
            // $('#is_featured').on('change', function (e) {
            //     oTable.draw();
            //     e.preventDefault();
            // });
            filterDefaultStates(0);
        });
        function deleteJob(id, is_default) {
            var msg = 'Are you sure?';
            if (confirm(msg)) {
                $.post("{{ route('delete.initiatives') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        if (response == 'ok')
                        {
                            var table = $('#jobDatatableAjax').DataTable();
                            table.row('jobDtRow' + id).remove().draw(false);
                        } else
                        {
                            alert('Request Failed!');
                        }
                    });
            }
        }
        function makeActive(id) {
            $.post("{{ route('make.active.initiatives') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#jobDatatableAjax').DataTable();
                        table.row('jobDtRow' + id).remove().draw(false);
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
        }
        function makeNotActive(id) {
            $.post("{{ route('make.not.active.initiatives') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#jobDatatableAjax').DataTable();
                        table.row('jobDtRow' + id).remove().draw(false);
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
        }
        function makeFeatured(id) {
            $.post("{{ route('make.featured.initiatives') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#jobDatatableAjax').DataTable();
                        table.row('jobDtRow' + id).remove().draw(false);
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
        }
        function makeNotFeatured(id) {
            $.post("{{ route('make.not.featured.initiatives') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#jobDatatableAjax').DataTable();
                        table.row('jobDtRow' + id).remove().draw(false);
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
        }
        function filterDefaultStates(state_id)
        {
            var country_id = $('#country_id').val();
            if (country_id != '') {
                $.post("{{ route('filter.lang.states.dropdown') }}", {country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        $('#default_state_dd').html(response);
                    });
            }
        }
        function filterDefaultCities(city_id)
        {
            var state_id = $('#state_id').val();
            if (state_id != '') {
                $.post("{{ route('filter.lang.cities.dropdown') }}", {state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        $('#default_city_dd').html(response);
                    });
            }
        }
    </script>
@endpush