<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index(){
        $projects = \App\Project::all();
        return view('projects.index',[
            'projects' => $projects
        ]);
    }

    public function create(){
        return view('projects.create');
    }

    public function store(){
        $attributes = \request()->validate([
            'title' => ['required','min:2'],
            'description' => ['required', 'min:2'],
        ]);
        Project::create($attributes);

        return redirect('/projects');
    }

    public function show(Project $project){
        return view('projects.show',[
            'project' => $project
        ]);
    }

    public function edit(Project $project){

        return view('projects.edit', [
            'project' => $project
        ]);
    }

    public function update(Project $project){

        $attributes = \request()->validate([
            'title' => ['required','min:2'],
            'description' => ['required', 'min:2'],
        ]);
        $project->update($attributes);

        return redirect('/projects');

    }

    public function destroy(Project $project){
        $project->delete();
        return redirect('/projects');
    }
}
