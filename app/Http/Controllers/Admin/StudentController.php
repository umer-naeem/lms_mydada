<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Enrollment;
use App\Models\Instructor;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Attendance;
use App\Models\AssignmentSubmit;
use App\Models\Course_lecture_views;
use App\Models\StudentFeedback;
use App\Models\StudentLeaveRequest;
use App\Models\StudentLevelHistory;
use App\Models\Ticket;
use App\Models\State;
use App\Models\Student;
use App\Models\User;
use App\Tools\Repositories\Crud;
use App\Traits\General;
use App\Traits\ImageSaveTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    use General, ImageSaveTrait;

    protected $studentModel;
    public function __construct( Student $student)
    {
        $this->studentModel = new Crud($student);
    }
    public function index()
    {
        $data['title'] = 'All Student';
        $data['students'] = $this->studentModel->getOrderById('DESC', 25);
        return view('admin.student.list', $data);
    }

    public function pending_list()
    {
        $data['title'] = 'Pending Student';
        $data['students'] = Student::where('status', STATUS_PENDING)->orderBy('id', 'DESC')->paginate(25);
        return view('admin.student.pending_list', $data);
    }

    public function create()
    {
        $data['title'] = 'Add Student';
        $data['countries'] = Country::orderBy('country_name', 'asc')->get();

        if (old('country_id')) {
            $data['states'] = State::where('country_id', old('country_id'))->orderBy('name', 'asc')->get();
        }

        if (old('state_id')) {
            $data['cities'] = City::where('state_id', old('state_id'))->orderBy('name', 'asc')->get();
        }
        return view('admin.student.add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:2'],
            'area_code' => 'required',
            'phone_number' => 'bail|numeric|unique:users,mobile_number',
            'address' => 'required',
            'gender' => 'required',
            'about_me' => 'required',
            'image' => 'mimes:jpeg,png,jpg|file|dimensions:min_width=300,min_height=300,max_width=300,max_height=300|max:1024',
            'student_id' => 'nullable|string|max:100|unique:students,student_id',
            // 'roll_no' validation hata diya kyunki auto-generate hoga
            'current_level' => 'nullable|string|max:100',
            'admission_date' => 'nullable|date'
        ]);

        // Auto-generate Roll Number using the model method
        //$roll_no = Student::generateAdvancedRollNumber($request);
        $roll_no = Student::generateAdvancedRollNumber($request);

        // Agar advanced method kaam na kare to simple method use karo
        // $roll_no = Student::generateSimpleRollNumber();

        $user = new User();
        $user->name = $request->first_name . ' '. $request->last_name;
        $user->email = $request->email;
        $user->area_code =  str_replace("+","",$request->area_code);
        $user->mobile_number = $request->phone_number;
        $user->phone_number = $request->phone_number;
        $user->email_verified_at = now();
        $user->password = Hash::make($request->password);
        $user->role = 3;
        $user->image =  $request->image ? $this->saveImage('user', $request->image, null, null) :   null;
        $user->save();

        $student_data = [
            'user_id' => $user->id,
            'student_id' => $request->student_id,
            'roll_no' => $roll_no, // Auto-generated roll number
            'current_level' => $request->current_level,
            'admission_date' => $request->admission_date,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'phone_number' => $user->phone_number,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'gender' => $request->gender,
            'about_me' => $request->about_me,
            'postal_code' => $request->postal_code,
        ];

        $this->studentModel->create($student_data);

        $this->showToastrMessage('success', __('Student created successfully'));
        return redirect()->route('student.index');
    }

    public function view($uuid)
    {
        $data['title'] = 'Student Profile';
        $data['student'] = $this->studentModel->getRecordByUuid($uuid);
        $data['enrollments'] = Enrollment::where('user_id', $data['student']->user_id)->whereNotNull('course_id')->latest()->paginate(15);
        $data['attendanceRecords'] = Attendance::where('user_id', $data['student']->user_id)->latest()->take(50)->get();
        $data['assignmentSubmissions'] = AssignmentSubmit::where('user_id', $data['student']->user_id)->latest()->take(50)->get();
        $data['supportTickets'] = Ticket::where('user_id', $data['student']->user_id)->latest()->take(50)->get();
        $data['devices'] = $data['student']->user ? $data['student']->user->device : collect();
        $data['leaveRequests'] = StudentLeaveRequest::where('student_id', $data['student']->id)->latest()->get();
        $data['feedbacks'] = StudentFeedback::where('student_id', $data['student']->id)->latest()->get();
        $data['levelHistories'] = StudentLevelHistory::where('student_id', $data['student']->id)->latest()->get();

        $lectureViews = Course_lecture_views::where('user_id', $data['student']->user_id)
            ->select('course_id')
            ->selectRaw('count(distinct course_lecture_id) as viewed_count')
            ->groupBy('course_id')
            ->pluck('viewed_count', 'course_id');

        $data['progressByCourse'] = $data['enrollments']->getCollection()->mapWithKeys(function ($enrollment) use ($lectureViews) {
            $totalLectures = $enrollment->course ? $enrollment->course->lectures()->count() : 0;
            $viewed = $lectureViews[$enrollment->course_id] ?? 0;
            $percentage = $totalLectures > 0 ? round(($viewed / $totalLectures) * 100) : 0;
            return [$enrollment->course_id => [
                'total' => $totalLectures,
                'viewed' => $viewed,
                'percentage' => $percentage,
            ]];
        });

        return view('admin.student.view', $data);
    }

    public function edit($uuid)
    {
        $data['title'] = 'Edit Student';
        $data['student'] = $this->studentModel->getRecordByUuid($uuid);
        $data['user'] = User::findOrfail($data['student']->user_id);

        $data['countries'] = Country::orderBy('country_name', 'asc')->get();

        if (old('country_id'))
        {
            $data['states'] = State::where('country_id', old('country_id'))->orderBy('name', 'asc')->get();
        }

        if (old('state_id'))
        {
            $data['cities'] = City::where('state_id', old('state_id'))->orderBy('name', 'asc')->get();
        }

        return view('admin.student.edit', $data);
    }

    public function update(Request $request, $uuid)
    {
        $student = $this->studentModel->getRecordByUuid($uuid);

        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$student->user_id],
            'area_code' => 'required',
            'phone_number' => 'bail|numeric|unique:users,mobile_number,'.$student->user_id,
            'address' => 'required',
            'gender' => 'required',
            'about_me' => 'required',
            'image' => 'mimes:jpeg,png,jpg|file|dimensions:min_width=300,min_height=300,max_width=300,max_height=300|max:1024',
            'student_id' => 'nullable|string|max:100|unique:students,student_id,'.$student->id,
            'roll_no' => 'nullable|string|max:100',
            'current_level' => 'nullable|string|max:100',
            'admission_date' => 'nullable|date'
        ]);


        $user = User::findOrfail($student->user_id);
        if (User::where('id', '!=', $student->user_id)->where('email', $request->email)->count() > 0) {
            $this->showToastrMessage('warning', __('Email already exist'));
            return redirect()->back();
        }

        $user->name = $request->first_name . ' '. $request->last_name;
        $user->email = $request->email;
        if ($request->password){
            $request->validate([
                'password' => 'required|string|min:6'
            ]);
            $user->password = Hash::make($request->password);
        }
        $user->area_code =  str_replace("+","",$request->area_code);
        $user->mobile_number = $request->phone_number;
        $user->phone_number = $request->phone_number;
        $user->image =  $request->image ? $this->saveImage('user', $request->image, null, null) :   $user->image;
        $user->save();

        $student_data = [
            'user_id' => $user->id,
            'student_id' => $request->student_id,
            'roll_no' => $request->roll_no,
            'current_level' => $request->current_level,
            'admission_date' => $request->admission_date,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'phone_number' => $user->phone_number,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'gender' => $request->gender,
            'about_me' => $request->about_me,
            'postal_code' => $request->postal_code,
        ];

        $this->studentModel->updateByUuid($student_data, $uuid);

        $this->showToastrMessage('success', __('Updated Successfully'));
        return redirect()->route('student.index');
    }

    public function delete($uuid)
    {
        $student = $this->studentModel->getRecordByUuid($uuid);
        $instructor = Instructor::whereUserId($student->user_id)->first();
        if ($instructor){
            $this->showToastrMessage('error', __('You can`t delete it. Because this user already an instructor. If you want to delete, at first you delete from instructor.'));
            return redirect()->back();
        }
        if ($student){
            $this->deleteFile(@$student->user->image);
        }
        User::find($student->user_id)->delete();
        $this->studentModel->deleteByUuid($uuid);

        $this->showToastrMessage('success', __('Deleted Successfully'));
        return redirect()->back();
    }

    public function changeStudentStatus(Request $request)
    {
        $student = Student::findOrFail($request->id);
        $student->status = $request->status;
        $student->save();

        return response()->json([
            'data' => 'success',
        ]);
    }

    public function changeEnrollmentStatus(Request $request)
    {
        $enrollment = Enrollment::findOrFail($request->id);
        $enrollment->status = $request->status;
        $enrollment->save();

        return response()->json([
            'data' => 'success',
        ]);
    }

    public function toggleFreeze(Request $request, $uuid)
    {
        $student = $this->studentModel->getRecordByUuid($uuid);
        $student->account_frozen = !$student->account_frozen;
        $student->frozen_at = $student->account_frozen ? now() : null;
        $student->save();

        $message = $student->account_frozen ? __('Student account frozen.') : __('Student account reactivated.');
        $this->showToastrMessage('success', $message);
        return redirect()->back();
    }

    public function addLevelHistory(Request $request, $uuid)
    {
        $student = $this->studentModel->getRecordByUuid($uuid);
        $request->validate([
            'level' => 'required|string|max:100',
            'notes' => 'nullable|string',
        ]);

        StudentLevelHistory::create([
            'student_id' => $student->id,
            'level' => $request->level,
            'notes' => $request->notes,
            'promoted_by' => Auth::id(),
            'promoted_at' => now(),
        ]);

        $student->current_level = $request->level;
        $student->save();

        $this->showToastrMessage('success', __('Level updated.'));
        return redirect()->back();
    }

    public function addLeaveRequest(Request $request, $uuid)
    {
        $student = $this->studentModel->getRecordByUuid($uuid);
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        StudentLeaveRequest::create([
            'student_id' => $student->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
        ]);

        $this->showToastrMessage('success', __('Leave request added.'));
        return redirect()->back();
    }

    public function approveLeave(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $leave = StudentLeaveRequest::findOrFail($id);
        $leave->status = $request->status;
        $leave->approved_by = Auth::id();
        $leave->approved_at = now();
        $leave->save();

        $this->showToastrMessage('success', __('Leave request updated.'));
        return redirect()->back();
    }

    public function addFeedback(Request $request, $uuid)
    {
        $student = $this->studentModel->getRecordByUuid($uuid);
        $request->validate([
            'course_id' => 'nullable|exists:courses,id',
            'feedback_date' => 'required|date',
            'rating' => 'nullable|integer|min:0|max:5',
            'notes' => 'nullable|string',
        ]);

        StudentFeedback::create([
            'student_id' => $student->id,
            'course_id' => $request->course_id,
            'feedback_date' => $request->feedback_date,
            'rating' => $request->rating ?? 0,
            'notes' => $request->notes,
        ]);

        $this->showToastrMessage('success', __('Feedback saved.'));
        return redirect()->back();
    }
    /**
     * Get states by country ID for AJAX request
     */
    public function getStatesByCountry(Request $request)
    {
        $states = State::where('country_id', $request->country_id)
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($states);
    }

    /**
     * Get cities by state ID for AJAX request
     */
    public function getCitiesByState(Request $request)
    {
        $cities = City::where('state_id', $request->state_id)
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($cities);
    }
}
