@extends('layouts.admin')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{ __('Attendance') }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __('Attendance') }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-30">
                <div class="col-md-12">
                    <div class="bg-style p-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">{{ __('Filters') }}</h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#attendance-advanced-filters" aria-expanded="false" aria-controls="attendance-advanced-filters">
                                    {{ __('More Filters') }}
                                </button>
                            </div>
                        </div>
                        <form method="get" class="row g-3 align-items-end">
                            <div class="col-md-2">
                                <label class="form-label">{{ __('Role') }}</label>
                                <select name="role" class="form-control">
                                    <option value="">{{ __('All') }}</option>
                                    <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>{{ __('Student') }}</option>
                                    <option value="teacher" {{ request('role') == 'teacher' ? 'selected' : '' }}>{{ __('Teacher') }}</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">{{ __('User Search') }}</label>
                                <input type="text" name="user_search" class="form-control" value="{{ request('user_search') }}" placeholder="{{ __('Name or email') }}">
                            </div>
                            <div class="col-md-5 d-flex gap-2 align-items-end">
                                <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
                                <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-secondary">{{ __('Reset') }}</a>
                               
                            </div>
                        </form>
                        <div class="collapse mt-3" id="attendance-advanced-filters">
                            <form method="get" class="row g-3 align-items-end">
                                <input type="hidden" name="role" value="{{ request('role') }}">
                                <input type="hidden" name="user_search" value="{{ request('user_search') }}">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('Status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="">{{ __('All') }}</option>
                                        <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>{{ __('Present') }}</option>
                                        <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>{{ __('Absent') }}</option>
                                        <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>{{ __('Late') }}</option>
                                        <option value="early_leave" {{ request('status') == 'early_leave' ? 'selected' : '' }}>{{ __('Early Leave') }}</option>
                                        <option value="late_early_leave" {{ request('status') == 'late_early_leave' ? 'selected' : '' }}>{{ __('Late & Early Leave') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('Approval') }}</label>
                                    <select name="approval_status" class="form-control">
                                        <option value="">{{ __('All') }}</option>
                                        <option value="pending" {{ request('approval_status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                        <option value="approved" {{ request('approval_status') == 'approved' ? 'selected' : '' }}>{{ __('Approved') }}</option>
                                        <option value="rejected" {{ request('approval_status') == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('Date Range') }}</label>
                                    <div class="d-flex gap-2">
                                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-100">{{ __('Apply') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title d-flex justify-content-between align-items-center">
                            <h2>{{ __('Attendance Records') }}</h2>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.attendance.create', ['role' => request('role', 'student')]) }}" class="btn btn-success">{{ __('Add Attendance') }}</a>
                                <a href="{{ route('admin.attendance.export.excel', request()->query()) }}" class="btn btn-outline-primary">{{ __('Export Excel') }}</a>
                                <a href="{{ route('admin.attendance.export.pdf', request()->query()) }}" class="btn btn-outline-primary">{{ __('Export PDF') }}</a>
                            </div>
                        </div>
                        <div class="customers__table">
                            <table class="row-border data-table-filter table-style">
                                <thead>
                                <tr>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Role') }}</th>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Course') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Late / Early') }}</th>
                                    <th>{{ __('Approval') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($attendances as $attendance)
                                    <tr>
                                        <td>{{ optional($attendance->attendance_date)->format('Y-m-d') }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ ucfirst($attendance->role) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span>{{ optional($attendance->user)->name }}</span>
                                                <small class="text-muted">{{ optional($attendance->user)->email }}</small>
                                            </div>
                                        </td>
                                        <td>{{ optional($attendance->course)->title ?? __('N/A') }}</td>
                                        <td>
                                            @php
                                                $statusClass = match($attendance->status) {
                                                    'present' => 'badge badge-success',
                                                    'absent' => 'badge badge-danger',
                                                    'late' => 'badge badge-warning',
                                                    'early_leave' => 'badge badge-warning',
                                                    'late_early_leave' => 'badge badge-warning',
                                                    default => 'badge badge-secondary',
                                                };
                                            @endphp
                                            <span class="{{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $attendance->status)) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span>{{ __('Late') }}: {{ $attendance->late_minutes }} {{ __('min') }}</span>
                                                <span>{{ __('Early') }}: {{ $attendance->early_leave_minutes }} {{ __('min') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $approvalClass = match($attendance->approval_status) {
                                                    'approved' => 'badge badge-success',
                                                    'rejected' => 'badge badge-danger',
                                                    default => 'badge badge-warning',
                                                };
                                            @endphp
                                            <span class="{{ $approvalClass }}">{{ ucfirst($attendance->approval_status) }}</span>
                                        </td>
                                        <td>
                                            <div class="action__buttons">
                                                <a href="{{ route('admin.attendance.edit', $attendance->id) }}" class="btn-action mr-30" title="{{ __('Edit') }}">
                                                    <img src="{{ asset('admin/images/icons/edit-2.svg') }}" alt="edit">
                                                </a>
                                                @if($attendance->approval_status === 'pending')
                                                    <form action="{{ route('admin.attendance.approve', $attendance->id) }}" method="post" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="approval_status" value="approved">
                                                        <button type="submit" class="btn-action" title="{{ __('Approve') }}">
                                                            <img src="{{ asset('admin/images/icons/eye-2.svg') }}" alt="approve">
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.attendance.approve', $attendance->id) }}" method="post" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="approval_status" value="rejected">
                                                        <button type="submit" class="btn-action" title="{{ __('Reject') }}">
                                                            <img src="{{ asset('admin/images/icons/trash-2.svg') }}" alt="reject">
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">{{ __('No records found.') }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $attendances->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

