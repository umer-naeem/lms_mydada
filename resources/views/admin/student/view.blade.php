@extends('layouts.admin')

@section('content')
    <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{__('Student Profile')}}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item"><a href="{{route('student.index')}}">{{__('All Students')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{__('Student Profile')}}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="profile__item bg-style">
                        <div class="profile__item__top">
                            <div class="user-img">
                                <img src="{{asset($student->user ? $student->user->image_path  : '')}}" alt="img">
                            </div>
                            <div class="user-text">
                                <h2>{{$student->name}}</h2>
                            </div>
                        </div>
                        <div class="profile__item__content">
                            <h2>{{__('Personal Information')}}</h2>
                            <p>
                                {{$student->about_me}}
                            </p>
                        </div>
                        <ul class="profile__item__list">
                            <li>
                                <div class="list-item">
                                    <h2>{{__('Name')}}:</h2>
                                    <p>{{$student->name}}</p>
                                </div>
                            </li>
                            <li>
                                <div class="list-item">
                                    <h2>{{__('Student ID')}}:</h2>
                                    <p>{{ $student->student_id ?? __('N/A') }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="list-item">
                                    <h2>{{__('Roll No')}}:</h2>
                                    <p>{{ $student->roll_no ?? __('N/A') }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="list-item">
                                    <h2>{{__('Phone')}}:</h2>
                                    <p>{{$student->phone_number}}</p>
                                </div>
                            </li>
                            <li>
                                <div class="list-item">
                                    <h2>{{__('Email')}}:</h2>
                                    <p>{{$student->user ? $student->user->email : '' }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="list-item">
                                    <h2>{{ __('Address') }}:</h2>
                                    <p>{{$student->address}} </p>
                                </div>
                            </li>
                            <li>
                                <div class="list-item">
                                    <h2>{{ __('Location') }}:</h2>
                                    <p>{{$student->city ?  $student->city->name.', ' : ''}}  {{$student->state ?  $student->state->name.', ' : ''}} {{$student->country ? $student->country->country_name : ''}} </p>
                                </div>
                            </li>
                            <li>
                                <div class="list-item">
                                    <h2>{{ __('Level') }}:</h2>
                                    <p>{{ $student->current_level ?? __('N/A') }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="list-item">
                                    <h2>{{ __('Admission Date') }}:</h2>
                                    <p>{{ $student->admission_date ? $student->admission_date->format('Y-m-d') : __('N/A') }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="list-item">
                                    <h2>{{ __('Account Status') }}:</h2>
                                    <p>{{ $student->account_frozen ? __('Frozen') : __('Active') }}</p>
                                </div>
                            </li>
                        </ul>
                        <div class="mt-3">
                            <form action="{{ route('student.freeze', $student->uuid) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-{{ $student->account_frozen ? 'success' : 'danger' }}">
                                    {{ $student->account_frozen ? __('Reactivate Account') : __('Freeze Account') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="profile__status__area">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="status__item bg-style">
                                    <div class="status-img">
                                        <img src="{{asset('admin/images/status-icon/done.png')}}" alt="icon">
                                    </div>
                                    <div class="status-text">
                                        <h2>{{ studentCoursesCount($student->user_id) }}</h2>
                                        <p>{{ __('Total Enrolled Courses') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile__progress__area bg-style mt-4">
                        <div class="item-title d-flex align-items-center mb-4">
                            <div class="progress-icon-wrapper mr-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="#5D5FEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M2 17L12 22L22 17" stroke="#5D5FEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M2 12L12 17L22 12" stroke="#5D5FEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h2 class="mb-0">{{__('Student Progress Overview')}}</h2>
                        </div>
                        
                        <!-- Overall Progress Donut Chart -->
                        <div class="row mb-4">
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="chart-card-modern">
                                    <div class="chart-header-modern mb-3">
                                        <div class="chart-title-wrapper">
                                            <div class="chart-icon">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                            <h3 class="chart-title">{{__('Overall Progress')}}</h3>
                                        </div>
                                    </div>
                                    <div id="overall-progress-donut" style="min-height: 280px;"></div>
                                    <div class="text-center mt-3">
                                        <div class="overall-progress-value">{{$overallProgress ?? 0}}%</div>
                                        <div class="overall-progress-label">{{__('Average Progress')}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="progress-stat-card">
                                    <div class="stat-card-icon" style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 6.25278V19.2528M12 6.25278C10.8321 5.47686 9.24649 5 7.5 5C5.75351 5 4.16789 5.47686 3 6.25278V19.2528C4.16789 18.4769 5.75351 18 7.5 18C9.24649 18 10.8321 18.4769 12 19.2528M12 6.25278C13.1679 5.47686 14.7535 5 16.5 5C18.2465 5 19.8321 5.47686 21 6.25278V19.2528C19.8321 18.4769 18.2465 18 16.5 18C14.7535 18 13.1679 18.4769 12 19.2528" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div class="stat-card-content">
                                        <div class="stat-card-value">{{$totalCourses ?? 0}}</div>
                                        <div class="stat-card-label">{{__('Total Courses')}}</div>
                                        <div class="stat-card-subtext">{{__('Enrolled')}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="progress-stat-card">
                                    <div class="stat-card-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 11L12 14L22 4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div class="stat-card-content">
                                        <div class="stat-card-value">{{count($progressData ?? [])}}</div>
                                        <div class="stat-card-label">{{__('Active Courses')}}</div>
                                        <div class="stat-card-subtext">{{__('In Progress')}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Progress Bar Chart by Course -->
                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <div class="chart-card-modern">
                                    <div class="chart-header-modern">
                                        <div class="chart-title-wrapper">
                                            <div class="chart-icon">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3 3V21H21" stroke="#5D5FEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M7 16L12 11L16 15L21 10" stroke="#5D5FEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                            <h3 class="chart-title">{{__('Progress by Course')}}</h3>
                                        </div>
                                    </div>
                                    <div id="student-progress-chart" style="min-height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                        
                        @if(isset($progressData) && count($progressData) > 0)
                        <div class="mt-4">
                            <div class="chart-card-modern">
                                <div class="chart-header-modern mb-3">
                                    <div class="chart-title-wrapper">
                                        <div class="chart-icon">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9 5H7C5.89543 5 5 5.89543 5 7V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V7C19 5.89543 18.1046 5 17 5H15" stroke="#5D5FEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5C15 6.10457 14.1046 7 13 7H11C9.89543 7 9 6.10457 9 5Z" stroke="#5D5FEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M9 12H15" stroke="#5D5FEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M9 16H15" stroke="#5D5FEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <h3 class="chart-title">{{__('Course-wise Progress Details')}}</h3>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table-modern-progress">
                                        <thead>
                                            <tr>
                                                <th>{{__('Course Name')}}</th>
                                                <th>{{__('Progress')}}</th>
                                                <th>{{__('Lectures Completed')}}</th>
                                                <th>{{__('Status')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($progressData as $courseProgress)
                                            <tr>
                                                <td>
                                                    <div class="course-name-cell">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="course-icon">
                                                            <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="#5D5FEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M2 17L12 22L22 17" stroke="#5D5FEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M2 12L12 17L22 12" stroke="#5D5FEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                        <span class="course-name-text">{{$courseProgress['course']}}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="progress-wrapper-modern">
                                                        <div class="progress-bar-modern" 
                                                             style="width: {{$courseProgress['progress']}}%;">
                                                            <span class="progress-text">{{$courseProgress['progress']}}%</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="lecture-count-badge">
                                                        <span class="count-viewed">{{$courseProgress['viewed']}}</span>
                                                        <span class="count-separator">/</span>
                                                        <span class="count-total">{{$courseProgress['total']}}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($courseProgress['progress'] == 100)
                                                        <span class="status-badge status-completed">{{__('Completed')}}</span>
                                                    @elseif($courseProgress['progress'] >= 50)
                                                        <span class="status-badge status-in-progress">{{__('In Progress')}}</span>
                                                    @else
                                                        <span class="status-badge status-started">{{__('Started')}}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="profile__timeline__area bg-style">
                        <div class="item-title">
                            <h2>{{__('Enrolled Courses')}}</h2>
                        </div>
                        <div class="profile__table">
                            <table class="table-style">
                                <thead>
                                <tr>
                                    <th>{{__('Image')}}</th>
                                    <th>{{__('Title')}}</th>
                                    <th>{{__('Teachers')}}</th>
                                    <th>{{__('Level')}}</th>
                                    <th>{{__('Progress')}}</th>
                                    <th>{{__('Validity')}}</th>
                                    <th>{{__('Status')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($enrollments as $enrollment)
                                    <tr>
                                        <td>
                                            <a target="_blank" href="{{route('admin.course.view', [$enrollment->course->uuid])}}"><img src="{{ getImageFile(@$enrollment->course->image_path) }}" alt="course" class="img-fluid" width="80"></a>
                                        </td>
                                        <td>
                                            <span class="data-text"><a target="_blank" href="{{route('admin.course.view', [$enrollment->course->uuid])}}">{{ @$enrollment->course->title }}</a></span>
                                        </td>
                                        <td>
                                            @php
                                                $teachers = collect();
                                                if ($enrollment->course?->instructor?->user) {
                                                    $teachers->push($enrollment->course->instructor->user->name);
                                                }
                                                $courseTeachers = $enrollment->course?->course_instructors?->map(fn($ci) => optional($ci->user)->name)->filter();
                                                $teachers = $teachers->merge($courseTeachers ?? []);
                                            @endphp
                                            {{ $teachers->unique()->implode(', ') ?: __('N/A') }}
                                        </td>
                                        <td>
                                            {{ $enrollment->course?->difficultyLevel?->name ?? __('N/A') }}
                                        </td>
                                        <td>
                                            @php
                                                $progress = $progressByCourse[$enrollment->course_id] ?? ['percentage' => 0, 'viewed' => 0, 'total' => 0];
                                            @endphp
                                            <span>{{ $progress['percentage'] }}%</span>
                                            <small class="text-muted">({{ $progress['viewed'] }}/{{ $progress['total'] }})</small>
                                        </td>
                                        <td>
                                            {{ $enrollment->end_date }}
                                        </td>
                                        <td>
                                            <span id="hidden_id" style="display: none">{{$enrollment->id}}</span>
                                            <select name="status" class="status label-inline font-weight-bolder mb-1 badge badge-info">
                                                <option value="{{ ACCESS_PERIOD_ACTIVE }}" @if($enrollment->status == ACCESS_PERIOD_ACTIVE) selected @endif>{{ __('Active') }}</option>
                                                <option value="{{ ACCESS_PERIOD_DEACTIVATE }}" @if($enrollment->status == ACCESS_PERIOD_DEACTIVATE) selected @endif>{{ __('Revoke') }}</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{@$enrollments->links()}}
                            </div>
                        </div>
                    </div>
                    <div class="profile__timeline__area bg-style mt-4">
                        <div class="item-title d-flex justify-content-between align-items-center">
                            <h2>{{ __('Student Module Details') }}</h2>
                        </div>
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tab-attendance" role="tab">{{ __('Attendance') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab-assignments" role="tab">{{ __('Homework/Assignments') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab-feedback" role="tab">{{ __('Daily Feedback') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab-leave" role="tab">{{ __('Leave Requests') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab-tickets" role="tab">{{ __('Support Tickets') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab-login" role="tab">{{ __('Login History') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab-levels" role="tab">{{ __('Level History') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-attendance" role="tabpanel">
                                <table class="table-style">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Late') }}</th>
                                        <th>{{ __('Early Leave') }}</th>
                                        <th>{{ __('Approval') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($attendanceRecords as $attendance)
                                        <tr>
                                            <td>{{ optional($attendance->attendance_date)->format('Y-m-d') }}</td>
                                            <td>{{ ucfirst(str_replace('_',' ', $attendance->status)) }}</td>
                                            <td>{{ $attendance->late_minutes }} {{ __('min') }}</td>
                                            <td>{{ $attendance->early_leave_minutes }} {{ __('min') }}</td>
                                            <td>{{ ucfirst($attendance->approval_status) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center">{{ __('No attendance found.') }}</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab-assignments" role="tabpanel">
                                <table class="table-style">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Submitted At') }}</th>
                                        <th>{{ __('File') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($assignmentSubmissions as $submission)
                                        <tr>
                                            <td>{{ $submission->title ?? __('Assignment') }}</td>
                                            <td>{{ $submission->created_at?->format('Y-m-d') }}</td>
                                            <td>
                                                @if($submission->file_url)
                                                    <a href="{{ $submission->file_url }}" target="_blank">{{ __('View') }}</a>
                                                @else
                                                    {{ __('N/A') }}
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center">{{ __('No submissions found.') }}</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab-feedback" role="tabpanel">
                                <form action="{{ route('student.feedback', $student->uuid) }}" method="post" class="mb-3">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="date" name="feedback_date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="rating" class="form-control" min="0" max="5" placeholder="{{ __('Rating (0-5)') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="notes" class="form-control" placeholder="{{ __('Notes') }}">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">{{ __('Add Feedback') }}</button>
                                </form>
                                <table class="table-style">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Rating') }}</th>
                                        <th>{{ __('Notes') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($feedbacks as $feedback)
                                        <tr>
                                            <td>{{ $feedback->feedback_date?->format('Y-m-d') }}</td>
                                            <td>{{ $feedback->rating }}</td>
                                            <td>{{ $feedback->notes }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center">{{ __('No feedback found.') }}</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab-leave" role="tabpanel">
                                <form action="{{ route('student.leave-request', $student->uuid) }}" method="post" class="mb-3">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="date" name="start_date" class="form-control" required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date" name="end_date" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="reason" class="form-control" placeholder="{{ __('Reason') }}">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">{{ __('Add Leave Request') }}</button>
                                </form>
                                <table class="table-style">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Date Range') }}</th>
                                        <th>{{ __('Reason') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($leaveRequests as $leave)
                                        <tr>
                                            <td>{{ $leave->start_date?->format('Y-m-d') }} - {{ $leave->end_date?->format('Y-m-d') }}</td>
                                            <td>{{ $leave->reason }}</td>
                                            <td>{{ ucfirst($leave->status) }}</td>
                                            <td>
                                                @if($leave->status === 'pending')
                                                    <form action="{{ route('student.leave-request-approve', $leave->id) }}" method="post" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="approved">
                                                        <button class="btn btn-sm btn-success">{{ __('Approve') }}</button>
                                                    </form>
                                                    <form action="{{ route('student.leave-request-approve', $leave->id) }}" method="post" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button class="btn btn-sm btn-danger">{{ __('Reject') }}</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center">{{ __('No leave requests found.') }}</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab-tickets" role="tabpanel">
                                <table class="table-style">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Ticket') }}</th>
                                        <th>{{ __('Subject') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Created') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($supportTickets as $ticket)
                                        <tr>
                                            <td>{{ $ticket->uuid }}</td>
                                            <td>{{ $ticket->subject ?? __('Support Ticket') }}</td>
                                            <td>{{ $ticket->status ?? __('N/A') }}</td>
                                            <td>{{ $ticket->created_at?->format('Y-m-d') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center">{{ __('No tickets found.') }}</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab-login" role="tabpanel">
                                <table class="table-style">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Device') }}</th>
                                        <th>{{ __('IP') }}</th>
                                        <th>{{ __('Last Seen') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($devices as $device)
                                        <tr>
                                            <td>{{ $device->device_type ?? __('N/A') }}</td>
                                            <td>{{ $device->ip ?? __('N/A') }}</td>
                                            <td>{{ $device->updated_at?->format('Y-m-d H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center">{{ __('No login history found.') }}</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab-levels" role="tabpanel">
                                <form action="{{ route('student.level-upgrade', $student->uuid) }}" method="post" class="mb-3">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" name="level" class="form-control" placeholder="{{ __('New Level') }}" required>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="notes" class="form-control" placeholder="{{ __('Notes') }}">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">{{ __('Upgrade Level') }}</button>
                                </form>
                                <table class="table-style">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Level') }}</th>
                                        <th>{{ __('Notes') }}</th>
                                        <th>{{ __('Promoted At') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($levelHistories as $history)
                                        <tr>
                                            <td>{{ $history->level }}</td>
                                            <td>{{ $history->notes }}</td>
                                            <td>{{ $history->promoted_at?->format('Y-m-d') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center">{{ __('No level history found.') }}</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('style')
<style>
    /* Progress Section Modern UI Styles */
    .profile__progress__area {
        border-radius: 20px;
        padding: 30px;
        background: #ffffff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    
    .progress-icon-wrapper {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
    }
    
    /* Stat Cards */
    .progress-stat-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        border-radius: 16px;
        padding: 25px;
        display: flex;
        align-items: flex-start;
        gap: 20px;
        border: 1px solid rgba(102, 126, 234, 0.1);
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    
    .progress-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    
    .progress-stat-card:hover::before {
        transform: scaleX(1);
    }
    
    .progress-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.15);
        border-color: rgba(102, 126, 234, 0.3);
    }
    
    .stat-card-icon {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .stat-card-content {
        flex: 1;
    }
    
    .stat-card-value {
        font-size: 36px;
        font-weight: 700;
        color: #2d3748;
        line-height: 1.2;
        margin-bottom: 5px;
    }
    
    .stat-card-label {
        font-size: 14px;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 5px;
    }
    
    .stat-card-subtext {
        font-size: 12px;
        color: #718096;
    }
    
    .overall-progress-value {
        font-size: 32px;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 5px;
    }
    
    .overall-progress-label {
        font-size: 14px;
        color: #718096;
        font-weight: 500;
    }
    
    /* Chart Cards */
    .chart-card-modern {
        background: #ffffff;
        border-radius: 16px;
        padding: 25px;
        border: 1px solid rgba(102, 126, 234, 0.1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .chart-card-modern:hover {
        box-shadow: 0 8px 30px rgba(102, 126, 234, 0.1);
    }
    
    .chart-header-modern {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f7fafc;
    }
    
    .chart-title-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .chart-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
    }
    
    .chart-title {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
    }
    
    /* Modern Progress Table */
    .table-modern-progress {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }
    
    .table-modern-progress thead th {
        background: #f8f9ff;
        padding: 15px 20px;
        font-size: 12px;
        font-weight: 700;
        color: #4a5568;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        border-radius: 8px;
    }
    
    .table-modern-progress tbody tr {
        background: #ffffff;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }
    
    .table-modern-progress tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.1);
    }
    
    .table-modern-progress tbody td {
        padding: 18px 20px;
        border: none;
        vertical-align: middle;
    }
    
    .table-modern-progress tbody tr:first-child td:first-child {
        border-top-left-radius: 12px;
    }
    
    .table-modern-progress tbody tr:first-child td:last-child {
        border-top-right-radius: 12px;
    }
    
    .table-modern-progress tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }
    
    .table-modern-progress tbody tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
    }
    
    .course-name-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .course-icon {
        flex-shrink: 0;
    }
    
    .course-name-text {
        font-weight: 600;
        color: #2d3748;
        font-size: 14px;
    }
    
    .progress-wrapper-modern {
        background: #f7fafc;
        border-radius: 10px;
        height: 32px;
        position: relative;
        overflow: hidden;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .progress-bar-modern {
        height: 100%;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        position: relative;
        transition: width 0.6s ease;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 10px;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }
    
    .progress-text {
        color: white;
        font-size: 11px;
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }
    
    .lecture-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f8f9ff;
        padding: 8px 14px;
        border-radius: 20px;
        font-weight: 600;
    }
    
    .count-viewed {
        color: #667eea;
        font-size: 14px;
    }
    
    .count-separator {
        color: #a0aec0;
        font-size: 12px;
    }
    
    .count-total {
        color: #4a5568;
        font-size: 14px;
    }
    
    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-completed {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        color: #22543d;
    }
    
    .status-in-progress {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: #1a365d;
    }
    
    .status-started {
        background: linear-gradient(135deg, #fad961 0%, #f76b1c 100%);
        color: #742a2a;
    }
    
    @media (max-width: 768px) {
        .progress-stat-card {
            flex-direction: column;
            text-align: center;
        }
        
        .stat-card-value {
            font-size: 28px;
        }
        
        .chart-card-modern {
            padding: 15px;
        }
    }
</style>
@endpush

@push('script')
<script src="{{asset('common/js/apexcharts.min.js')}}"></script>
<script>
    'use strict'
    
    // Initialize progress charts
    @if(isset($progressData) && count($progressData) > 0)
    document.addEventListener('DOMContentLoaded', function() {
        var progressData = @json($progressData);
        var overallProgress = {{$overallProgress ?? 0}};
        var chartData = [];
        var labels = [];
        
        progressData.forEach(function(course) {
            labels.push(course.course.length > 30 ? course.course.substring(0, 30) + '...' : course.course);
            chartData.push(course.progress);
        });
        
        // Overall Progress Donut Chart
        var donutOptions = {
            series: [overallProgress, 100 - overallProgress],
            chart: {
                type: 'donut',
                height: 280,
                toolbar: {
                    show: false
                }
            },
            labels: ['{{__("Completed")}}', '{{__("Remaining")}}'],
            colors: ['#5D5FEF', '#e0e0e0'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: false
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: true,
                position: 'bottom',
                fontSize: '12px',
                fontWeight: 600,
                formatter: function(seriesName, opts) {
                    return seriesName + ": " + opts.w.globals.series[opts.seriesIndex].toFixed(1) + "%";
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val.toFixed(1) + "%";
                    }
                }
            }
        };
        
        var donutChart = new ApexCharts(document.querySelector("#overall-progress-donut"), donutOptions);
        donutChart.render();
        
        // Progress Bar Chart by Course
        var barOptions = {
            series: [{
                name: '{{__("Progress")}}',
                data: chartData
            }],
            chart: {
                type: 'bar',
                height: 400,
                toolbar: {
                    show: true
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '60%',
                    endingShape: 'rounded',
                    dataLabels: {
                        position: 'top'
                    },
                    borderRadius: 4
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val + "%";
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"],
                    fontWeight: 600
                }
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: labels,
                labels: {
                    rotate: -45,
                    rotateAlways: true,
                    style: {
                        fontSize: '11px',
                        fontWeight: 500
                    }
                }
            },
            yaxis: {
                title: {
                    text: '{{__("Progress (%)")}}',
                    style: {
                        fontSize: '14px',
                        fontWeight: 600
                    }
                },
                max: 100,
                labels: {
                    formatter: function (val) {
                        return val + "%";
                    }
                }
            },
            fill: {
                opacity: 1,
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#8B8DEF'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 0.8,
                    stops: [0, 100]
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + "%";
                    }
                }
            },
            grid: {
                borderColor: '#e7e7e7',
                strokeDashArray: 4,
                row: {
                    colors: ['#f3f3f3', 'transparent'],
                    opacity: 0.5
                }
            }
        };
        
        var barChart = new ApexCharts(document.querySelector("#student-progress-chart"), barOptions);
        barChart.render();
    });
    @else
    // Show empty state if no progress data
    document.addEventListener('DOMContentLoaded', function() {
        var emptyOptions = {
            series: [0],
            chart: {
                type: 'donut',
                height: 250
            },
            labels: ['{{__("No Progress Data")}}'],
            colors: ['#e0e0e0']
        };
        var emptyChart = new ApexCharts(document.querySelector("#overall-progress-donut"), emptyOptions);
        emptyChart.render();
    });
    @endif
    
    $(".status").change(function () {
        var id = $(this).closest('tr').find('#hidden_id').html();
        var status_value = $(this).closest('tr').find('.status option:selected').val();
        Swal.fire({
            title: "{{ __('Are you sure to change status?') }}",
            text: "{{ __('You won`t be able to revert this!') }}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "{{__('Yes, Change it!')}}",
            cancelButtonText: "{{__('No, cancel!')}}",
            reverseButtons: true
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.student.changeEnrollmentStatus')}}",
                    data: {"status": status_value, "id": id, "_token": "{{ csrf_token() }}",},
                    datatype: "json",
                    success: function (data) {
                        toastr.options.positionClass = 'toast-bottom-right';
                        toastr.success('', '{{ __("Enrollment status has been updated") }}');
                    },
                    error: function () {
                        alert("Error!");
                    },
                });
            } else if (result.dismiss === "cancel") {
            }
        });
    });
</script>
@endpush