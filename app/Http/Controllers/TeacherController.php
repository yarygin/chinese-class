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
        $alike = $this->alikeTeachers();
        return View::make("teachers.index")
        	->withTeachers($teachers)
        	->withAlike($alike);
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
        return View::make("teachers.edit")
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
        return View::make("teachers.show")
        	->withTeacher($teacher)
        	->withStudents($students);
    }

    /**
     * Show single teacher to the user.
     *
     * @return Response
     */
    public function create()
    {
        $allStudents = Student::all();
        return View::make("teachers.create")
        	->withStudents($allStudents);
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
        return View::make("teachers.teacher_filter")
        	->withStudents($allStudents);
    }

    /**
     * Show single teacher to the user.
     *
     * @return Response
     */
    public function uniqueStudents()
    {
        $students_id = is_null(Request::input('students'))?Array():Request::input('students');
        $students = Student::find($students_id);
        // TODO: Изменить этот кошмарный (но рабочий) запрос

  		// SELECT * FROM 
		// teachers
		// INNER JOIN
		// (SELECT teacher_id, count(student_id) AS student_count
		// FROM student_teacher 
		// GROUP BY teacher_id) AS D_all
		// ON teachers.id = teacher_id
		// INNER JOIN 	
		// (SELECT teacher_id AS t_id, count(student_id) AS  s_count
		// FROM student_teacher 
		// WHERE student_id in (:students_id))
		// GROUP BY teacher_id) AS D_need
		// ON D_need.t_id = D_all.teacher_id AND D_need.s_count = D_all.student_count

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
        return View::make('teachers.teacher_filter_result')
        	->withStudents($students)
        	->withTeachers($teachers);
    }

    /**
     * Show single teacher to the user.
     *
     * @return array of Teacher
     */
    protected function alikeTeachers()
    {
    	// берётся первый попавшийся
  		// SELECT ST1.teacher_id, ST2.teacher_id, count(ST1.student_id) AS student_count
		// FROM student_teacher AS ST1
		// INNER JOIN student_teacher AS ST2
		// ON ST1.student_id = ST2.student_id
		// WHERE
		// ST1.teacher_id <> ST2.teacher_id
		// GROUP BY ST1.teacher_id, ST2.teacher_id
		// ORDER BY count(ST1.student_id) DESC 
		// LIMIT 1
		$teachers_id = DB::table('student_teacher AS ST1')
					   ->select(DB::raw('ST1.teacher_id as teacher_id_1, ST2.teacher_id as teacher_id_2, count(ST1.student_id) AS student_count'))
					   ->join('student_teacher AS ST2', 'ST1.student_id', '=','ST2.student_id')
					   ->whereRaw('ST1.teacher_id <> ST2.teacher_id')
					   ->groupBy('ST1.teacher_id')
					   ->groupBy('ST2.teacher_id')
					   ->orderBy(DB::raw('count(ST1.student_id)'),'DESC')
					   ->first();
		$teachers = Teacher::find([$teachers_id->teacher_id_1, $teachers_id->teacher_id_2]);
		return $teachers;
    }
}
