### Laravel 5.7버전 설치
    composer create-project --prefer-dist laravel/laravel blog "5.7.*"

### [6-1] .env 설정
    DB_CONNECTION=mysql
    DB_HOST=laravel.cim78dtgz3dv.ap-northeast-1.rds.amazonaws.com
    DB_PORT=3306
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=


### [6-2] 테이블 생성
    2-1) 
    App\Provider\AppServiceProvider.php에 아래 라인 추가.

    use Illuminate\Support\Facades\Schema;

    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    2-2)
    php artisan migrate
    
    *)
    php artisan migrate:rollback : 이전 테이블상태로 되돌린다.
    php artisan migrate:fresh : 테이블삭제하고 다시 만든다.
    
    tip)
    php artisan help make:migration
    php artisan help make:controller 등등..

### [6-3] projects 테이블 생성
    php artisan make:migration create_projects_table
    
### [6-4] projects 테이블에 컬럼추가
    4-1)
    Schema::create('projects', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->text('description');
        $table->timestamps();
    });
    
    4-2)
    php artisan migrate

### [7-1] Project model 생성
    php artisan make:model Project
    
### [7-2] tinker
    [1] tinker 실행
    php artisan tinker
    
    [2] tinker 에서의 명령어
    App\Project::all();
    App\Project::first();
    App\Project::latest()->first();
    
    [3] tinker 에서 변수 설정하고 변수에 데이터 넣기
    $project = new App\Project;
    $project->title = 'My First Title';
    $project->description = 'My First Description'; 
    
    [4] 확인하기
    $project
    
    [5] 저장하기
    $project->save();
    *true가 나오면 저장된것임.
    
    [6] 확인하기
    App\Project::first();
    App\Project::first()->title;
    App\Project::first()->description;

### [7-3] web.php에 라우터 추가
    Route::get('/projects','ProjectsController@index');
    
### [7-4] projects 컨트롤러 생성
    php artisan make:controller ProjectsController
### [7-5] projects 컨트롤러에 index 생성
    public function index(){
        return view('projects.index');
    }
### [7-6] view 페이지 생성 projects.index
    views/projects 폴더에 index.blade.php 생성
    
    
### [7-7] view에 데이터 뿌리기
    ProjectsController의 index 에서
    
    public function index(){
        $projects = \App\Project::all();
        return view('projects.index',[
            'projects' => $projects
        ]);
    }
### [7-8] view에서 데이터 받기 (projects.index)
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
    @endsection
### [9-1] projects 컨트롤러에 create 생성
    public function create(){
        return view('projects.create');
    }
### [9-2] view 페이지 생성 projects.create
          views/projects 폴더에 create.blade.php 생성
    
### [9-3] view에서 폼 만들기 (projects.create)
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
### [9-4] web.php 에 post ProjectsController@store 추가
    [1] post라우트 추가
    Route::post('/projects', 'ProjectsController@store');
    
    [2] ProjectsController 에 store 생성
    public function store(){
        $project = new Project();
        $project->title = \request('title');
        $project->description = \request('description');
        $project->save();
        return redirect('/projects');
    }

### [10-1] web.php에 projects resource 라우트 생성

    기존 라우트 삭제 후 아래 라인 추가
    Route::resource('projects', 'ProjectsController');
    
    php artisan route:list 로 확인
    
### [10-2] projects 컨트롤러에 show, edit, update, destroy 추가 (구린방법)
    [1] show
    
        public function show($id){
            $project = Project::find($id);
            return view('projects.show',[
                'project' => $project
            ]);
        }
        
        ==view====view====view====view====view====view====view====view==
        
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

    
    [2] edit
    
    
        public function edit($id){
    
            $project = Project::find($id);
            return view('projects.edit', [
                'project' => $project
            ]);
        }
        
        ==view====view====view====view====view====view====view====view==
        
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
        
        
    [3] update
    
    
        public function update($id){
            $project = Project::find($id);
            $project->title = \request('title');
            $project->description = \request('description');
            $project->save();
            return redirect('/projects');
    
        }
    
    [4] destroy
    
    
        public function destroy($id){
            $project = Project::find($id);
            $project->delete();
            return redirect('/projects');
        }

