<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'description', 'owner_id'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function addTask($task){

        $this->tasks()->create($task);

//        return Task::create([
//            'description' => \request('description'),
//            'project_id' => $this->id,
//        ]);
    }
}
