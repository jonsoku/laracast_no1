###Laravel 5.7버전 설치
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
### [7-6] view 페이지 생성
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
        <ul>
            @foreach($projects as $project)
                <li>{{$project->title}}</li>
                <li>{{$project->description}}</li>
            @endforeach
        </ul>
    @endsection
###
    
