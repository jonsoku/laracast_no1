<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project){
        $attributes = \request()->validate([
            'description' => 'required'
        ]);
        $project->addTask($attributes);
        return back();
    }

    public function update(Task $task){
        $completeCheck = \request()->has('completed') ? 'complete' : 'incomplete';
        $task->$completeCheck();

        return back();
    }
}
