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

@push('script')
<script>
    'use strict'
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