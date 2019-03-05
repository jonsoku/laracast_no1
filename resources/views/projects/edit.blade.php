@extends('layout.layout')
@section('content')
    <h2>Projects.edit 화면입니다.</h2>
    <form method="POST" action="/projects/{{$project->id}}">
        @method('PATCH')
        @csrf
        <div>
            <input type="text" name="title" placeholder="title" value="{{$project->title}}" class="{{$errors->has('title') ? 'is-danger' : ''}}"/>
        </div>
        <div>
            <textarea name="description" id="" cols="30" rows="10" class="{{$errors->has('description') ? 'is-danger' : ''}}">{{$project->description}}</textarea>
        </div>
        <div>
            <button type="submit">update project</button>
        </div>
    </form>
    @include('errors.error')
    <form method="POST" action="/projects/{{$project->id}}">
        @method('DELETE')
        @csrf
        <div>
            <button type="submit">delete project</button>
        </div>
    </form>
    <button onclick="location.href='/projects'">HOME</button>
@endsection
