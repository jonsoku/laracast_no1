@extends('layout.layout')
@section('content')
    <h2>Projects.edit 화면입니다.</h2>
    <form method="POST" action="/projects/{{$project->id}}">
        @method('PATCH')
        @csrf
        <div>
            <input type="text" name="title" placeholder="title" value="{{$project->title}}"/>
        </div>
        <div>
            <textarea name="description" id="" cols="30" rows="10">{{$project->description}}</textarea>
        </div>
        <div>
            <button type="submit">update project</button>
        </div>
    </form>
    <form method="POST" action="/projects/{{$project->id}}">
        @method('DELETE')
        @csrf
        <div>
            <button type="submit">delete project</button>
        </div>
    </form>
    <button onclick="location.href='/projects'">HOME</button>
@endsection
