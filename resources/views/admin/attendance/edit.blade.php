@extends('layouts.admin')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{ __('Edit Attendance') }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.attendance.index') }}">{{ __('Attendance') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-vertical__item bg-style">
                        <div class="item-top mb-30">
                            <h2>{{ __('Attendance Details') }}</h2>
                        </div>
                        <form action="{{ route('admin.attendance.update', $attendance->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label>{{ __('Role') }}</label>
                                        <select name="role" class="form-control">
                                            <option value="student" {{ $attendance->role === 'student' ? 'selected' : '' }}>{{ __('Student') }}</option>
                                            <option value="teacher" {{ $attendance->role === 'teacher' ? 'selected' : '' }}>{{ __('Teacher') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label>{{ __('User') }}</label>
                                        <select name="user_id" class="form-control">
                                            @if($attendance->role === 'teacher')
                                                @foreach($instructors as $instructor)
                                                    @if($instructor->user)
                                                        <option value="{{ $instructor->user->id }}" {{ (string) $attendance->user_id === (string) $instructor->user->id ? 'selected' : '' }}>
                                                            {{ $instructor->full_name }} ({{ $instructor->user->email }})
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach($students as $student)
                                                    @if($student->user)
                                                        <option value="{{ $student->user->id }}" {{ (string) $attendance->user_id === (string) $student->user->id ? 'selected' : '' }}>
                                                            {{ $student->name }} ({{ $student->user->email }})
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label>{{ __('Course (Optional)') }}</label>
                                        <select name="course_id" class="form-control">
                                            <option value="">{{ __('None') }}</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}" {{ (string) $attendance->course_id === (string) $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label>{{ __('Attendance Date') }}</label>
                                        <input type="date" name="attendance_date" class="form-control" value="{{ $attendance->attendance_date ? $attendance->attendance_date->format('Y-m-d') : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label>{{ __('Check In Time') }}</label>
                                        <input type="time" name="check_in_time" class="form-control" value="{{ $attendance->check_in_time }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label>{{ __('Check Out Time') }}</label>
                                        <input type="time" name="check_out_time" class="form-control" value="{{ $attendance->check_out_time }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label>{{ __('Status') }}</label>
                                        <select name="status" class="form-control">
                                            <option value="present" {{ $attendance->status === 'present' ? 'selected' : '' }}>{{ __('Present') }}</option>
                                            <option value="absent" {{ $attendance->status === 'absent' ? 'selected' : '' }}>{{ __('Absent') }}</option>
                                            <option value="late" {{ $attendance->status === 'late' ? 'selected' : '' }}>{{ __('Late') }}</option>
                                            <option value="early_leave" {{ $attendance->status === 'early_leave' ? 'selected' : '' }}>{{ __('Early Leave') }}</option>
                                            <option value="late_early_leave" {{ $attendance->status === 'late_early_leave' ? 'selected' : '' }}>{{ __('Late & Early Leave') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label>{{ __('Approval Status') }}</label>
                                        <select name="approval_status" class="form-control">
                                            <option value="pending" {{ $attendance->approval_status === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                            <option value="approved" {{ $attendance->approval_status === 'approved' ? 'selected' : '' }}>{{ __('Approved') }}</option>
                                            <option value="rejected" {{ $attendance->approval_status === 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label>{{ __('Late Minutes') }}</label>
                                        <input type="number" name="late_minutes" class="form-control" min="0" value="{{ $attendance->late_minutes }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label>{{ __('Early Leave Minutes') }}</label>
                                        <input type="number" name="early_leave_minutes" class="form-control" min="0" value="{{ $attendance->early_leave_minutes }}">
                                    </div>
                                </div>
                            </div>

                            <div class="input__group mb-25">
                                <label>{{ __('Absence Reason') }}</label>
                                <textarea name="absence_reason" class="form-control" rows="3" placeholder="{{ __('Required for absences') }}">{{ $attendance->absence_reason }}</textarea>
                            </div>

                            <div class="input__group mb-25">
                                <label>{{ __('Notes') }}</label>
                                <textarea name="notes" class="form-control" rows="3">{{ $attendance->notes }}</textarea>
                            </div>

                            <div class="input__group mb-25">
                                <button type="submit" class="btn btn-primary">{{ __('Update Attendance') }}</button>
                                <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

