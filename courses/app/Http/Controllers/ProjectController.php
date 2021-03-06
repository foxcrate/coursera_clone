<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Semester;
use phpDocumentor\Reflection\PseudoTypes\True_;
use App\Services\PayUService\Exception;
use SebastianBergmann\Environment\Console;

class ProjectController extends Controller
{
    public function index(){
        $all_projects = Project::all();
        
        //return $all_cycles;
        return view('admin.projects.index')->with('projects',$all_projects) ;
    }

    public function add(Request $request){

        // $new_project = Project::create([
        //     'name'=>$request->name,
        //     'image'=>$request->image,
        //     'type'=>$request->type,
        //     'video'=>$request->video,
        //     'price'=>$request->price,
        //     'summery'=>$request->summery,
        // ]);
        //return $request;

        $new_project = new Project();

        $new_project->name = $request->name;
        //$new_project->image = $request->image;
        if ($request->hasFile('image')) {
            //$destinationPath = 'path/th/save/file/';
            $image = $request->image;
            $code = rand(1111111, 9999999);
            $image_new_name=time().$code ."pp";
            $image->move('uploads/projects/', $image_new_name);
            $new_project->image ='uploads/projects/' . $image_new_name;
        }
        else{
            $new_project->image =null;
        }

        $new_project->type = $request->type;
        //$new_project->video = $request->video;
        if ($request->hasFile('video')) {
            //$destinationPath = 'path/th/save/file/';
            $video = $request->video;
            $code = rand(1111111, 9999999);
            $video_new_name=time().$code ."pv";
            $video->move('uploads/projects/', $video_new_name);
            $new_project->video ='uploads/projects/' . $video_new_name;
        }
        else{
            $new_project->video =null;
        }

        $new_project->price = $request->price;
        $new_project->summery = $request->summery;
        $saved = $new_project->save();

        
        
        if($saved){
            return redirect()->back();
        }else{
            return redirect()->back()->with('error',"Didn't save the record");
        }

    }

    public function edit(Request $request){
        //return $request;
        // try{
        // $array = array("image" => $_FILES['image'], "video" => $_FILES['video']);
        // }catch (\Exception $e) {
                //echo $e;
        // }
        $my_project = Project::find($request->id);

       

        // $my_project = Project::find($request->id);
        // return $request->name;

        

        $my_project->name = $request->name;
        $my_project->price = $request->price;
        $my_project->summery = $request->summery;
        //$new_project->image = $request->image;

        // $my_project->save();

        // return response(200);

        $my_project->type = $request->type;
        //$new_project->video = $request->video;

        if($request->has('ajax')){
            //return "Alo";
            try{
                $code = rand(1111111, 9999999);
                $file = time().$code ."pp" ;
                $file_loc = $_FILES['image']['tmp_name'];
                $folder="uploads/projects/";
                move_uploaded_file($file_loc,$folder.$file);
                $my_project->image ='uploads/projects/' . $file;
    
            }catch (\Exception $e) {
                //echo $e;
            }
    
            try{
                $code = rand(1111111, 9999999);
                $file = time().$code ."pv" ;
                $file_loc = $_FILES['video']['tmp_name'];
                $folder="uploads/projects/";
                move_uploaded_file($file_loc,$folder.$file);
                $my_project->video ='uploads/projects/' . $file;
    
            }catch (\Exception $e) {
                //echo $e;
            }

            if($request->has('semesters_array')){
                // if($request->semesters_array == null){
                //     $request->semesters_array ='';
                // }
                //return "bst";
                $current_semester_array = [];
                // return $my_project->semesters[0]->id;
    
                if( count($my_project->semesters)  > 0){
                    foreach( $my_project->semesters as $semester ){
                        array_push( $current_semester_array , $semester->id );
                    }
                    
                    $my_project->semesters()->detach($current_semester_array);
                }

                if($request->semesters_array != null){
                    $x= explode(",",$request->semesters_array);
                    //return $x;
                    if( count( $x ) >0){
                        //return $x;
                        for( $i=0 ; $i<count($x) ; $i++ ){
                            $x[$i] = (int)$x[$i] ;
                        }
                        $my_project->semesters()->attach($x);
                    }
                }
        
            }

        }else{
            if($request->has('video') && $request->video != 'undefined' && $request->video !=''){
                $video = $request->video;
                $code = rand(1111111, 9999999);
                $video_new_name=time().$code ."pv";
                $video->move('uploads/projects/', $video_new_name);
                $my_project->video ='uploads/projects/' . $video_new_name;
            }

            if($request->has('image') && $request->image != 'undefined' && $request->image !='' ){
                $image = $request->image;
                $code = rand(1111111, 9999999);
                $image_new_name=time().$code ."pp";
                $image->move('uploads/projects/', $image_new_name);
                $my_project->image ='uploads/projects/' . $image_new_name;
            }

            if($request->has('semesters_array')){
                //return $request->semesters_array;
                $current_semester_array = [];
                // return $my_project->semesters[0]->id;
    
                if( count($my_project->semesters) > 0){
                    foreach( $my_project->semesters as $semester ){
                        array_push( $current_semester_array , $semester->id );
                    }
                    
                    $my_project->semesters()->detach($current_semester_array);
                }
                //return $request->semesters_array;
                // $x= explode(",",$request->semesters_array);
                $x = $request->semesters_array;
                for( $i=0 ; $i<count($x) ; $i++ ){
                    $x[$i] = (int)$x[$i] ;
                }
                $my_project->semesters()->attach($x);
    
            }

        }
        
        $my_project->save();

        return back();
    }

    public function mass_edit(Request $request){
        //return $request;
        $my_project = Project::find($request->id);

        if($request->has('semesters_array')){
            //return $request->semesters_array;
            $current_semester_array = [];
            // return $my_project->semesters[0]->id;

            if( count($my_project->semesters) > 0){
                foreach( $my_project->semesters as $semester ){
                    array_push( $current_semester_array , $semester->id );
                }
                
                $my_project->semesters()->detach($current_semester_array);
            }
            //return $request->semesters_array;
            // $x= explode(",",$request->semesters_array);
            $x = $request->semesters_array;
            for( $i=0 ; $i<count($x) ; $i++ ){
                $x[$i] = (int)$x[$i] ;
            }
            $my_project->semesters()->attach($x);

        }
        return back();

    }

    public function delete(Request $request){
        $my_project = Project::find($request->id);
        // $my_cycle = Cycle::destroy($request->id);
        // return $my_cycle;
        $p = $my_project->delete();
        //return $c;

        return response(200);;
    }

    public function details($id){

        $project = Project::find($id);
        $project_semesters = $project->semesters ;
        $all_semesters = Semester::all();

        $array_of_semesters = array();
        $x=count($project_semesters);
        for($i = 0;$i<=$x-1;$i++){
            array_push($array_of_semesters ,$project_semesters[$i]->id );
        }
        
        //return $array_of_semesters;
        return view('admin.projects.details')->with(['semesters'=>$all_semesters , 'project'=>$project , 'array_of_semesters'=>$array_of_semesters ]) ;

    }

    public function data_to_edit(Request $req){
        $project = Project::find($req->id);
        return $project;
    }

}
