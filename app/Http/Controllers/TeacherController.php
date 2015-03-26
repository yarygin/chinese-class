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
        $students_id = is_null(Request::input('students'))?Array():Request::input('students');
        $allStudents = Student::find($students_id);
        // TODO: Изменить этот кошмарный (но рабочий) запрос

  		// select * from 
		// teachers
		// inner join
		// (select teacher_id, count(student_id) as student_count
		// from student_teacher 
		// group by teacher_id) as D_all
		// on teachers.id = teacher_id
		// inner join 	
		// (select teacher_id as t_id, count(student_id) as  s_count
		// from student_teacher 
		// where student_id in (".implode(',', $students_id).")
		// group by teacher_id) as D_need
		// on D_need.t_id = D_all.teacher_id AND D_need.s_count = D_all.student_count

		$d_all = DB::table('student_teacher')
					->select(DB::raw('teacher_id, count(student_id) as student_count'))
					->groupBy('teacher_id');
		$d_need = DB::table('student_teacher')
					->select(DB::raw('teacher_id, count(student_id) as student_count'))
					->whereIn('student_id',$students_id)
					->groupBy('teacher_id');

		$teachers = Teacher::select()
					->join(DB::raw("({$d_all->toSQL()}) as D_all"), function($join) {
						$join->on('id', '=', 'D_all.teacher_id');
					})
					->join(DB::raw("({$d_need->toSQL()}) as D_need"), function($join) {
						$join->on('D_all.teacher_id', '=', 'D_need.teacher_id');
					})
					->mergeBindings($d_need)
					->whereRaw('D_all.student_count = D_need.student_count')->get();
        return View::make('teacher_filter_result')->withStudents($allStudents)->withTeachers($teachers);
    }
}
