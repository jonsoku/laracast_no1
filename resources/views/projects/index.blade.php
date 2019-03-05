@extends('layout.layout')
@section('content')
    <h2>Projects.index 화면입니다.</h2>
    <ul>
        @foreach($projects as $project)
            <li>{{$project->title}}</li>
            <li>{{$project->description}}</li>
        @endforeach
    </ul>
@endsection
