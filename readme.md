###Laravel 5.7버전 설치
    composer create-project --prefer-dist laravel/laravel blog "5.7.*"
### 1) .env 설정
    DB_CONNECTION=mysql
    DB_HOST=laravel.cim78dtgz3dv.ap-northeast-1.rds.amazonaws.com
    DB_PORT=3306
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=


### 2) 테이블 생성
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

### 3) projects 테이블 생성
    php artisan make:migration create_projects_table
    
### 4) projects 테이블에 컬럼추가
    4-1)
    Schema::create('projects', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->text('description');
        $table->timestamps();
    });
    
    4-2)
    php artisan migrate
### 5)
