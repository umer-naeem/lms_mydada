@extends('layouts.admin')

@section('content')
    <style>
        /* Modern Form Styles */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
            --danger-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        /* Page Header */
        .page-header {
            background: white;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title-icon {
            width: 50px;
            height: 50px;
            background: var(--primary-gradient);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .page-title h2 {
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
        }

        .page-title p {
            color: #718096;
            margin: 5px 0 0 0;
            font-size: 14px;
        }

        .breadcrumb {
            background: #f7fafc;
            padding: 12px 20px;
            border-radius: 12px;
            margin: 0;
        }

        .breadcrumb-item a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-item.active {
            color: #718096;
        }

        /* Form Card */
        .form-card {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .form-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f7fafc;
        }

        .form-header h3 {
            font-size: 18px;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-header h3 i {
            color: #667eea;
        }

        .form-badge {
            background: #f7fafc;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 13px;
            color: #4a5568;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-badge i {
            color: #667eea;
        }

        /* Form Groups */
        .form-group-modern {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 10px;
        }

        .form-label i {
            color: #667eea;
            margin-right: 8px;
            width: 16px;
        }

        .form-label .required {
            color: #f56565;
            margin-left: 4px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            transition: all 0.3s ease;
            z-index: 1;
        }

        .form-control-modern {
            width: 100%;
            padding: 14px 16px 14px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            color: #2d3748;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-control-modern:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .form-control-modern:focus + .input-icon {
            color: #667eea;
        }

        .form-control-modern.error {
            border-color: #f56565;
        }

        .form-control-modern[readonly] {
            background: #f1f5f9;
            cursor: not-allowed;
        }

        /* Select Input */
        .select-modern {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            color: #2d3748;
            background: #f8fafc;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23a0aec0' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            transition: all 0.3s ease;
        }

        .select-modern:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        /* Textarea */
        .textarea-modern {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            color: #2d3748;
            background: #f8fafc;
            transition: all 0.3s ease;
            resize: vertical;
            min-height: 120px;
        }

        .textarea-modern:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        /* Error Message */
        .error-message {
            color: #f56565;
            font-size: 12px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Image Upload */
        .upload-container {
            background: #f8fafc;
            border: 2px dashed #e2e8f0;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .upload-container:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .upload-preview {
            width: 120px;
            height: 120px;
            border-radius: 15px;
            object-fit: cover;
            margin-bottom: 15px;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .upload-icon {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: #667eea;
            font-size: 24px;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }

        .upload-text {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 5px;
        }

        .upload-hint {
            font-size: 12px;
            color: #a0aec0;
        }

        /* Info Box */
        .info-box {
            background: #f7fafc;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }

        .info-box i {
            color: #667eea;
            margin-right: 8px;
        }

        .info-box p {
            margin: 0;
            color: #4a5568;
            font-size: 13px;
        }

        /* Roll Number Box */
        .roll-number-box {
            background: linear-gradient(135deg, #667eea10, #764ba210);
            border-radius: 12px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            border: 1px solid #667eea20;
        }

        .roll-number-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-gradient);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .roll-number-content {
            flex: 1;
        }

        .roll-number-label {
            font-size: 12px;
            color: #718096;
            margin-bottom: 4px;
        }

        .roll-number-value {
            font-size: 16px;
            font-weight: 600;
            color: #2d3748;
            font-family: monospace;
        }

        .roll-number-badge {
            background: #84fab020;
            color: #1a7d4a;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        /* Submit Button */
        .submit-btn {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 16px 30px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.2);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.3);
        }

        .submit-btn i {
            font-size: 18px;
        }

        .cancel-btn {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 30px;
            color: #4a5568;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .cancel-btn:hover {
            border-color: #667eea;
            color: #667eea;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 15px;
            }

            .form-header {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>

    <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title">
                    <div class="page-title-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div>
                        <h2>{{ __('Add New Student') }}</h2>
                        <p>{{ __('Fill in the details to add a new student to the system') }}</p>
                    </div>
                </div>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fas fa-home me-2"></i>{{__('Dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Add Student') }}</li>
                    </ul>
                </nav>
            </div>

            <!-- Form Card -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-card">
                        <div class="form-header">
                            <h3>
                                <i class="fas fa-user-graduate"></i>
                                {{ __('Student Information') }}
                            </h3>
                            <div class="form-badge">
                                <i class="fas fa-info-circle"></i>
                                {{ __('All fields marked with * are required') }}
                            </div>
                        </div>

                        <form action="{{route('student.store')}}" method="post" enctype="multipart/form-data">
                            @csrf

                            <!-- Roll Number (Auto-generated) -->
                            <div class="col-md-4">
                                <div class="form-group-modern">
                                    <label class="form-label">
                                        <i class="fas fa-hashtag"></i>
                                        {{ __('Roll Number') }}
                                    </label>
                                    <div class="roll-number-box">
                                        <div class="roll-number-icon">
                                            <i class="fas fa-magic"></i>
                                        </div>
                                        <div class="roll-number-content">
                                            <div class="roll-number-label">{{ __('Auto-generated') }}</div>
                                            <div class="roll-number-value">{{ __('FEB202617...') }}</div>
                                        </div>
                                        <span class="roll-number-badge">
                                            <i class="fas fa-clock me-1"></i>{{ __('Auto') }}
                                        </span>
                                    </div>
                                    <input type="hidden" name="roll_no" value="{{ old('roll_no') }}">
                                    <small class="text-muted mt-2 d-block">
                                        <i class="fas fa-info-circle me-1"></i>
                                        {{ __('Roll number will be generated automatically on save') }}
                                    </small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-user"></i>
                                            {{ __('First Name') }}
                                            <span class="required">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-user input-icon"></i>
                                            <input type="text"
                                                   name="first_name"
                                                   value="{{old('first_name')}}"
                                                   class="form-control-modern @error('first_name') error @enderror"
                                                   placeholder="Enter first name"
                                                   required>
                                        </div>
                                        @error('first_name')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-user"></i>
                                            {{ __('Last Name') }}
                                            <span class="required">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-user input-icon"></i>
                                            <input type="text"
                                                   name="last_name"
                                                   value="{{old('last_name')}}"
                                                   class="form-control-modern @error('last_name') error @enderror"
                                                   placeholder="Enter last name"
                                                   required>
                                        </div>
                                        @error('last_name')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Admission Date -->
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ __('Admission Date') }}
                                        </label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-calendar-alt input-icon"></i>
                                            <input type="date"
                                                   name="admission_date"
                                                   value="{{old('admission_date')}}"
                                                   class="form-control-modern @error('admission_date') error @enderror">
                                        </div>
                                        @error('admission_date')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Student ID -->
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-id-card"></i>
                                            {{ __('Student ID') }}
                                        </label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-id-card input-icon"></i>
                                            <input type="text"
                                                   name="student_id"
                                                   value="{{old('student_id')}}"
                                                   class="form-control-modern @error('student_id') error @enderror"
                                                   placeholder="Enter student ID (optional)">
                                        </div>
                                        @error('student_id')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Personal Information -->


                                <!-- Email -->
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-envelope"></i>
                                            {{ __('Email') }}
                                            <span class="required">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-envelope input-icon"></i>
                                            <input type="email"
                                                   name="email"
                                                   value="{{old('email')}}"
                                                   class="form-control-modern @error('email') error @enderror"
                                                   placeholder="Enter email address"
                                                   required>
                                        </div>
                                        @error('email')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-lock"></i>
                                            {{ __('Password') }}
                                            <span class="required">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-lock input-icon"></i>
                                            <input type="password"
                                                   name="password"
                                                   class="form-control-modern @error('password') error @enderror"
                                                   placeholder="Enter password"
                                                   required>
                                        </div>
                                        @error('password')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <!-- Phone Number with Area Code -->
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-globe"></i>
                                            {{ __('Area Code') }}
                                            <span class="required">*</span>
                                        </label>
                                        <select name="area_code" class="select-modern @error('area_code') error @enderror">
                                            <option value="">{{ __('Select Code') }}</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->phonecode }}" @if(old('area_code')==$country->phonecode) selected @endif>
                                                    {{ $country->short_name }} ({{ $country->phonecode }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('area_code')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-phone"></i>
                                            {{ __('Phone Number') }}
                                            <span class="required">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-phone input-icon"></i>
                                            <input type="text"
                                                   name="phone_number"
                                                   value="{{old('phone_number')}}"
                                                   class="form-control-modern @error('phone_number') error @enderror"
                                                   placeholder="Enter phone number"
                                                   required>
                                        </div>
                                        @error('phone_number')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>



                                <!-- Current Level -->
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-layer-group"></i>
                                            {{ __('Current Level') }}
                                        </label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-layer-group input-icon"></i>
                                            <input type="text"
                                                   name="current_level"
                                                   value="{{old('current_level')}}"
                                                   class="form-control-modern @error('current_level') error @enderror"
                                                   placeholder="e.g., Class 10, Bachelor 1">
                                        </div>
                                        @error('current_level')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>



                                <!-- Address -->
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ __('Address') }}
                                            <span class="required">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-map-marker-alt input-icon"></i>
                                            <input type="text"
                                                   name="address"
                                                   value="{{old('address')}}"
                                                   class="form-control-modern @error('address') error @enderror"
                                                   placeholder="Enter full address"
                                                   required>
                                        </div>
                                        @error('address')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Postal Code -->
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-mail-bulk"></i>
                                            {{ __('Postal Code') }}
                                            <span class="required">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-mail-bulk input-icon"></i>
                                            <input type="text"
                                                   name="postal_code"
                                                   value="{{old('postal_code')}}"
                                                   class="form-control-modern @error('postal_code') error @enderror"
                                                   placeholder="Enter postal code"
                                                   required>
                                        </div>
                                        @error('postal_code')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Country/State/City Row -->
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-flag"></i>
                                            {{ __('Country') }}
                                        </label>
                                        <select name="country_id" id="country_id" class="select-modern">
                                            <option value="">{{ __('Select Country') }}</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}" @if(old('country_id') == $country->id) selected @endif>
                                                    {{$country->country_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-map-marked-alt"></i>
                                            {{ __('State') }}
                                        </label>
                                        <select name="state_id" id="state_id" class="select-modern">
                                            <option value="">{{ __('Select State') }}</option>
                                            @if(old('country_id'))
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}" {{old('state_id') == $state->id ? 'selected' : ''}}>
                                                        {{$state->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-city"></i>
                                            {{ __('City') }}
                                        </label>
                                        <select name="city_id" id="city_id" class="select-modern">
                                            <option value="">{{ __('Select City') }}</option>
                                            @if(old('state_id'))
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}" {{old('city_id') == $city->id ? 'selected' : ''}}>
                                                        {{$city->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <!-- Gender -->
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-venus-mars"></i>
                                            {{ __('Gender') }}
                                            <span class="required">*</span>
                                        </label>
                                        <select name="gender" class="select-modern @error('gender') error @enderror" required>
                                            <option value="">{{ __('Select Gender') }}</option>
                                            <option value="Male" {{old('gender') == 'Male' ? 'selected' : ''}}>
                                                <i class="fas fa-male"></i> {{ __('Male') }}
                                            </option>
                                            <option value="Female" {{old('gender') == 'Female' ? 'selected' : ''}}>
                                                <i class="fas fa-female"></i> {{ __('Female') }}
                                            </option>
                                            <option value="Others" {{old('gender') == 'Others' ? 'selected' : ''}}>
                                                {{ __('Others') }}
                                            </option>
                                        </select>
                                        @error('gender')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- About Student -->
                                <div class="col-md-12">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-edit"></i>
                                            {{ __('About Student') }}
                                            <span class="required">*</span>
                                        </label>
                                        <textarea name="about_me"
                                                  class="textarea-modern @error('about_me') error @enderror"
                                                  placeholder="Write something about the student..."
                                                  required>{{ old('about_me') }}</textarea>
                                        @error('about_me')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Image Upload -->
                                <div class="col-md-12">
                                    <div class="form-group-modern">
                                        <label class="form-label">
                                            <i class="fas fa-camera"></i>
                                            {{ __('Profile Image') }}
                                        </label>
                                        <div class="upload-container" onclick="document.getElementById('image').click()">
                                            <img src="" id="preview" class="upload-preview" style="display: none;">
                                            <div class="upload-icon">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                            </div>
                                            <div class="upload-text">{{ __('Click to upload image') }}</div>
                                            <div class="upload-hint">{{ __('JPEG, JPG, PNG (300x300, max 1MB)') }}</div>
                                            <input type="file"
                                                   name="image"
                                                   id="image"
                                                   accept="image/*"
                                                   style="display: none;"
                                                   onchange="previewFile(this)">
                                        </div>
                                        @error('image')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-md-12 d-flex gap-3 justify-content-end">
                                    <a href="{{ route('student.index') }}" class="cancel-btn">
                                        <i class="fas fa-times"></i>
                                        {{ __('Cancel') }}
                                    </a>
                                    <button type="submit" class="submit-btn">
                                        <i class="fas fa-save"></i>
                                        {{ __('Save Student') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">
    <style>
        /* Additional custom styles */
        .upload-container {
            background: linear-gradient(135deg, #667eea05, #764ba205);
        }

        .form-control-modern::placeholder {
            color: #a0aec0;
            font-size: 13px;
        }

        .select-modern option {
            padding: 10px;
        }

        /* Animation for form fields */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group-modern {
            animation: fadeInUp 0.5s ease forwards;
            animation-delay: calc(var(--animation-order) * 0.1s);
        }
    </style>
@endpush

@push('script')
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
    <script src="{{asset('admin/js/custom/admin-profile.js')}}"></script>
    <script>
        "use strict"

        // Image preview function
        function previewFile(input) {
            const preview = document.getElementById('preview');
            const file = input.files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
                document.querySelector('.upload-icon').style.display = 'none';
                document.querySelector('.upload-text').innerHTML = '{{ __("Change image") }}';
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
                document.querySelector('.upload-icon').style.display = 'flex';
                document.querySelector('.upload-text').innerHTML = '{{ __("Click to upload image") }}';
            }
        }

        // Animation order for form fields
        document.querySelectorAll('.form-group-modern').forEach((el, index) => {
            el.style.setProperty('--animation-order', index);
        });

        // Country/State/City dependent dropdown
        $('#country_id').on('change', function() {
            var countryId = $(this).val();
            if(countryId) {
                $.ajax({
                    url: '{{ route("student.getStatesByCountry") }}', // Updated route name
                    type: 'POST',
                    data: {
                        country_id: countryId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#state_id').empty();
                        $('#state_id').append('<option value="">{{ __("Select State") }}</option>');
                        $.each(data, function(key, value) {
                            $('#state_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                $('#state_id').empty();
                $('#state_id').append('<option value="">{{ __("Select State") }}</option>');
                $('#city_id').empty();
                $('#city_id').append('<option value="">{{ __("Select City") }}</option>');
            }
        });

        $('#state_id').on('change', function() {
            var stateId = $(this).val();
            if(stateId) {
                $.ajax({
                    url: '{{ route("student.getCitiesByState") }}', // Updated route name
                    type: 'POST',
                    data: {
                        state_id: stateId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#city_id').empty();
                        $('#city_id').append('<option value="">{{ __("Select City") }}</option>');
                        $.each(data, function(key, value) {
                            $('#city_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                $('#city_id').empty();
                $('#city_id').append('<option value="">{{ __("Select City") }}</option>');
            }
        });
    </script>
@endpush