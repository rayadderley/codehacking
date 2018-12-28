@extends('layouts.admin')

@section('content')

    <h1>Create User</h1>

    {!! Form::open(['method' => 'POST', 'action' => 'AdminUsersController@store']) !!}
        <div class='form-group'>
            {!! Form::label('title', 'Title:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
        <div class='form-group'>
            {!! Form::submit('Create User', ['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

@endsection

@section('footer')

@endsection