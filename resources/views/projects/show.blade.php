@extends('layout.layout')
@section('content')
    <h2>Projects.show 화면입니다.</h2>
    <div>
        <h2>title</h2>
        <p>{{$project->title}}</p>
        <h4>description</h4>
        <p>{{$project->description}}</p>
    </div>
    <div>
        <a href="/projects/{{$project->id}}/edit">EDIT</a>
    </div>
@endsection
