@extends('layout.bg-black.bg_black')

@section('page-title')
Register
@stop

@section('title')
Login
@stop

@section('content')
{!! Form::open(['url' => 'user/login']) !!}
    {!! ErrorDisplay::getInstance()->DisplayAll($errors) !!}
    
    {!! Form::input_text('email', 'Email', 'email') !!}

    {!! Form::input_text('password', 'Password', 'password') !!}

	{!! Form::input_check('remember', 'Remember me') !!}    

    <div class="footer">                    

        <button type="submit" class="btn bg-olive btn-block">Sign me in</button>  
                    
        <p><a href="#">I forgot my password</a></p>
        
        <a href="{!! url('user/register') !!}" class="text-center">Register a new membership</a>
    </div>

{!! Form::close() !!}
@stop

