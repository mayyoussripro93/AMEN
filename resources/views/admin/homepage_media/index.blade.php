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
                    <li> <span>{{__('Media')}}</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title">{{__('Media')}}</h3>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">{{__('Media List')}}</span> </div>
                            <div class="actions">
                                <a href="{{ route('create.homeMedia') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> {{__('Add Media')}}</a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <form method="post" role="form" id="user-search-form">
                                    <table class="table table-striped table-bordered table-hover"  id="videos_datatable_ajax">
                                        <thead>
                                        <tr role="row" class="filter">
                                            <td> {!! Form::select('media_type', [''=>__('Select'),'video'=>__('Video'),'paper'=>__('Paper'),'image'=>__('Image')],null, array('class'=>'form-control', 'id'=>'media_type','placeholder'=>__('Type'))) !!}</td>
                                            <td><input type="text" class="form-control" name="title" id="title" autocomplete="off"></td>
                                            <td></td>
                                        </tr>
                                        <tr role="row" class="heading">
                                            <th>{{__('Type')}}</th>
                                            <th>{{__('Title')}}</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table></form>
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
            var oTable = $('#videos_datatable_ajax').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                searching: false,
                "order": [[0, "desc"]],
                /*
                 paging: true,
                 info: true,
                 */
                ajax: {
                    url: '{!! route('fetch.data.homeMedia') !!}',
                    data: function (d) {
                        d.title = $('input[name=title]').val();
                        d.media_type=$('select[name=media_type]').val();
                    }
                }, columns: [
                    /*{data: 'id_checkbox', name: 'id_checkbox', orderable: false, searchable: false},*/
                    {data: 'media_type', name: 'media_type'},
                    {data: 'title', name: 'title'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
            $('#user-search-form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });

            $('#title').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#media_type').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
        });

        function makeActive(id) {
            $.post("{{ route('make.active.homeMedia') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        $('#onclickActive' + id).attr("onclick", "makeNotActive(" + id + ")");
                        $('#onclickActive' + id).html("<i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i>Make InActive");
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
        }
        function makeNotActive(id) {
            $.post("{{ route('make.not.active.homeMedia') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    console.log(response);
                    if (response == 'ok')
                    {
                        $('#onclickActive' + id).attr("onclick", "MakeActive(" + id + ")");
                        $('#onclickActive' + id).html("<i class=\"fa fa-square-o\" aria-hidden=\"true\"></i>Make Active");
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
        }
        function deleteVideo(id) {
            if (confirm('Are you sure! you want to delete?')) {
                $.post("{{ route('delete.homeMedia') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                    .done(function (response) {

                        if (response == 'ok')
                        {
                            var table = $('#videos_datatable_ajax').DataTable();
                            table.row('videoDtRow' + id).remove().draw(false);

                        } else
                        {
                            alert(response);
                        }
                    });
            }
        }
    </script>
@endpush