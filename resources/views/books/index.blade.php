@extends('app')

@section('content')

    List Book </br>
    <a href="{!! url('book/form') !!}"> Add Book </a> <br/>
    @foreach ($books as $book)

        {!! $book->name !!}
        {!! $book->description !!}
        <a href="{!! url('book/form/'. $book->id) !!}"> Edit </a>
    </br>

    @endforeach

@endsection
