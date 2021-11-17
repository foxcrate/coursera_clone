<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{

    public function index(){
        if(Auth::user()->level != 0 ){
            return redirect()->route('dashboard');
        }
        $all_teachers = Teacher::orderBy('id','desc')->paginate(5);
        //$all_lessons = "Alo";

        //return $all_lessons;
        return view('admin.teachers.index')->with('teachers',$all_teachers) ;
    }

    public function add(Request $request){
        if(Auth::user()->level != 0 ){
            return redirect()->route('dashboard');
        }
        //return $request;
        if($request->has('image')){
            $image = $request->image;
            $code = rand(1111111, 9999999);
            $image_new_name=time().$code ."tp";
            $image->move('uploads/teachers/', $image_new_name);
        }
        $new_teacher = Teacher::create([
            'name'=>$request->name,
            'image'=>'uploads/teachers/' . $image_new_name,
            'bio'=>$request->bio,
        ]);

        return redirect()->back();

    }

    public function edit(Request $request){
        if(Auth::user()->level != 0 ){
            return redirect()->route('dashboard');
        }
        //return $request;
        //echo $request;
        $my_teacher = Teacher::find($request->id);
        //return $request->name;
        $my_teacher->name = $request->name ;
        if($request->has('image')){
            $image = $request->image;
            $code = rand(1111111, 9999999);
            $image_new_name=time().$code ."tp";
            $image->move('uploads/teachers/', $image_new_name);
            $my_teacher->image ='uploads/teachers/' . $image_new_name;
        }
        $my_teacher->bio = $request->bio ;
        $my_teacher->save();

        return redirect()->back();
    }

    public function data_to_edit(Request $request){
        if(Auth::user()->level != 0 ){
            return redirect()->route('dashboard');
        }
        $the_teacher = Teacher::find($request->id);

        return $the_teacher;

    }

    public function delete(Request $request){
        if(Auth::user()->level != 0 ){
            return redirect()->route('dashboard');
        }
        $my_teacher = Teacher::find($request->id);
        // $my_course = Semester::destroy($request->id);
        // return $my_course;
        $c = $my_teacher->delete();
        //return $c;

        return redirect()->back();
    }

}
