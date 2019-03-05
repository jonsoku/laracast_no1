@extends('layout.layout')
@section('content')
    <h2>Projects.show 화면입니다.</h2>
    <div>
        <h2>title</h2>
        <p>{{$project->title}}</p>
        <h4>description</h4>
        <p>{{$project->description}}</p>
        <div>
            <a href="/projects/{{$project->id}}/edit">EDIT</a>
        </div>
    </div>
    @if($project->tasks->count())
    <div>
        <h2>Task</h2>
        @foreach($project->tasks as $task)
            <p>
                <form method="POST" action="/tasks/{{$task->id}}/">
                @method('PATCH')
                @csrf
                    <label for="completed" class="{{$task->completed ? 'is-completed' : ''}}">
                        <input type="checkbox" name="completed" onchange="this.form.submit()" {{$task->completed ? 'checked' : ''}}/>
                        {{$task->description}}
                    </label>
                </form>
            </p>
        @endforeach
    </div>
    @endif

    <form action="/projects/{{$project->id}}/tasks" method="POST">
        @csrf
        <label for="description">새 할일</label>
        <div>
            <input type="text" name="description" placeholder="" class="{{$errors->has('description') ? 'is-danger' : ''}}"/>
        </div>
        <div>
            <button type="submit">새 할일 추가</button>
        </div>
    </form>
    @include('errors.error')

@endsection
