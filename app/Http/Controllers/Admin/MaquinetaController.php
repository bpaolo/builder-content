<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Maquineta;

class MaquinetaController extends Controller
{
    public function getMaquinetaById($Id, Maquineta $Maquineta){
        return $Maquineta->getMaquinetaById($Id);
    }

    public function index(){
    	return view('admin.maquineta.index');
    }

    public function add(){
    	return view('admin.maquineta.add');
    }

    public function list(maquineta $maquineta){
    	
        try {
        
            $maquineta = $maquineta->list(); 
            return view('admin.maquineta.list', compact('maquineta'));   
        
        } catch (Exception $e) {
            
        }
    }
}
