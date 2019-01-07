@include('layouts.admin')

@section('content')
    <h1>Media</h1>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Created at</th>
        </tr>
        </thead>
        <tbody>
        @if($photos)
            @foreach($photos as $photo)
                <tr>
                    <td>{{$photo->id}}</td>
                    <td>{{$photo->file}}</td>
                    <td>{{$photo->created_at ? $photo->created_at->diffForHumans() : 'no date'}}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

@endsection