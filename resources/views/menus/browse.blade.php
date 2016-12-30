@extends('voyager::master')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-list-add"></i> {{ trans('voyager::common.' . strtolower(str_replace(' ', '_', $dataType->slug))) }}
        <a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success">
            <i class="voyager-plus"></i> {{ trans('voyager::common.op_new') }}
        </a>
    </h1>
@stop

@section('page_header_actions')

@stop

@section('content')
    <div class="container-fluid">
        <div class="alert alert-info">
            <strong>{{ trans('voyager::menus.how_to_use') }}:</strong>
            <p>{!! trans('voyager::menus.how_to_use_ps1') !!}</p>
        </div>
    </div>

    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr>
                                @foreach($dataType->browseRows as $rows)
                                <th>{{ trans('voyager::menus.' . strtolower(str_replace(' ', '_', $rows->display_name))) }}</th>
                                @endforeach
                                <th class="actions">{{ trans('voyager::common.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($dataTypeContent as $data)
                                <tr>
                                    @foreach($dataType->browseRows as $row)
                                    <td>
                                        @if($row->type == 'image')
                                            <img src="@if( strpos($data->{$row->field}, 'http://') === false && strpos($data->{$row->field}, 'https://') === false){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                        @else
                                            {{ $data->{$row->field} }}
                                        @endif
                                    </td>
                                    @endforeach
                                    <td class="no-sort no-click">
                                        <div class="btn-sm btn-danger pull-right delete" data-id="{{ $data->id }}">
                                            <i class="voyager-trash"></i> {{ trans('voyager::common.op_delete') }}
                                        </div>
                                        <a href="{{ route('voyager.'.$dataType->slug.'.edit', $data->id) }}" class="btn-sm btn-primary pull-right edit">
                                            <i class="voyager-edit"></i> {{ trans('voyager::common.op_edit') }}
                                        </a>
                                        <a href="{{ route('voyager.'.$dataType->slug.'.builder', $data->id) }}" class="btn-sm btn-success pull-right">
                                            <i class="voyager-list"></i> {{ trans('voyager::common.op_build') }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="voyager-trash"></i> {{ trans('voyager::common.op_delete_ps1', ['msg'=>$dataType->display_name_singular]) }}
                    </h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ trans('voyager::common.op_delete_ps2', ['msg' => $dataType->display_name_singular]) }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ trans('voyager::common.btn_cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <!-- DataTables -->
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({ "order": [] });
        });

        $('td').on('click', '.delete', function (e) {
            id = $(e.target).data('id');

            $('#delete_form')[0].action += '/' + id;

            $('#delete_modal').modal('show');
        });
    </script>
@stop
