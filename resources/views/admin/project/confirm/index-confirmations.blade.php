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
                <li> <a href="{{ route('admin.home') }}">Home</a> <i class="fa fa-circle"></i> </li>
                <li> <span>Projects</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">Manage Confirmations <small>Confirmations</small> </h3>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-dark"></i> <span class="caption-subject font-dark sbold uppercase">Confirmations</span> </div>
                        <div class="actions"> <a href="{{ route('create.violation.confirmation',['violation_id'=>$violation_id]) }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Add New Confirmation</a> </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="datatable-search-form">
                                <input type="hidden" name="violation_id" value="{{$violation_id}}" id="violation_id">
                                <table class="table table-striped table-bordered table-hover" id="ConfirmationDatatableAjax">
                                    <thead>
                                    <tr role="row" class="filter">
                                        <td></td>
                                        <td>{!! Form::select('danger_status', ['removed'=>__('removed'),'exist'=>__('exist'),'work on'=>__('work on')],null, array('class'=>'form-control', 'id'=>'danger_status','placeholder'=>__('Danger Status'))) !!}</td>
                                        <td>{!! Form::select('area_status', ['opened'=>__('opened'),'closed'=>__('closed')],null, array('class'=>'form-control', 'id'=>'area_status','placeholder'=>__('Area Status'))) !!}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr role="row" class="heading">
                                        <th scope="col" >{{__('Cost')}}</th>
                                        <th scope="col">{{__('Danger Status')}}</th>
                                        <th scope="col">{{__('Area Status')}}</th>
                                        <th scope="col">{{__('Removement Date')}}</th>
                                        <th scope="col">{{__('Action')}}</th>
                                    </tr>
                                    </thead>
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
<script type="text/javascript">
    ///////////////////////////////////////////////////////////////////////
    $(function () {
        var oTable = $('#ConfirmationDatatableAjax').DataTable({
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
                url: '{!! route('fetch.admin.data.confirmations') !!}',
                data: function (d) {

                    d.danger_status = $('#danger_status').val();
                    d.area_status = $('#area_status').val();
                    d.violation_id = $('#violation_id').val();

                }
            }, columns: [
                {data: 'cost', name: 'cost'},
                {data: 'danger_status', name: 'danger_status'},
                {data: 'area_status', name: 'area_status'},
                {data: 'removement_duration', name: 'removement_duration'},
                {data: 'action', name: 'action'},

            ],
            "language": {
                "lengthMenu": "عدد العناصر بالصفحة _MENU_ عنصر",
                "zeroRecords": "لا يوجد نتائج",
                "info": "عرض _PAGE_ من _PAGES_ صفحة",
                "infoEmpty": "لا يوجد نتائج مطابقة",
                "infoFiltered": "(تم البحث في إجمالي _MAX_ سجلات)"
            },
            "initComplete": function (settings, json) {

            }
        });

        $('#danger_status').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#area_status').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
        });

    });
    function deleteConfirmation(id) {
        var msg = 'Are you sure?';
        if (confirm(msg)) {
            $.post("{{ route('delete.confirmation') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#ConfirmationDatatableAjax').DataTable();
                        table.row('confirmDtRow' + id).remove().draw(false);
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
        }
    }

</script>

@endpush