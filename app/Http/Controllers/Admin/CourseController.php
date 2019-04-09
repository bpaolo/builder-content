<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Project;
use App\Models\Maquineta;

class CourseController extends Controller
{
    public function index(){
    	return view('admin.course.index');
    }

    public function getCourseById($Id, Course $Course){
        return $Course->getCourseById($Id);
    }

    public function add(Request $request, Course $Course){
    	
    	//auth()->user()->Course;
    	//dd(auth()->user());
    	try {
        
            $name = $request->courseName;
            $projectId = $request->projectId;
            $maquinetaId = $request->maquinetaId;
            $id = $Course->addCourse($name,$projectId,$maquinetaId);  
            return redirect('/home/admin/module/listModule/'.$id);

        } catch (Exception $e) {
            
        }
    }

    public function listProject(Request $request){
        
        try {


            $project = new Project();
            $maquineta = new Maquineta();
            $project = $project->getProject()[0];
            $maquin  = $maquineta->list()[0];
                        
            $result = (object)[
                'projectId' => $project->id,
                'projectName' => $project->name,
                'maquinetaId' => $maquin->id,
                'maquinetaName' => $maquin->name
                ];    

            return view('admin.course.listProject', compact('result'));
              
        } catch (Exception $e) {
            
        }
                
    }


    public function getCourseByProjectIdAndMaquinetaID($projectID, $maquinetaId)
    {
        try {

            $course = new Course();
            return $course->getCourseByProjectIdAndMaquinetaID($projectID, $maquinetaId);
        
        } catch (Exception $e) {
            
        }
        
    }
}
