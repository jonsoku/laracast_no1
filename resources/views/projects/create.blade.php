@extends('layout.layout')
@section('content')
    <h2>Projects.create 화면입니다.</h2>
    <form method="POST" action="/projects">
        @csrf
        <div>
            <input type="text" name="title" placeholder="title" class="{{$errors->has('title') ? 'is-danger' : ''}}" value="{{old('title')}}"/>
        </div>
        <div>
            <textarea name="description" id="" cols="20" rows="10" class="{{$errors->has('description') ? 'is-danger' : ''}}">{{old('description')}}</textarea>
        </div>
        <div>
            <button type="submit">submit project</button>
        </div>
    </form>
    @include('errors.error')
@endsection
