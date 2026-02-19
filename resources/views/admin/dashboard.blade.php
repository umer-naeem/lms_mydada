@extends('layouts.admin')

@section('content')
    <style>
        /* Modern Dashboard Styles - Compact Version */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
            --warning-gradient: linear-gradient(135deg, #fad961 0%, #f76b1c 100%);
            --danger-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        /* Stats Cards - Compact */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 15px !important; /* Reduced from 25px */
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }

        .stat-card:hover::before {
            transform: translateX(100%);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.1);
        }

        .stat-icon {
            width: 45px !important; /* Reduced from 70px */
            height: 45px !important; /* Reduced from 70px */
            border-radius: 12px !important; /* Reduced from 18px */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px !important; /* Reduced from 28px */
            color: white;
            background: var(--primary-gradient);
            box-shadow: 0 5px 12px rgba(102, 126, 234, 0.15);
        }

        .stat-content {
            flex: 1;
            margin-left: 12px !important; /* Reduced from 20px */
        }

        .stat-value {
            font-size: 20px !important; /* Reduced from 32px */
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 2px !important; /* Reduced from 5px */
            line-height: 1.2;
        }

        .stat-label {
            font-size: 11px !important; /* Reduced from 14px */
            color: #718096;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .stat-trend {
            display: inline-flex;
            align-items: center;
            padding: 2px 6px !important; /* Reduced from 4px 8px */
            border-radius: 16px;
            font-size: 10px !important; /* Reduced from 12px */
            font-weight: 600;
            margin-top: 3px !important; /* Reduced from 8px */
        }

        .trend-up { background: #c6f6d5; color: #22543d; }
        .trend-down { background: #fed7d7; color: #742a2a; }

        /* Section Headers - Compact */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px !important; /* Reduced from 25px */
        }

        .section-header h2 {
            font-size: 16px !important; /* Reduced from 20px */
            font-weight: 700;
            color: #2d3748;
            margin: 0;
            position: relative;
            padding-left: 12px;
        }

        .section-header h2::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 16px;
            background: var(--primary-gradient);
            border-radius: 4px;
        }

        .view-all-btn {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 5px 12px !important; /* Reduced from 8px 16px */
            color: #4a5568;
            font-weight: 500;
            font-size: 11px !important; /* Reduced from 13px */
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .view-all-btn:hover {
            border-color: #667eea;
            color: #667eea;
            transform: translateX(3px);
        }

        /* Tables - Compact */
        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 6px !important; /* Reduced from 10px */
        }

        .modern-table thead th {
            padding: 10px 15px !important; /* Reduced from 15px 20px */
            font-size: 11px !important; /* Reduced from 13px */
            font-weight: 600;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            background: #f7fafc;
            border: none;
        }

        .modern-table tbody td {
            padding: 10px 15px !important; /* Reduced from 15px 20px */
            font-size: 12px !important; /* Reduced from 14px */
            color: #4a5568;
            border: none;
        }

        /* Chart Cards - Compact */
        .chart-card {
            background: white;
            border-radius: 18px !important; /* Reduced from 25px */
            padding: 18px !important; /* Reduced from 25px */
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
            height: 100%;
        }

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px !important; /* Reduced from 20px */
        }

        .chart-header h3 {
            font-size: 15px !important; /* Reduced from 18px */
            font-weight: 700;
            color: #2d3748;
            margin: 0;
        }

        /* Tab Navigation - Compact */
        .chart-tabs {
            display: flex;
            gap: 6px;
            background: #f7fafc;
            padding: 4px;
            border-radius: 8px;
        }

        .chart-tab {
            padding: 5px 12px !important; /* Reduced from 8px 16px */
            font-size: 11px !important; /* Reduced from 13px */
            font-weight: 600;
            color: #718096;
            background: transparent;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        /* Welcome Section - Compact */
        .welcome-section {
            margin-bottom: 20px !important;
        }

        .welcome-section h1 {
            font-size: 22px !important; /* Reduced from 28px */
            margin-bottom: 5px !important;
        }

        .welcome-section p {
            font-size: 13px !important;
        }

        /* Grid Gaps - Reduced */
        .row.g-4 {
            --bs-gutter-y: 1rem !important; /* Reduced from 1.5rem */
            margin-bottom: 1.5rem !important; /* Reduced from 3rem */
        }

        /* Badges - Compact */
        .badge {
            padding: 5px 10px !important;
            font-size: 11px !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stat-value {
                font-size: 18px !important;
            }

            .stat-icon {
                width: 40px !important;
                height: 40px !important;
                font-size: 18px !important;
            }

            .col-xl-3.col-lg-4.col-md-6 {
                margin-bottom: 10px;
            }
        }
    </style>

    <div class="page-content">
        <div class="container-fluid">
            <!-- Welcome Section - Compact -->
            <div class="row mb-3"> <!-- Reduced from mb-4 -->
                <div class="col-12">
                    <div class="chart-card d-flex align-items-center justify-content-between welcome-section">
                        <div>
                            <h1 class="fw-bold mb-1" style="font-size: 22px; color: #2d3748;">
                                👋 {{ __('Welcome back,') }} {{ Auth::user()->name }}!
                            </h1>
                            <p class="text-muted mb-0" style="font-size: 13px;">
                                <i class="fas fa-calendar-alt me-1 text-primary"></i>
                                {{ now()->format('l, d F Y') }}
                                <span class="mx-1">•</span>
                                <i class="fas fa-clock me-1 text-success"></i>
                                {{ now()->format('h:i A') }}
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge bg-light text-dark p-2 rounded-3" style="font-size: 12px;">
                                <i class="fas fa-globe me-1 text-primary"></i>
                                {{ get_option('app_name') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid - Compact Layout - 6 cards per row -->
            <div class="row row-cols-xxl-6 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3 mb-4">
                <!-- Admin Stats -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $total_admins }}</div>
                            <div class="stat-label">{{ __('Total Admin') }}</div>
                            <span class="stat-trend trend-up">
                                <i class="fas fa-arrow-up me-1"></i> 12%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Instructor Stats -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $total_instructors }}</div>
                            <div class="stat-label">{{ __('Instructors') }}</div>
                            <span class="stat-trend trend-up">
                                <i class="fas fa-arrow-up me-1"></i> 8%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Student Stats -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #84fab0, #8fd3f4);">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $total_students }}</div>
                            <div class="stat-label">{{ __('Students') }}</div>
                            <span class="stat-trend trend-up">
                                <i class="fas fa-arrow-up me-1"></i> 15%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Course Stats -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #fad961, #f76b1c);">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $total_courses }}</div>
                            <div class="stat-label">{{ __('Courses') }}</div>
                            <span class="stat-trend trend-up">
                                <i class="fas fa-arrow-up me-1"></i> 25%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Active Courses -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $total_active_courses }}</div>
                            <div class="stat-label">{{ __('Active') }}</div>
                            <span class="stat-trend trend-up">
                                <i class="fas fa-arrow-up me-1"></i> 10%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Pending Courses -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a, #fee140);">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $total_pending_courses }}</div>
                            <div class="stat-label">{{ __('Pending') }}</div>
                            <span class="stat-trend trend-down">
                                <i class="fas fa-arrow-down me-1"></i> 5%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Free Courses -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #a8edea, #fed6e3);">
                            <i class="fas fa-gift"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $total_free_courses }}</div>
                            <div class="stat-label">{{ __('Free') }}</div>
                            <span class="stat-trend trend-up">
                                <i class="fas fa-arrow-up me-1"></i> 20%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Paid Courses -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            <i class="fas fa-crown"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $total_paid_courses }}</div>
                            <div class="stat-label">{{ __('Paid') }}</div>
                            <span class="stat-trend trend-up">
                                <i class="fas fa-arrow-up me-1"></i> 30%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Lessons Stats -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #ff9a9e, #fad0c4);">
                            <i class="fas fa-video"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $total_lessons }}</div>
                            <div class="stat-label">{{ __('Lessons') }}</div>
                            <span class="stat-trend trend-up">
                                <i class="fas fa-arrow-up me-1"></i> 40%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Lectures Stats -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #a18cd1, #fbc2eb);">
                            <i class="fas fa-play-circle"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $total_lectures }}</div>
                            <div class="stat-label">{{ __('Lectures') }}</div>
                            <span class="stat-trend trend-up">
                                <i class="fas fa-arrow-up me-1"></i> 35%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Blogs Stats -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #fbc2eb, #a6c1ee);">
                            <i class="fas fa-blog"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $total_blogs }}</div>
                            <div class="stat-label">{{ __('Blogs') }}</div>
                            <span class="stat-trend trend-up">
                                <i class="fas fa-arrow-up me-1"></i> 5%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Revenue Stats -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #f6d365, #fda085);">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">
                                @if(get_currency_placement() == 'after')
                                    {{ $total_revenue }} {{ get_currency_symbol() }}
                                @else
                                    {{ get_currency_symbol() }} {{ $total_revenue }}
                                @endif
                            </div>
                            <div class="stat-label">{{ __('Revenue') }}</div>
                            <span class="stat-trend trend-up">
                                <i class="fas fa-arrow-up me-1"></i> 45%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Platform Charge -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #84fab0, #8fd3f4);">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">
                                @if(get_currency_placement() == 'after')
                                    {{ $total_platform_charge }} {{ get_currency_symbol() }}
                                @else
                                    {{ get_currency_symbol() }} {{ $total_platform_charge }}
                                @endif
                            </div>
                            <div class="stat-label">{{ __('Platform') }}</div>
                            <span class="stat-trend trend-up">
                                <i class="fas fa-arrow-up me-1"></i> 12%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Admin Commission -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a, #fee140);">
                            <i class="fas fa-percent"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">
                                @if(get_currency_placement() == 'after')
                                    {{ $total_admin_commission }} {{ get_currency_symbol() }}
                                @else
                                    {{ get_currency_symbol() }} {{ $total_admin_commission }}
                                @endif
                            </div>
                            <div class="stat-label">{{ __('Commission') }}</div>
                            <span class="stat-trend trend-up">
                                <i class="fas fa-arrow-up me-1"></i> 18%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Withdraw Stats -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #a8edea, #fed6e3);">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">
                                @if(get_currency_placement() == 'after')
                                    {{ $total_new_withdraws }} {{ get_currency_symbol() }}
                                @else
                                    {{ get_currency_symbol() }} {{ $total_new_withdraws }}
                                @endif
                            </div>
                            <div class="stat-label">{{ __('Pending W') }}</div>
                            <span class="stat-trend trend-down">
                                <i class="fas fa-arrow-down me-1"></i> 8%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Complete Withdraw -->
                <div class="col">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">
                                @if(get_currency_placement() == 'after')
                                    {{ $total_complete_withdraws }} {{ get_currency_symbol() }}
                                @else
                                    {{ get_currency_symbol() }} {{ $total_complete_withdraws }}
                                @endif
                            </div>
                            <div class="stat-label">{{ __('Completed W') }}</div>
                            <span class="stat-trend trend-up">
                                <i class="fas fa-arrow-up me-1"></i> 22%
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row - Compact -->
            <div class="row g-3 mb-4"> <!-- Reduced from g-4 mb-5 -->
                <div class="col-lg-8">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>
                                <i class="fas fa-chart-line me-2 text-primary"></i>
                                {{ __('Enrollment Overview') }}
                            </h3>
                            <div class="chart-tabs">
                                <button class="chart-tab" id="monthTab">{{ __('Month') }}</button>
                                <button class="chart-tab active" id="yearTab">{{ __('Year') }}</button>
                            </div>
                        </div>
                        <div class="total-profit mb-2 p-2 bg-light rounded-3"> <!-- Reduced margin/padding -->
                            <h5 class="mb-0" style="font-size: 14px;"> <!-- Smaller heading -->
                                {{ __('Total Enrollment') }}:
                                <span class="text-primary fw-bold ms-2">{{ $total_enrolments }}</span>
                            </h5>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade" id="monthChart">
                                <div id="chartMonth" style="height: 280px;"></div> <!-- Reduced height -->
                            </div>
                            <div class="tab-pane fade show active" id="yearChart">
                                <div id="chartYear" style="height: 280px;"></div> <!-- Reduced height -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>
                                <i class="fas fa-chart-pie me-2 text-success"></i>
                                {{ __('Top Sellers') }}
                            </h3>
                        </div>
                        <div id="topSellerChart" style="height: 280px;"></div> <!-- Reduced height -->
                    </div>
                </div>
            </div>

            <!-- Tables Row - Compact -->
            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="chart-card">
                        <div class="section-header">
                            <h2>
                                <i class="fas fa-star me-2 text-warning"></i>
                                {{ __('Top Courses') }}
                            </h2>
                            <a href="{{ route('admin.course.index') }}" class="view-all-btn">
                                {{ __('View All') }}
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div style="max-height: 300px; overflow-y: auto;"> <!-- Scrollable table -->
                            <table class="modern-table">
                                <thead>
                                <tr>
                                    <th>{{ __('Course') }}</th>
                                    <th>{{ __('Instructor') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Enroll') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($total_ten_courses as $course)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-1">
                                                <i class="fas fa-play-circle text-primary" style="font-size: 12px;"></i>
                                                <a href="{{ route('admin.course.view', $course->uuid) }}"
                                                   class="text-decoration-none text-dark fw-medium" style="font-size: 12px;">
                                                    {{ Str::limit($course->title, 25) }}
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark" style="font-size: 11px;">
                                                <i class="fas fa-user me-1"></i>
                                                {{ Str::limit(@$course->instructor->name, 10) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success text-white" style="font-size: 11px;">
                                                @if($course->price > 0)
                                                    {{ get_currency_symbol() }}{{ $course->price }}
                                                @else
                                                    {{ __('Free') }}
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary text-white" style="font-size: 11px;">
                                                <i class="fas fa-users me-1"></i>
                                                {{ $course->totalOrder }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="chart-card">
                        <div class="section-header">
                            <h2>
                                <i class="fas fa-hand-holding-usd me-2 text-danger"></i>
                                {{ __('Withdrawal Requests') }}
                            </h2>
                            <a href="{{ route('payout.new-withdraw') }}" class="view-all-btn">
                                {{ __('View All') }}
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div style="max-height: 300px; overflow-y: auto;"> <!-- Scrollable table -->
                            <table class="modern-table">
                                <thead>
                                <tr>
                                    <th>{{ __('Instructor') }}</th>
                                    <th>{{ __('Method') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($withdraws as $withdraw)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-1">
                                                <i class="fas fa-user-circle text-info" style="font-size: 12px;"></i>
                                                <div>
                                                    <div class="fw-medium" style="font-size: 12px;">
                                                        {{ Str::limit($withdraw->user->student->name ?? $withdraw->user->instructor->name, 10) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark" style="font-size: 11px;">
                                                @if($withdraw->payment_method == 'paypal')
                                                    <i class="fab fa-paypal me-1 text-primary"></i> PayPal
                                                @else
                                                    <i class="fas fa-credit-card me-1 text-success"></i> Card
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted" style="font-size: 11px;">
                                                <i class="far fa-calendar me-1"></i>
                                                {{ $withdraw->created_at->format('d M') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-primary" style="font-size: 12px;">
                                                @if(get_currency_placement() == 'after')
                                                    {{ $withdraw->amount }} {{ get_currency_symbol() }}
                                                @else
                                                    {{ get_currency_symbol() }} {{ $withdraw->amount }}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3">
                                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                            <p class="text-muted small">{{ __('No requests') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict'

        // Chart Tabs
        document.addEventListener('DOMContentLoaded', function() {
            const monthTab = document.getElementById('monthTab');
            const yearTab = document.getElementById('yearTab');
            const monthChart = document.getElementById('monthChart');
            const yearChart = document.getElementById('yearChart');

            monthTab.addEventListener('click', function() {
                monthTab.classList.add('active');
                yearTab.classList.remove('active');
                monthChart.classList.add('show', 'active');
                yearChart.classList.remove('show', 'active');
            });

            yearTab.addEventListener('click', function() {
                yearTab.classList.add('active');
                monthTab.classList.remove('active');
                yearChart.classList.add('show', 'active');
                monthChart.classList.remove('show', 'active');
            });

            // Month Chart
            var monthOptions = {
                series: [{
                    name: '{{ __("Enroll") }}',
                    data: @json($totalMonthlyEnroll)
                }],
                chart: {
                    height: 280, // Reduced from 350
                    type: 'area',
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                colors: ['#667eea'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.6,
                        opacityTo: 0.2
                    }
                },
                xaxis: {
                    categories: @json($totalMonths),
                    labels: { style: { fontSize: '11px' } }
                },
                yaxis: {
                    labels: { style: { fontSize: '11px' } }
                },
                grid: { borderColor: '#e2e8f0', strokeDashArray: 5 }
            };

            var monthChartObj = new ApexCharts(document.querySelector("#chartMonth"), monthOptions);
            monthChartObj.render();

            // Year Chart
            var yearOptions = {
                series: [{
                    name: '{{ __("Enroll") }}',
                    data: @json($totalYearlyEnroll)
                }],
                chart: {
                    height: 280, // Reduced from 350
                    type: 'area',
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                colors: ['#4facfe'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.6,
                        opacityTo: 0.2
                    }
                },
                xaxis: {
                    categories: @json($totalYears),
                    labels: { style: { fontSize: '11px' } }
                },
                yaxis: {
                    labels: { style: { fontSize: '11px' } }
                },
                grid: { borderColor: '#e2e8f0', strokeDashArray: 5 }
            };

            var yearChartObj = new ApexCharts(document.querySelector("#chartYear"), yearOptions);
            yearChartObj.render();

            // Top Seller Chart
            var sellerOptions = {
                series: @json(@$allPercentage),
                chart: {
                    type: 'donut',
                    height: 280, // Reduced from 350
                    toolbar: { show: false }
                },
                labels: @json(@$allName),
                colors: ['#667eea', '#4facfe', '#84fab0', '#fad961', '#fa709a'],
                legend: {
                    position: 'bottom',
                    fontSize: '11px',
                    itemMargin: { vertical: 3 }
                },
                dataLabels: { enabled: false },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: '{{ __("Total") }}',
                                    fontSize: '12px',
                                    fontWeight: 600
                                }
                            }
                        }
                    }
                }
            };

            var sellerChart = new ApexCharts(document.querySelector("#topSellerChart"), sellerOptions);
            sellerChart.render();

            // Refresh stats every 5 minutes
            setInterval(function() {
                location.reload();
            }, 300000);
        });
    </script>
@endpush