### [14-1] 더 예쁜 컨트롤러


        [1] store
        
            <before>
            
            public function store(){
            
                $project = new Project();
                $project->title = \request('title');
                $project->description = \request('description');
                $project->save();

                return redirect('/projects');
            }
            
            <after>
            
            public function store(){
            
                Project::create([
                    'title' => \request('title'),
                    'description' => \request('description')
                ]);
            
                return redirect('/projects');
            }
            
            Project.php 모델에 $fillable 반드시 추가해줘야한다.
            
            <?php
            
            namespace App;
            
            use Illuminate\Database\Eloquent\Model;
            
            class Project extends Model
            {
                protected $fillable = [
                    'title', 'description'
                ];
            }
            
            * protected $guarded = []; 방법도 있다.
            
            <after 2>
            
            public function store(){
        
                Project::create(\request(['title', 'description']));
        
                return redirect('/projects');
            }
            
            <after 3>
            
            public function store(){
                $attributes = \request()->validate([
                    'title' => ['required','min:2'],
                    'description' => ['required', 'min:2'],
                ]);
                Project::create($attributes);
        
                return redirect('/projects');
            }

        
        [2] show
        
            <before>
        
            public function show($id){
                $project = Project::find($id);
                return view('projects.show',[
                    'project' => $project
                ]);
            }
            
            <after>
            
            public function show(Project $project){
                return view('projects.show',[
                    'project' => $project
                ]);
            }

        
        [3] edit
            
            <before>
            
            public function edit($id){
        
                $project = Project::find($id);
                return view('projects.edit', [
                    'project' => $project
                ]);
            }
            
            <after>
            
            public function edit(Project $project){
        
                return view('projects.edit', [
                    'project' => $project
                ]);
            }
            
            
            
        [4] update
        
            <before>
            
            public function update($id){
                $project = Project::find($id);
                $project->title = \request('title');
                $project->description = \request('description');
                $project->save();
                return redirect('/projects');
        
            }
            
            <after>
            
            public function update(Project $project){
        
                $project->update(\request(['title', 'description']));
        
                return redirect('/projects');
        
            }
            
            <after 2>
            
            public function update(Project $project){
        
                $attributes = \request()->validate([
                    'title' => ['required','min:2'],
                    'description' => ['required', 'min:2'],
                ]);
                $project->update($attributes);
        
                return redirect('/projects');
        
            }
        
        [5] destroy
        
            <before>
            
            public function destroy($id){
                $project = Project::find($id);
                $project->delete();
                return redirect('/projects');
            }
            
            <after>
            
            public function destroy(Project $project){
                $project->delete();
                return redirect('/projects');
            }
### [16-1] Task model 생성 (migration, factory 같이)
    php artisan make:model Task -m -f

### [16-2] Task table 생성 
    [1]
    
    Schema::create('tasks', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('project_id');
        $table->string('description');
        $table->boolean('completed')->default(false);
        $table->timestamps();
    });
    
    [2]
    
    php artisan migrate
    
    
### [16-3] Projects.php <=> Task.php  모델에 관계맺기
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

### [16-4] tinker 로 더미데이터 넣기
    [1]
    
    php artisan tinker
    
    [2]
    
    관계 맺어졌나 확인
    App\Project::first()->tasks;

    [3]
    
    database에 project_id값 넣고 더미데이터 입력
    App\Project::first()->tasks; 확인
    
### [16-5] projects.show 에 task추가
    @if($project->tasks->count())
    <div>
        <h2>Task</h2>
        @foreach($project->tasks as $task)
            <p>{{$task->description}}</p>
        @endforeach
    </div>
    @endif
    
### [16-6] Task.php <=> Project.php 모델에 관계맺기
    <?php
    
    namespace App;
    
    use Illuminate\Database\Eloquent\Model;
    
    class Task extends Model
    {
        public function project(){
            return $this->belongsTo(Project::class);
        }
    }
    
### [16-7] tinker 로 관계 맺어진 것 확인하기
    [1]
    php artisan tinker
    
    [2]
    App\Task::first();

    [3]
    App\Task::first()->project;

