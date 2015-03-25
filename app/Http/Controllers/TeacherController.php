<?php namespace chineseClass\Http\Controllers;

use Request;
use View;
use DB;
use chineseClass\Models\Teacher;
use chineseClass\Models\Student;
use Response;

class TeacherController extends Controller {

    /**
     * Show teacher list to the user.
     *
     * @return Response
     */
    public function index()
    {
        $teachers = Teacher::get();
        return View::make("teachers_list")->withTeachers($teachers);
    }

    /**
     * Show teacher list to the user.
     *
     * @return Response
     */
    public function edit($id)
    {
        $teacher = Teacher::find($id);
        $allStudents = Student::all();
        $checkedStudents = $teacher->students()->lists('id');
        return View::make("teacher_edit")
            ->withTeacher($teacher)
            ->withStudents($allStudents)
            ->withChecked($checkedStudents);
    }

    /**
     * Show single teacher to the user.
     *
     * @return Response
     */
    public function show($id)
    {
        $teacher = Teacher::find($id);
        $students = $teacher->students;
        return View::make("teacher")->withTeacher($teacher)->withStudents($students);
    }

    /**
     * Show single teacher to the user.
     *
     * @return Response
     */
    public function create()
    {
        $allStudents = Student::all();
        return View::make("teacher_create")->withStudents($allStudents);
    }

    /**
     * Show single teacher to the user.
     *
     * @return Response
     */
    public function store()
    {
        $teacher = Teacher::create(['name' => Request::input('name')]);
        $teacher->students()->sync(Request::input('students'));
        $teacher->save();
        return redirect('teachers');
    }

    /**
     * Show single teacher to the user.
     *
     * @return Response
     */
    public function update($id)
    {
        $teacher = Teacher::find($id);
        $teacher->name = Request::input('name');
        $students = is_null(Request::input('students'))?Array():Request::input('students');
        $teacher->students()->sync($students);
        $teacher->save();
        return redirect('teachers/'.$id);
    }

    /**
     * Show single teacher to the user.
     *
     * @return Response
     */
    public function filter()
    {
    	$teachers = Request::input('teachers');
        $allStudents = Student::all();
        return View::make("teacher_filter")->withStudents($allStudents);
    }

    /**
     * Show single teacher to the user.
     *
     * @return Response
     */
    public function sharedStudents()
    {
        $students = is_null(Request::input('students'))?Array():Request::input('students');
        $allStudents = Student::whereIn('id', $students)->get();
        DB::enableQueryLog();
        $allTeachers = Teacher::whereHas('students', function($q) use ($students)
        {
            $q->whereIn('id', $students);
        })->get();
        $queries = DB::getQueryLog();
        print_r($queries);
        // return View::make('teacher_filter_result')->withStudents($allStudents)->withTeachers($allTeachers);
    }
}
