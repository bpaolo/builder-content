<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectController extends Controller
{
    public function getProjectById($Id, Project $Project){
        return $Project->getProjectById($Id);
    }

    public function index(){
    	return view('admin.project.index');
    }

    public function add(){
    	return view('admin.project.add');
    }

    public function addProject(Request $request, Project $project){
    	
        try {
            //auth()->user()->project;
            //dd(auth()->user());
            $name = $request->name;
            $project->addProject($name);
            return redirect('/home/admin/course/listProject');
            
        } catch (Exception $e) {
            
        }
    }    

            	
            
}