### [16-8] projects.show 에 Task부분 수정
    @if($project->tasks->count())
    <div>
        <h2>Task</h2>
        @foreach($project->tasks as $task)
            <p>
                <form method="POST" action="/tasks/{{$task->id}}/">
                @method('PATCH')
                @csrf
                    <label for="completed">
                        <input type="checkbox" name="completed" onchange="this.form.submit()"/>
                        {{$task->description}}
                    </label>
                </form>
            </p>
        @endforeach
    </div>
    @endif
    
### [16-9] web.php 에 라우트 추가
    Route::patch('/tasks/{task}', 'ProjectTasksController@update');
    
### [17-1] ProjectTasksController 생성
    [1] 컨트롤러 생성
    
    php artisan make:controller ProjectTasksController
    
    [2] 확인과정1 
    
    <?php
    
    namespace App\Http\Controllers;
    
    use App\Task;
    use Illuminate\Http\Request;
    
    class ProjectTasksController extends Controller
    {
        public function update(Task $task){
            dd($task);
        }
    }
    
    * 체크박스를 눌렀을때 잘 가는지 확인과정

    
    [3] 확인과정2
    
    <?php
    
    namespace App\Http\Controllers;
    
    use App\Task;
    use Illuminate\Http\Request;
    
    class ProjectTasksController extends Controller
    {
        public function update(Task $task){
            dd(request()->all());
        }
    }

    * 체크박스를 눌렀을때 잘 가는지 확인과정
    
    [4] 실제로직
    
    <?php
    
    namespace App\Http\Controllers;
    
    use App\Task;
    use Illuminate\Http\Request;
    
    class ProjectTasksController extends Controller
    {
        public function update(Task $task){
            $task->update([
                'completed' => request()->has('completed')
            ]);
    
            return back();
        }
    }
    
### [17-2] projects.show 부분 수정

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
    
    
### [18-1] Task Form 만들기  projects.show 
    <form action="/projects/{{$project->id}}/tasks" method="POST">
        @csrf
        <label for="description">새 할일</label>
        <div>
            <input type="text" name="description" placeholder="" />
        </div>
        <div>
            <button type="submit">새 할일 추가</button>
        </div>
    </form>
    
### [18-2] ProjectTasksController.php 에 store 만들기
    [1]
    
    public function store(Project $project){
        $task = new Task();
        $task->description = \request('description');
        $task->project_id = $project->id;
        $task->save();

        return back();
    }
    
    ====================================================
    
    [2]
    
    public function store(Project $project){
        Task::create([
            'description' => \request('description'),
            'project_id' => $project->id,
        ]);
    
        return back();
    }
        
    ====================================================
    
    
### [18-3] ProjectTasksController.php (store)

    [1]
    
    public function store(Project $project){
        $project->addTask(\request('description'));
        return back();
    }
            
    ====================================================
    
    [2]
    public function store(Project $project){
        $attributes = \request()->validate([
            'description' => 'required'
        ]);
        $project->addTask($attributes);
        return back();
    }
    
    
### [18-4] Project.php : model

    [1]
    
    public function addTask($description){

        return Task::create([
            'description' => \request('description'),
            'project_id' => $this->id,
        ]);
    }
                
    ====================================================
    
    [2]
    
    public function addTask($task){

        $this->tasks()->create($task);
    }
       
### [18-5] projects.show task 부분 수정
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
    
    
### [19-1] ProjectTasksController.php
    public function update(Task $task){
        $task->complete(\request()->has('completed'));
        return back();
    }
    
### [19-2] Task.php
    <?php
    
    namespace App;
    
    use Illuminate\Database\Eloquent\Model;
    
    class Task extends Model
    {
        protected $guarded = [];
    
        public function complete($completed = true){
            $this->update(['completed' => $completed]);
        }
    
        public function incomplete(){
            $this->update(['completed' => false]);
        }
        public function project(){
            return $this->belongsTo(Project::class);
        }
    
    
    }

    
### [19-3] ProjectTasksController.php
    [1]
    
    public function update(Task $task){
        if(request()->has('completed')){
            $task->complete();
        }else{
            $task->incomplete();
        }
        return back();
    }
    
    [2]
    
    public function update(Task $task){
        $completeCheck = \request()->has('completed') ? 'complete' : 'incomplete';
        $task->$completeCheck();

        return back();
    }
