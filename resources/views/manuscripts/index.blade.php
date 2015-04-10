@extends('layout.master.master')
<!-- Page Title -->
@section('title')

<h1>User Management</h1>

@stop

<!-- Main content -->
@section('content')

@if(!is_null($manuscripts))
<table class="table">
<thead>
    <tr>
        <th>ID</th>
        <th>{{ trans('admin.manuscript.lastModified') }}</th>
        <th>{{ trans('admin.manuscript.name') }}</th>
        <th>{{ trans('admin.manuscript.author') }}</th>
        <th colspan="2">Operations</th>
    </tr>
</thead>

<tbody>

    @foreach($manuscripts as $manuscript)
    <tr>
        <td>{{$manuscript->id}}</td>
        <td>{{$manuscript->updated_at}}</td>
        <td>{{$manuscript->name}}</td>
        <td>{{$manuscript->author->last_name.' '.$manuscript->author->middle_name.' '.$manuscript->author->first_name}}</td>
        @if (in_array(AUTHOR, $permissions))
        <td><a href="{!! url('admin/manuscript/form/'. $manuscript->id) !!}">{{trans('admin.edit')}}</a></td>
        <td><a class="delete" href="{!! url('admin/manuscript/'. $manuscript->id) !!}">{{trans('admin.delete')}}</a></td>
        @else
        <td></td>
        <td></td>
        @endif
    </tr>
    @endforeach
</tbody>
</table>
@else
{{trans('admin.emptyData')}}
@endif
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
