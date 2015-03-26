<?php namespace chineseClass\Http\Controllers;

use Request;;
use View;
use chineseClass\Models\Student;

class StudentController extends Controller {

	/**
	 * Show students list to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $students = Student::get();
        return View::make("students.index")
        	->withStudents($students);
	}

	/**
	 * Show single student to the user.
	 *
	 * @return Response
	 */
	public function show($id)
	{
        $student = Student::find($id);
        $teachers = $student->teachers()->get();
        return View::make("students.show")
        	->withTeachers($teachers)
        	->withStudent($student);
	}

	/**
	 * Show new student form to the user.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make("students.create");
	}

	/**
	 * Save student to the db.
	 *
	 * @return Response
	 */
	public function store()
	{
		Student::create(['name' => Request::input('name')]);
        return redirect('teachers');
	}
}
