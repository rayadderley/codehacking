@extends('layouts.admin')

@section('content')
    <h1>Comments</h1>
        @if(count($comments) > 0)
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Author</th>
                    <th>Email</th>
                    <th>Body</th>
                    <th>Created at</th>
                    <th></th>
                </tr>
                </thead>
                @foreach($comments as $comment)
                    <tbody>
                    <tr>
                        <td>{{$comment->id}}</td>
                        <td>{{$comment->author}}</td>
                        <td>{{$comment->email}}</td>
                        <td>{{$comment->body}}</td>
                        <td>{{$comment->created_at->diffForHumans()}}</td>
                        <td><a href="{{route('home.post', $comment->post->id)}}">View Post</a></td>
                        <td>
                            @if($comment->is_active == 1)
                                {!! Form::open(['method'=>'PATCH', 'action'=>['PostCommentsController@update', $comment->id]]) !!}
                                <input type="hidden" name="is_active" value="0">
                                <div class="form-group">
                                    {!! Form::submit('Un-Approve', ['class' => 'btn btn-info']) !!}
                                </div>
                                {!! Form::close() !!}
                            @else
                                @if($comment->is_active == 0)
                                    {!! Form::open(['method'=>'PATCH', 'action'=>['PostCommentsController@update', $comment->id]]) !!}
                                    <input type="hidden" name="is_active" value="1">
                                    <div class="form-group">
                                        {!! Form::submit('Approve', ['class' => 'btn btn-success']) !!}
                                    </div>
                                    {!! Form::close() !!}
                                @endif
                            @endif
                        </td>
                        <td>
                            {!! Form::open(['method'=>'DELETE', 'action'=>['PostCommentsController@destroy', $comment->id]]) !!}
                            <div class="form-group">
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @else
                <h1 class="center">No Comments Available</h1>
            @endif
            </tbody>
        </table>
@endsection