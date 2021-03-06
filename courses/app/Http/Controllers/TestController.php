<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Calender;
use App\Models\Course;
use App\Models\Cycle;
use App\Models\CourseQuestion;
use App\Models\Student;
use App\Models\Book;
use App\Models\CyclePayment;
use App\Models\Lesson;
use App\Models\LessonQuestion;
use App\Models\Semester;
use App\Models\Teacher;
use App\Models\Project;
use App\Models\Service;
use App\Models\ServicePayment;
use App\Models\UploadedResearch;

class TestController extends Controller
{
    public function test(){

        // $c1 = Cycle::find(4);

        // return $c1->project->image; 

        // $cp1 = CyclePayment::create([

        //     'due_date' => '2021-7-4',
        //     'amount_paid' => 43,
        //     'amount_left' => 43,
        //     'note' => 'first',
        //     'status' => 'accepted',
        //     'file' => 'first',
        //     'student_id' => 4,
        //     'cycle_id' => 4,

        // ]);

        // $cp2 = CyclePayment::create([

        //     'due_date' => '2021-10-9',
        //     'amount_paid' => 43,
        //     'amount_left' => 43,
        //     'note' => 'first',
        //     'status' => 'accepted',
        //     'file' => 'first',
        //     'student_id' => 4,
        //     'cycle_id' => 3,

        // ]);


        $p1 = Project::find(2);
        // // return $p1->semesters;

        // $s1 = Semester::find(1);
        // $s2 = Semester::find(3);

        $c1 = book::find(1);
        $c2 = book::find(2);
        $s2  =Student::find(4);

        //$s2->books()->attach([$c1->id,$c2->id]);
        // $p1->cycle_id = $c1->id;
        // $p1->save();
        //return $s2->cycles;
        
        // $t1 = Teacher::create([
        //     'name'=>'one',
        //     'image'=>'one',
        //     'bio'=>'one',
        // ]);
        // $t2 = Teacher::create([
        //     'name'=>'two',
        //     'image'=>'one',
        //     'bio'=>'one',
        // ]);
        // $t3 = Teacher::create([
        //     'name'=>'three',
        //     'image'=>'one',
        //     'bio'=>'one',
        // ]);
        // $t4 = Teacher::create([
        //     'name'=>'four',
        //     'image'=>'one',
        //     'bio'=>'one',
        // ]);
    
        // $c1 = Course::find(1);
        // $c1->teachers()->attach([$t1->id,$t3->id]);

        // $s1 = Service::create([
        //     'photo'=> 'first' ,
        //     'name'=> 'first' ,
        //     'cost'=> 23,
        //     'summery'=> 'first' ,
        //     'details'=> 'first' ,
        // ]);
        
        // $s2 = Service::create([
        //     'photo'=> 'second' ,
        //     'name'=> 'second' ,
        //     'cost'=> 355,
        //     'summery'=> 'second' ,
        //     'details'=> 'second' ,
        // ]);

        // $sp1 = ServicePayment::create([
        //     'note'=>'first',
        //     'file'=> 'first',
        //     'money_paid'=> 44,
        //     'status'=>'accepted',
        //     'student_id'=>1,
        //     'service_id'=>1,
        // ]);

        // $sp2 = ServicePayment::create([
        //     'note'=>'second',
        //     'file'=> 'second',
        //     'money_paid'=> 653,
        //     'status'=>'accepted',
        //     'student_id'=>1,
        //     'service_id'=>2,
        // ]);

        // $p1 = $new_project = Project::create([
        //     'name'=>' first',
        //     'image'=>' first',
        //     'type'=>'phd',
        //     'video'=>' first',
        //     'price'=>1554,
        //     'summery'=>' first',
        // ]);

        // $p2 = $new_project = Project::create([
        //     'name'=>' first',
        //     'image'=>' first',
        //     'type'=>'master',
        //     'video'=>' first',
        //     'price'=>1554,
        //     'summery'=>' first',
        // ]);

        // $p3 = $new_project = Project::create([
        //     'name'=>' first',
        //     'image'=>' first',
        //     'type'=>'diploma',
        //     'video'=>' first',
        //     'price'=>1554,
        //     'summery'=>' first',
        // ]);

        // $p4 = $new_project = Project::create([
        //     'name'=>' first',
        //     'image'=>'fellowship',
        //     'type'=>'fellowship',
        //     'video'=>' first',
        //     'price'=>1554,
        //     'summery'=>' first',
        // ]);

    }
}