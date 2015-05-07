<!-- manuscript_in_review.php -->
@extends('layout.master.master')
<!-- Header Title -->
@section('title-page-admin')

{!! Lang::get('admin.keyword.title') !!}

@stop


<!-- Page Title -->
@section('title')
     {!! Lang::get('admin.keyword.keyword_info') !!}
    
@stop

<!-- Page Title Extra -->
@section('title-extra')

<!-- More extra - Page Title  -->

@stop

<!-- Left column -->
@section('left-column')
{!! getMenuItem($permissions) !!} 
@stop

@section('content')
<form method="post" id="form-delete">
    <input type="hidden" name="_method" value="DELETE" />
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('a.delete').click(function(){
            if (confirm('Are you sure you want to delete this keyword ?')) {
                $('#form-delete').attr('action', $(this).attr('href')).submit();    
            }

            return false;
        });
    })
</script>
<script type="text/javascript">
    $(function() {
        $('#table_data').dataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": true
        });
    });
</script>

<div class="box">

<div class="box-body table-responsive">
     <div id="table_data_wrapper" class="dataTables_wrapper form-inline" role="grid">

        <!-- Table -->
        <table id="table_data" class="table table-bordered table-striped dataTable" aria-describedby="table_data_info">
        <thead>
            <tr role="row">
                @foreach($keywords['col_header'] as $head)
                     <th class="sorting_asc center" role="columnheader" tabindex="0" aria-controls="table_data" rowspan="1" colspan="1">{{trans($head)}}</th>
                @endforeach
                <th rowspan="1" colspan="1" class="center">{!! trans('admin.edit') !!}</th>
                <th rowspan="1" colspan="1" class="center">{!! trans('admin.delete') !!}</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                @foreach($keywords['col_header'] as $head)
                     <th class="sorting_asc center" role="columnheader" tabindex="0" aria-controls="table_data" rowspan="1" colspan="1">{{trans($head)}}</th>
                @endforeach
                <th rowspan="1" colspan="1" class="center">{!! trans('admin.edit') !!}</th>
                <th rowspan="1" colspan="1" class="center">{!! trans('admin.delete') !!}</th>
            </tr>
        </tfoot>
        <tbody role="alert" aria-live="polite" aria-relevant="all">
            <input type="hidden" value ='{!! $is_odd = true !!}'/>
            @foreach($keywords['data'] as $row)
                
                <tr class="{{ ($is_odd) ? 'odd' : 'even' }}">

                    @foreach( $keywords['col_db'] as $col)                        
                            <td class="center" > {!! empty($row->$col) ? '-' : $row->$col !!} </td>
                    @endforeach
                    
                    <td class="center"><a href ="{!! url('admin/keyword/form/'. $row->id) !!}">{!! trans('admin.edit') !!}</a></td>
                    <td class="center"><a href ="{!! url('admin/keyword/'. $row->id) !!}" class="delete">{!! trans('admin.delete') !!}</a></td>
                </tr>

            @endforeach

        </tbody>
        </table>

    </div><!-- datatable_wrapper -->

</div><!-- /.box-body -->
</div>


@stop
