@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Employees')])

    <style>
        .form-control {
            font-size: 12px;
        }
        .am-links {
            position: absolute;
            margin-left: 5px;
            left: 0;
        }
        table.dataTable tbody th, table.dataTable tbody td {
            white-space: nowrap;
        }
    </style>
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        <div class="col-md-9 col-sm-9 col-xs-12">

                            <div class="job-header">
                                <div class="contentbox" style="overflow: auto;">
                                    <div class="portlet light portlet-fit portlet-datatable bordered" style="position:relative;">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <h6 class="green-color am-sub-title">{{__('Employees')}}</h6>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-container">
                                                <form method="post" role="form" id="datatable-search-form">

                                                    <table class="table table-striped table-bordered table-hover" id="EmployeeDatatableAjax">
                                                        <thead>
                                                        <tr role="row" class="filter">
                                                          <td>  <input type="text"  class="form-control" name="name" id="name" autocomplete="off" placeholder="{{__('Name')}}"></td>
                                                            <td></td>
                                                            <td></td>

                                                            <td> {!! Form::select('city_id', [''=>__('City')]+$cities, null, array('class'=>'form-control', 'id'=>'city_id')) !!}</td>
                                                            <td></td>

                                                        </tr>
                                                        <tr role="row" class="heading">
                                                            <th>{{__('Name')}}</th>
                                                            <th>{{__('Email')}}</th>
                                                            <th>{{__('Phone')}}</th>
                                                            <th>{{__('City')}}</th>
{{--                                                        <th >{{__('The Project')}}</th>--}}
                                                            <th></th>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection
@push('scripts')
    <script type="text/javascript">

        $(function () {
            var oTable = $('#EmployeeDatatableAjax').DataTable({
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
                    url: '{!! route('employee.employees.fetch') !!}',
                    data: function (d) {
                        d.name = $('#name').val();
                        d.city_id = $('#city_id').val();
                        // d.project_id = $('#project_id').val();
                    }
                }, columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'city_id', name: 'city_id'},
                    {data: 'show', name: 'show'},
                ],
                "language": {
                    "lengthMenu": "عدد العناصر بالصفحة _MENU_ عنصر",
                    "zeroRecords": "لا يوجد نتائج",
                    "info": "عرض _PAGE_ من _PAGES_ صفحة",
                    "infoEmpty": "لا يوجد نتائج مطابقة",
                    "infoFiltered": "(تم البحث في إجمالي _MAX_ سجلات)"
                }
            });

            $('#city_id').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });

            $('#name').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
        });


    </script>
@endpush