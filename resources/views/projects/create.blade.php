@extends('layout.layout')
@section('content')
    <h2>Projects.create 화면입니다.</h2>
    <form method="POST" action="/projects">
        @csrf
        <div>
            <input type="text" name="title" placeholder="title" />
        </div>
        <div>
            <textarea name="description" id="" cols="30" rows="10"></textarea>
        </div>
        <div>
            <button type="submit">submit project</button>
        </div>
    </form>
@endsection
