<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    
    public function index(){
        $all_books= Book::all();
        //$all_lessons = "Alo";
        
        //return $all_lessons;
        return view('admin.books.index')->with('books',$all_books) ;
    }

    public function add(Request $request){
        //return $request;
        if($request->has('cover')){
            $extension = $request->file('cover')->extension();
            $image = $request->cover;
            $code = rand(1111111, 9999999);
            $image_new_name=time().$code ."bc".'.'.$extension;
            $image->move('uploads/books/', $image_new_name);
        }
        if($request->has('abstract_file')){
            $extension = $request->file('abstract_file')->extension();
            $abstract_file = $request->abstract_file;
            $code = rand(1111111, 9999999);
            $abstract_new_name=time().$code ."ba".'.'.$extension;
            $abstract_file->move('uploads/books/', $abstract_new_name);
        }
        if($request->has('full_file')){
            $extension = $request->file('full_file')->extension();
            $full_file = $request->full_file;
            $code = rand(1111111, 9999999);
            $full_new_name=time().$code ."bf".'.'.$extension;
            $full_file->move('uploads/books/', $full_new_name);
        }

        $new_book = Book::create([
            'cover'=>'uploads/books/' . $image_new_name,
            'name'=>$request->name,
            'abstract_file'=> 'uploads/books/' . $abstract_new_name,
            'full_file'=> 'uploads/books/' . $full_new_name,
            'cost'=>$request->cost,
        ]);
        
        return redirect()->back();

    }

    public function edit(Request $request){
        //return $request;
        //echo $request;
        $my_book = Book::find($request->id);
        //return $request->name;
        //$my_service->photo = $request->photo ;
        
        //sreturn $extension;
        if($request->has('cover')){
            $extension = $request->file('cover')->extension();
            $image = $request->cover;
            $code = rand(1111111, 9999999);
            $image_new_name=time().$code ."bc" .'.'.$extension;
            $image->move('uploads/books/', $image_new_name);
            $my_book->cover ='uploads/books/' . $image_new_name;
        }
        if($request->has('abstract_file')){
            $extension = $request->file('abstract_file')->extension();
            $abstract_file = $request->abstract_file;
            $code = rand(1111111, 9999999);
            $abstract_new_name=time().$code ."ba".'.'.$extension;
            $abstract_file->move('uploads/books/', $abstract_new_name);
            $my_book->abstract_file ='uploads/books/' . $abstract_new_name;
        }
        if($request->has('full_file')){
            $extension = $request->file('full_file')->extension();
            $full_file = $request->full_file;
            $code = rand(1111111, 9999999);
            $full_new_name=time().$code ."bf".'.'.$extension;
            $full_file->move('uploads/books/', $full_new_name);
            $my_book->full_file ='uploads/books/' . $full_new_name;
        }
        $my_book->name = $request->name ;
        $my_book->cost = $request->cost ;
        $my_book->save();

        return redirect()->back();
    }

    public function data_to_edit(Request $request){

        $the_book = Book::find($request->id);

        return $the_book;

    }

    public function delete(Request $request){
        $my_book = Book::find($request->id);
        // $my_course = Semester::destroy($request->id);
        // return $my_course;
        $c = $my_book->delete();
        //return $c;

        return redirect()->back();
    }


}
