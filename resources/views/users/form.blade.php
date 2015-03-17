@extends('layout.master.master')
<!-- Page Title --> 
@section('title')

@if($id)
    {!! 'Edit User' !!}
@else 
    {!! 'Create New User' !!}
@endif 

@stop

<!-- Main content -->
@section('content')

<div class="box box-primary">

<div class="box-body">

<a href="{!! url('admin/user') !!}">Back</a>
    
{!! Form::model($user, ['route' => ['user.update', $id]]) !!}
    {!! ErrorDisplay::getInstance()->DisplayAll($errors) !!}
    <div class="row">
        <div class="col-xs-12 col-md-6">
            {!! Form::input_text('username', 'Name') !!}

            {!! Form::input_text('email', 'Email', 'email') !!}

            {!! Form::input_select('degree_id', 'Degree', Constant::$degree) !!}

            {!! Form::input_select('academic_id', 'Academic', Constant::$academic) !!}

            {!! Form::input_text('password', 'Password', 'password') !!}

            {!! Form::input_text('password_confirmation', 'Password Confirm', 'password') !!}

            {!! Form::multi_check('actor_no', Constant::$actor) !!}
        </div>

        <div class="col-xs-12 col-md-6">
            {!! Form::input_text('last_name', 'Last Name') !!}

            {!! Form::input_text('first_name', 'First Name') !!}

            {!! Form::input_text('middle_name', 'Middle Name') !!}


            {!! Form::input_text('year', 'Year') !!} 

            {!! Form::input_text('phone', 'Phone') !!}

            {!! Form::input_text('address', 'Address') !!}

            {!! Form::input_text('nation', 'Nation') !!}

            {!! Form::input_text('research_area', 'Research Area') !!}

            {!! Form::input_text('research', 'Research') !!}

             {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>

{!! Form::close() !!}

</div>

</div><!--end .box-primary-->

@stop
