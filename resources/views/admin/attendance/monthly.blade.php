@extends('layouts.admin')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{ __('Monthly Attendance Sheet') }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.attendance.index') }}">{{ __('Attendance') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __('Monthly Sheet') }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-30">
                <div class="col-md-12">
                    <div class="bg-style p-3">
                        <h4 class="mb-2">{{ __('User') }}: {{ $user?->user?->name }}</h4>
                        <p class="mb-0">{{ __('Role') }}: {{ ucfirst($role) }} | {{ __('Month') }}: {{ $month->format('F Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="customers__table">
                            <table class="row-border data-table-filter table-style">
                                <thead>
                                <tr>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Check In') }}</th>
                                    <th>{{ __('Check Out') }}</th>
                                    <th>{{ __('Late') }}</th>
                                    <th>{{ __('Early Leave') }}</th>
                                    <th>{{ __('Reason') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dates as $date)
                                    @php
                                        $record = $attendanceByDate[$date->format('Y-m-d')] ?? null;
                                    @endphp
                                    <tr>
                                        <td>{{ $date->format('Y-m-d') }}</td>
                                        <td>{{ $record ? ucfirst(str_replace('_', ' ', $record->status)) : __('Absent') }}</td>
                                        <td>{{ $record?->check_in_time }}</td>
                                        <td>{{ $record?->check_out_time }}</td>
                                        <td>{{ $record?->late_minutes ?? 0 }}</td>
                                        <td>{{ $record?->early_leave_minutes ?? 0 }}</td>
                                        <td>{{ $record?->absence_reason }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

