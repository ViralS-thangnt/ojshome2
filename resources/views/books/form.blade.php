@extends('app')

@section('content')

{!! Form::model($book, ['route' => ['book_edit', $id]]) !!}
    {!! ErrorDisplay::getInstance()->DisplayAll($errors) !!}

    @if($id)
        {!! 'EDIT' !!}
    @else 
        {!! 'ADD' !!}
    @endif 

    BOOK </br>
    {!! Form::label('email', 'Email address', array('class' => 'label')); !!}

    Name : {!! Form::text('name', '', ['class' => 'form-control']) !!}</br>
    Description : {!! Form::text('description') !!}

    {!! Form::submit('submit') !!}

{!! Form::close() !!}
@endsection