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

            <div class="row">
                <div class="col-md-12">
                    <div class="form-vertical__item bg-style">
                        <div class="item-top mb-30">
                            <h2>{{ __('Select User & Month') }}</h2>
                        </div>
                        <form method="get" action="{{ route('admin.attendance.monthly') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input__group mb-25">
                                        <label>{{ __('Role') }}</label>
                                        <select name="role" class="form-control" required>
                                            <option value="student">{{ __('Student') }}</option>
                                            <option value="teacher">{{ __('Teacher') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="input__group mb-25">
                                        <label>{{ __('User') }}</label>
                                        <select name="user_id" class="form-control" required>
                                            @foreach($students as $student)
                                                @if($student->user)
                                                    <option value="{{ $student->user->id }}">{{ $student->name }} ({{ $student->user->email }})</option>
                                                @endif
                                            @endforeach
                                            @foreach($instructors as $instructor)
                                                @if($instructor->user)
                                                    <option value="{{ $instructor->user->id }}">{{ $instructor->full_name }} ({{ $instructor->user->email }})</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input__group mb-25">
                                        <label>{{ __('Month') }}</label>
                                        <input type="month" name="month" class="form-control" value="{{ now()->format('Y-m') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="input__group mb-25">
                                <button type="submit" class="btn btn-primary">{{ __('View Monthly Sheet') }}</button>
                                <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-secondary">{{ __('Back') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

