@extends('layout.layout')
@section('content')
    <h2>Projects.index 화면입니다.</h2>
    <div>
        @foreach($projects as $project)
            <div style="background-color: #ffd900;">
                <a href="/projects/{{$project->id}}" style="text-decoration: none; color:black;"><h3>{{$project->title}}</h3></a>
            </div>
        @endforeach
    </div>

    <div>
        <button onclick="location.href='/projects/create'">write</button>
    </div>
@endsection
