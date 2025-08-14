@extends('layouts.admin_template')
@section('title', 'Dashboard Admin')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Welcome Card -->
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card luxury-welcome-card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-white">Dashboard Admin</h5>
                                <p class="mb-4 text-white opacity-75">
                                    Selamat Datang di Sistem Monitoring Kinerja Dosen
                                </p>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-white text-primary me-2">v2.1</span>
                                    <small class="text-white">Last updated: {{ now()->addHours(7)->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4 position-relative">
                                <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140"
                                    alt="View Badge User" class="img-fluid floating" />
                                <div class="floating-dots">
                                    <div class="dot dot-1"></div>
                                    <div class="dot dot-2"></div>
                                    <div class="dot dot-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <!-- Total Users -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card stat-card card-hover-zoom">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="stat-title">Total Pengguna</h6>
                                <h3 class="stat-value">{{ $totalUsers }}</h3>
                                <div class="stat-progress">
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-primary" style="width: 75%"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="stat-icon bg-primary">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Users -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card stat-card card-hover-zoom">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="stat-title">Admin</h6>
                                <h3 class="stat-value">{{ $adminCount }}</h3>
                                <div class="stat-progress">
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-danger" style="width: 45%"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="stat-icon bg-danger">
                                <i class="fas fa-user-shield"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dosen Users -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card stat-card card-hover-zoom">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="stat-title">Dosen</h6>
                                <h3 class="stat-value">{{ $dosenCount }}</h3>
                                <div class="stat-progress">
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-success" style="width: 68%"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="stat-icon bg-success">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mata Kuliah -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card stat-card card-hover-zoom">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="stat-title">Mata Kuliah</h6>
                                <h3 class="stat-value">{{ $matkulCount }}</h3>
                                <div class="stat-progress">
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-info" style="width: 82%"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="stat-icon bg-info">
                                <i class="fas fa-book"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kinerja Penelitian -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card stat-card card-hover-zoom">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="stat-title">Penelitian</h6>
                                <h3 class="stat-value">{{ $penelitianCount }}</h3>
                                <div class="stat-progress">
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-warning" style="width: 60%"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="stat-icon bg-warning">
                                <i class="fas fa-flask"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kinerja Pengabdian -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card stat-card card-hover-zoom">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="stat-title">Pengabdian</h6>
                                <h3 class="stat-value">{{ $pengabdianCount }}</h3>
                                <div class="stat-progress">
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-purple" style="width: 55%"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="stat-icon bg-purple">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kinerja Pengajaran -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card stat-card card-hover-zoom">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="stat-title">Pengajaran</h6>
                                <h3 class="stat-value">{{ $pengajaranCount }}</h3>
                                <div class="stat-progress">
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-teal" style="width: 90%"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="stat-icon bg-teal">
                                <i class="fas fa-chalkboard"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kinerja Penunjang -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card stat-card card-hover-zoom">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="stat-title">Penunjang</h6>
                                <h3 class="stat-value">{{ $penunjangCount }}</h3>
                                <div class="stat-progress">
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-orange" style="width: 40%"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="stat-icon bg-orange">
                                <i class="fas fa-tasks"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card glass-card">
                    <div class="card-header d-flex justify-content-between align-items-center border-0">
                        <h5 class="card-title mb-0 ">Analisis Kinerja Dosen</h5>
                        <div class="d-flex">
                            <select id="dosenFilter" class="form-select form-select-sm me-2 bg-dark ">
                                <option value="">Semua Dosen</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                                @endforeach
                            </select>
                            <select id="semesterFilter" class="form-select form-select-sm me-2 bg-dark ">
                                <option value="">Semua Semester</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}">{{ $semester->nama_semester }} - {{ $semester->tahun_ajaran }}</option>
                                @endforeach
                            </select>
                            <select id="tahunFilter" class="form-select form-select-sm bg-dark ">
                                <option value="">Semua Tahun</option>
                                @foreach($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-body position-relative">
                        <div class="row">
                            <div class="col-md-8">
                                <canvas id="barChart" height="250"></canvas>
                            </div>
                            <div class="col-md-4">
                                <canvas id="radarChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Luxury Welcome Card */
        .luxury-welcome-card {
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
            color: white;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(58, 123, 213, 0.3);
            position: relative;
            z-index: 1;
        }

        .luxury-welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            z-index: -1;
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        .floating-dots {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: -1;
        }

        .dot {
            position: absolute;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            animation: float 15s linear infinite;
        }

        .dot-1 {
            width: 10px;
            height: 10px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .dot-2 {
            width: 15px;
            height: 15px;
            top: 60%;
            left: 30%;
            animation-delay: 3s;
        }

        .dot-3 {
            width: 8px;
            height: 8px;
            top: 40%;
            left: 80%;
            animation-delay: 6s;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        @keyframes float {
            0% { transform: translateY(0) translateX(0); opacity: 1; }
            100% { transform: translateY(-100px) translateX(20px); opacity: 0; }
        }

        /* Stat Cards */
        .stat-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            background: white;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #3a7bd5, #00d2ff);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .stat-card:hover::after {
            transform: scaleX(1);
        }

        .card-hover-zoom:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .stat-title {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #343a40;
            font-family: 'Poppins', sans-serif;
        }

        .stat-progress {
            margin-top: 10px;
        }

        /* Color Variations */
        .bg-purple {
            background: linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%) !important;
        }

        .bg-teal {
            background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%) !important;
        }

        .bg-orange {
            background: linear-gradient(135deg, #f46b45 0%, #eea849 100%) !important;
        }

        .bg-primary {
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%) !important;
        }

        .bg-danger {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%) !important;
        }

        .bg-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
        }

        .bg-info {
            background: linear-gradient(135deg, #1fa2ff 0%, #12d8fa 100%) !important;
        }

        .bg-warning {
            background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%) !important;
        }

        /* Glass Card for Charts */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            overflow: hidden;
            color: rgb(0, 0, 0);
        }

        .glass-card .card-header {
            background: rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Form Elements */
        .bg-dark {
            background: rgba(0, 0, 0, 0.2) !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgb(0, 0, 0) !important;
        }

        .bg-dark:focus {
            background: rgba(0, 0, 0, 0.3) !important;
            border-color: rgba(156, 156, 156, 0.3);
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.1);
        }

        /* Loading Indicator */
        .chart-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.7);
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            z-index: 100;
            color: white;
            font-weight: 500;
        }
    </style>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Initialize charts with empty data first
        const barCtx = document.getElementById('barChart').getContext('2d');
        const radarCtx = document.getElementById('radarChart').getContext('2d');

        // Gradient for bar chart
        let barGradient = barCtx.createLinearGradient(0, 0, 0, 300);
        barGradient.addColorStop(0, 'rgba(58, 123, 213, 0.8)');
        barGradient.addColorStop(1, 'rgba(0, 210, 255, 0.8)');

        // Gradient for radar chart
        let radarGradient = radarCtx.createLinearGradient(0, 0, 0, 300);
        radarGradient.addColorStop(0, 'rgba(0, 210, 255, 0.3)');
        radarGradient.addColorStop(1, 'rgba(58, 123, 213, 0.3)');

        let barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Total Skor Kinerja',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: barGradient,
                    borderColor: 'rgba(0, 0, 0, 0.8)',
                    borderWidth: 1,
                    borderRadius: 8,
                    hoverBackgroundColor: 'rgba(120, 120, 120, 0.6)',
                    hoverBorderColor: 'rgba(120, 120, 120, 1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: 'black'
                        }
                    },
                   tooltip: {
                        backgroundColor: 'rgba(128, 128, 128, 0.2)', // putih transparan
                        titleColor: '#000', // judul hitam
                        bodyColor: '#000',  // isi hitam
                        borderColor: 'rgba(0, 0, 0, 0.5)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        // Tambahan untuk efek glass
                        external: function(context) {
                            const tooltipEl = context.tooltip.el;
                            if (tooltipEl) {
                                tooltipEl.style.backdropFilter = 'blur(8px)';
                                tooltipEl.style.webkitBackdropFilter = 'blur(8px)'; // Safari
                            }
                        }
                    }

                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Skor Kinerja',
                            color: '#000'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.2)'
                        },
                        ticks: {
                            color: 'rgba(0, 0, 0, 0.7)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Dosen',
                            color: '#000'
                        },
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: 'rgba(0, 0, 0, 0.8)'
                        }
                    }
                }
            }
        });

        let radarChart = new Chart(radarCtx, {
            type: 'radar',
            data: {
                labels: ['Pengajaran', 'Penelitian', 'Pengabdian', 'Penunjang'],
                datasets: [{
                    label: 'Rata-rata Skor',
                    data: {!! json_encode($radarData) !!},
                    backgroundColor: radarGradient,
                    borderColor: 'rgba(0, 0, 0, 0.8)',
                    pointBackgroundColor: 'rgba(120, 120, 120, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(120, 120, 120, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#000'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(130, 130, 130, 0.2)',
                        titleColor: '#000',
                        bodyColor: '#000',
                        borderColor: 'rgba(0, 0, 0, 0.2)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    r: {
                        angleLines: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        suggestedMin: 0,
                        suggestedMax: 100,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.3)'
                        },
                        pointLabels: {
                            color: '#000'
                        },
                        ticks: {
                            backdropColor: 'transparent',
                            color: 'rgba(0, 0, 0, 0.3)',
                            showLabelBackdrop: false
                        }
                    }
                }
            }
        });

        // Filter functionality with debounce to prevent multiple rapid requests
        $(document).ready(function() {
            let filterTimeout;

            $('#dosenFilter, #semesterFilter, #tahunFilter').change(function() {
                // Clear previous timeout
                clearTimeout(filterTimeout);

                // Show loading indicator
                $('.card-body').append('<div class="chart-loading">Memuat data...</div>');

                // Set new timeout
                filterTimeout = setTimeout(function() {
                    const dosenId = $('#dosenFilter').val();
                    const semesterId = $('#semesterFilter').val();
                    const tahun = $('#tahunFilter').val();

                    $.ajax({
                        url: '{{ route("admin.dashboard.filter") }}',
                        type: 'GET',
                        data: {
                            dosen_id: dosenId,
                            semester_id: semesterId,
                            tahun: tahun
                        },
                        success: function(response) {
                            if (response.status !== 'success') {
                                console.error('Error in response:', response.message);
                                return;
                            }

                            // Update bar chart
                            barChart.data.labels = response.chartLabels || [];
                            barChart.data.datasets[0].data = response.chartData || [];

                            // Adjust y-axis max if no data
                            if (response.chartData && response.chartData.length > 0) {
                                barChart.options.scales.y.max = Math.max(...response.chartData) + 10;
                            } else {
                                barChart.options.scales.y.max = 100;
                            }
                            barChart.update();

                            // Update radar chart
                            radarChart.data.datasets[0].data = response.radarData || [0, 0, 0, 0];
                            radarChart.update();
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr.responseText);
                            alert('Terjadi kesalahan saat memuat data.');
                        },
                        complete: function() {
                            $('.chart-loading').remove();
                        }
                    });
                }, 500); // 500ms delay
            });
        });
    </script>

@endsection
