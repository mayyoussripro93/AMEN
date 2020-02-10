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
                <li> <span>{{__('Projects')}}</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">{{__('Manage Projects')}}</h3>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">{{__('Projects')}}</span> </div>
                        <div class="actions"> <a href="{{ route('create.project') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> {{__('Add New Project')}}</a> </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="datatable-search-form">
                                <table class="table table-striped table-bordered table-hover"  id="ProjectDatatableAjax">
                                    <thead>
                                    <tr role="row" class="filter">
                                        <td>
                                            {{--                                                                <input type="text" class="form-control  datepicker" name="date_gregorian_txt" id="date_gregorian_txt" autocomplete="off" placeholder="{{__('Date')}}">--}}
                                            <input type="text" class="form-control" name="start_date" id="start_date" autocomplete="off" placeholder="{{__('Date')}}">
                                        </td>
                                        <td></td>
                                        <td>
                                            <input type="text"  class="form-control" name="name" id="name" autocomplete="off" placeholder="{{__('Name')}}">

                                        </td>
                                        <td>
                                            {!! Form::select('state_id', ['' => __('State')] + $states,null, array( 'id'=>'state_id' ,'class' => 'form-control')) !!}
                                        </td>
                                        <td>
                                            <span id="city_dd"> {!! Form::select('city_id', [''=>__('City')], null, array('class'=>'form-control', 'id'=>'city_id')) !!}</span>
                                        </td>
                                        <td>
                                            {!! Form::select('is_active', [1=>__('Work On'),0=>__('Completed')],null, array('class'=>'form-control', 'id'=>'is_active','placeholder'=>__('Status'))) !!}
                                        </td>
                                        {{--                                                        <td></td>--}}

                                        <td></td>


                                    </tr>
                                    <tr role="row" class="heading">
                                        <th scope="col" style="max-width: 75px !important;">{{__('Start Date')}}</th>
                                        <th scope="col">{{__('Code')}}</th>
                                        <th scope="col" style="max-width: 75px !important;">{{__('Name')}}</th>
                                        <th scope="col">{{__('State')}}</th>
                                        <th scope="col">{{__('City')}}</th>
                                        <th scope="col">{{__('Project Status')}}</th>
                                        <th scope="col">{{__('Details')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="mydata">
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


        var oTable = $('#ProjectDatatableAjax').DataTable({
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
                url: '{!! route('fetch.admin.data.projects') !!}',
                data: function (d) {
                    d.name = $('#name').val();
                    d.start_date = $('#start_date').val();
                    d.state_id = $('#state_id').val();
                    d.city_id = $('#city_id').val();
                    d.is_active = $('#is_active').val();

                }
            }, columns: [
                {data: 'date_gregorian', name: 'date_gregorian'},
                {data: 'code', name: 'code'},
                {data: 'name', name: 'name'},
                {data: 'state', name: 'state'},
                {data: 'city', name: 'city'},
                {data: 'is_active', name: 'is_active'},
                // {data: 'violation_no', name: 'violation_no'},
                {data: 'action', name: 'action'},
            ],
            "language": {
                "lengthMenu": "عدد العناصر بالصفحة _MENU_ عنصر",
                "zeroRecords": "لا يوجد نتائج",
                "info": "عرض _PAGE_ من _PAGES_ صفحة",
                "infoEmpty": "لا يوجد نتائج مطابقة",
                "infoFiltered": "(تم البحث في إجمالي _MAX_ سجلات)"
            }
        });

        $('#start_date').daterangepicker({
            // "singleDatePicker": true,
            // "timePicker": true,
            // "timePicker24Hour": true,
            "autoUpdateInput": false,
            "locale": {
                "format": "YYYY-MM-DD",
                "applyLabel": "Apply",
                "cancelLabel": "Cancel",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": [
                    "Su",
                    "Mo",
                    "Tu",
                    "We",
                    "Th",
                    "Fr",
                    "Sa"
                ],
                "monthNames": [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December"
                ],
                "firstDay": 1
            },
        }).on('apply.daterangepicker', function(ev, picker) {

            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));

            oTable.draw();
            event.preventDefault();
            // console.log(picker.startDate.format('YYYY-DD'));
            // console.log(picker.endDate.format('YYYY-MM-DD'));
        });


        $('#datatable-search-form').on('submit', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#name').on('keyup', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#is_active').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#state_id').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
            filtercity();

        });

        function filtercity()
        {
            var state_id = $('#state_id').val();
            if (state_id != '') {
                $.post("{{ route('filter.lang.cities.dropdown') }}"
                        , {
                            state_id: state_id,
                            _method: 'POST',
                            _token: '{{ csrf_token() }}'})
                        .done(function (datacity) {
                            $('#city_dd').html(datacity);
                            $('#city_id').on('change', function (e) {
                                oTable.draw();
                                e.preventDefault();
                            });
                        });
            }
        }

    });


    function deleteProject(id) {
        var msg = 'Are you sure?';
        if (confirm(msg)) {
            $.post("{{ route('delete.project') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        if (response == 'ok')
                        {
                            var table = $('#ProjectDatatableAjax').DataTable();
                            table.row('projectDtRow' + id).remove().draw(false);
                        } else
                        {
                            alert(response);
                        }
                    });
        }
    }

</script>
@endpush