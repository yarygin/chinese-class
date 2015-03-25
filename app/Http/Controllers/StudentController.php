<?php namespace chineseClass\Http\Controllers;

use Request;;
use View;
use chineseClass\Models\Student;

class StudentController extends Controller {

	/**
	 * Show teacher list to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $students = Student::get();
        return View::make("students_list")->withStudents($students);
	}

	/**
	 * Show single teacher to the user.
	 *
	 * @return Response
	 */
	public function show($id)
	{
        $student = Student::find($id);
        $teachers = $student->teachers()->get();
        return View::make("student")->withTeachers($teachers)->withStudent($student);
	}

	/**
	 * Show single teacher to the user.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make("student_create");
	}

	/**
	 * Show single teacher to the user.
	 *
	 * @return Response
	 */
	public function store()
	{
		Student::create(['name' => Request::input('name')]);
        return redirect('teachers');
	}
}
