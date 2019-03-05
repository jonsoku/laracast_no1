@extends('layout.layout')
@section('content')
    <h2>Projects.index 화면입니다.</h2>
    <div>
        @foreach($projects as $project)
            <div style="background-color: #ffd900;">
                <h3>{{$project->title}}</h3>
                <h6>{{$project->description}}</h6>
            </div>
        @endforeach
    </div>
@endsection
