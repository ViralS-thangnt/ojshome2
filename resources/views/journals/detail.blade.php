<!-- manuscript_in_review.php -->
@extends('layout.master.master')
<!-- Header Title -->
@section('title-page-admin')
<!-- Tác giả -->
<!-- Journal Open Source -->
<!-- Bản thảo -->
{!! Lang::get('admin.journal.title') !!}

@stop


<!-- Page Title -->
@section('title')
     {!! Lang::get('admin.journal.journal_info') !!}
    
@stop

@section('content')
    
<script type="text/javascript">
    $(function() {
        $('#table_data').dataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": false,
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
                @foreach($journal['col_header'] as $head)
                     <th class="sorting_asc center" role="columnheader" tabindex="0" aria-controls="table_data" rowspan="1" colspan="1">{{trans($head)}}</th>
                @endforeach
                <th class="center">Thứ tự</th>
                <th class="center">Thiết lập</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                @foreach($journal['col_header'] as $head)
                     <th class="sorting_asc center" role="columnheader" tabindex="0" aria-controls="table_data" rowspan="1" colspan="1">{{trans($head)}}</th>
                @endforeach
               <th class="center">Thứ tự</th>
               <th class="center">Thiết lập</th>
            </tr>
        </tfoot>
        <tbody role="alert" aria-live="polite" aria-relevant="all">
            <input type="hidden" value ='{!! $is_odd = true !!}'/>
            @foreach($journal['data'] as $row)
                
                <tr class="{{ ($is_odd) ? 'odd' : 'even' }}">

                    @foreach( $journal['col_db'] as $col)                        
                            <td class="center" > {!! empty($row->$col) ? '-' : $row->$col !!} </td>
                    @endforeach
                    
               {{--      <td class="center"><a href = "{{ url(Constant::$author_per['admin.manuscript.create'] . '/' . $row->id) }}"> {!! Lang::get('admin.manuscript.more_detail') !!} </a></td> --}}
                    <td class="center">
                        <a href ="{!! url('admin/journal/'.$id.'/position/'.$row->id.'/up') !!}" class="fa fa-arrow-up"></a>
                        <a href ="{!! url('admin/journal/'.$id.'/position/'.$row->id.'/down') !!}" class="fa fa-arrow-down"></a>
                    </td>
                    <td class="center"><a href ="{!! url('admin/journal/'.$id.'/'.$row->id.'/remove') !!}">Loại bỏ</a></td>
                </tr>

            @endforeach

        </tbody>
        </table>

    </div><!-- datatable_wrapper -->

    <div id="table_data_wrapper" class="dataTables_wrapper form-inline" role="grid">

        <!-- Table -->
        <table id="table_data" class="table table-bordered table-striped dataTable" aria-describedby="table_data_info">
        <thead>
            <tr role="row">
                @foreach($manuscripts['col_header'] as $head)
                     <th class="sorting_asc center" role="columnheader" tabindex="0" aria-controls="table_data" rowspan="1" colspan="1">{{trans($head)}}</th>
                @endforeach
                <th class="center">Operation</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                @foreach($manuscripts['col_header'] as $head)
                     <th class="sorting_asc center" role="columnheader" tabindex="0" aria-controls="table_data" rowspan="1" colspan="1">{{trans($head)}}</th>
                @endforeach
               <th class="center">Operation</th>
            </tr>
        </tfoot>
        <tbody role="alert" aria-live="polite" aria-relevant="all">
            <input type="hidden" value ='{!! $is_odd = true !!}'/>
            @foreach($manuscripts['data'] as $row)
                
                <tr class="{{ ($is_odd) ? 'odd' : 'even' }}">

                    @foreach( $manuscripts['col_db'] as $col)                        
                            <td class="center" > {!! empty($row->$col) ? '-' : $row->$col !!} </td>
                    @endforeach

                    <td class="center"><a href ="{!! url('admin/journal/'.$id.'/'.$row->id.'/add') !!}">Thêm</a></td>
                </tr>

            @endforeach

        </tbody>
        </table>

    </div><!-- datatable_wrapper -->

</div><!-- /.box-body -->
</div>
<form method="post" id="form-delete">
<input type="hidden" name="_method" value="DELETE" />
<input type="hidden" name="_token" value="{{ csrf_token() }}" />
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('a.delete').click(function(){
            if (confirm('Are you sure you want to delete this user ?')) {
                $('#form-delete').attr('action', $(this).attr('href')).submit();    
            }

            return false;
        });
    })
</script>

@stop
