<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Management Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .metric-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }
        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }
        .metric-value {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 10px 0;
        }
        .metric-title {
            color: #6c757d;
            font-size: 0.95rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .gauge-container {
            position: relative;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .gauge-label {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 1.3rem;
            font-weight: 700;
        }
        .gauge-subtitle {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.8rem;
            color: #6c757d;
        }
        .text-receivable { color: #4e73df; }
        .text-payable { color: #e74a3b; }
        .text-success-custom { color: #1cc88a; }
        .text-warning-custom { color: #f6c23e; }
        .bg-receivable { background-color: #4e73df; }
        .bg-payable { background-color: #e74a3b; }
        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }
        .info-icon {
            cursor: pointer;
            color: #6c757d;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="dashboard-header">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fas fa-chart-line me-2"></i>Financial Management</h2>
                    <p class="mb-0 opacity-75">Real-time Financial Analytics Dashboard</p>
                </div>
                <div class="text-end">
                    <small>Last Updated: {{ now()->format('d M Y, H:i') }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <!-- Top Metrics Row -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-title">Total Accounts Receivable</div>
                    <div class="metric-value text-receivable">
                        Rp {{ number_format($totalReceivable, 0, ',', '.') }}
                    </div>
                    <div class="text-muted small">
                        <i class="fas fa-arrow-up text-success"></i> Outstanding invoices
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-title">Total Accounts Payable</div>
                    <div class="metric-value text-payable">
                        Rp {{ number_format($totalPayable, 0, ',', '.') }}
                    </div>
                    <div class="text-muted small">
                        <i class="fas fa-arrow-down text-danger"></i> Outstanding bills
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-title">Equity Ratio</div>
                    <div class="metric-value text-success-custom">
                        {{ number_format($equityRatio, 2) }} %
                    </div>
                    <div class="text-muted small">
                        <i class="fas fa-info-circle"></i> Financial health indicator
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-title">Debt Equity</div>
                    <div class="metric-value text-warning-custom">
                        {{ number_format($debtEquity, 2) }} %
                    </div>
                    <div class="text-muted small">
                        <i class="fas fa-balance-scale"></i> Leverage ratio
                    </div>
                </div>
            </div>
        </div>

        <!-- Gauges Row -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-title">Current Ratio <i class="fas fa-info-circle info-icon"></i></div>
                    <div class="gauge-container">
                        <canvas id="currentRatioGauge"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-title">DSI <span class="small text-muted">[Days Sales Inventory]</span></div>
                    <div class="gauge-container">
                        <canvas id="dsiGauge"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-title">DSO <span class="small text-muted">[Days Sales Outstanding]</span></div>
                    <div class="gauge-container">
                        <canvas id="dsoGauge"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-title">DPO <span class="small text-muted">[Days Payable Outstanding]</span></div>
                    <div class="gauge-container">
                        <canvas id="dpoGauge"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aging Analysis -->
        <div class="row">
            <div class="col-lg-6">
                <div class="chart-container">
                    <div class="chart-title">Total Accounts Receivable and Payable Aging</div>
                    <canvas id="agingChart" height="100"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-container">
                    <div class="chart-title">Cash Flow Trend</div>
                    <canvas id="cashFlowChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Working Capital & P&L -->
        <div class="row">
            <div class="col-lg-6">
                <div class="chart-container">
                    <div class="chart-title">Net Working Capital vs Gross Working Capital</div>
                    <canvas id="workingCapitalChart" height="100"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-container">
                    <div class="chart-title">Profit and Loss Summary</div>
                    <canvas id="profitLossChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Additional Analysis -->
        <div class="row">
            <div class="col-lg-12">
                <div class="chart-container">
                    <div class="chart-title">Monthly Revenue Breakdown</div>
                    <canvas id="revenueBreakdownChart" height="60"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Gauge Chart Helper Function
        function createGauge(canvasId, value, max, label, color) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            const percentage = (value / max) * 100;
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [value, max - value],
                        backgroundColor: [color, '#e9ecef'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    circumference: 180,
                    rotation: 270,
                    cutout: '75%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    }
                },
                plugins: [{
                    afterDraw: function(chart) {
                        const ctx = chart.ctx;
                        const centerX = chart.chartArea.left + (chart.chartArea.right - chart.chartArea.left) / 2;
                        const centerY = chart.chartArea.bottom;
                        
                        ctx.save();
                        ctx.font = 'bold 28px Arial';
                        ctx.fillStyle = color;
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.fillText(label, centerX, centerY - 20);
                        
                        ctx.font = '12px Arial';
                        ctx.fillStyle = '#6c757d';
                        ctx.fillText('0', chart.chartArea.left, centerY + 5);
                        ctx.fillText(max, chart.chartArea.right, centerY + 5);
                        ctx.restore();
                    }
                }]
            });
        }

        // Create Gauges
        createGauge('currentRatioGauge', {{ $currentRatio }}, 3, '{{ $currentRatio }}', '#4e73df');
        createGauge('dsiGauge', {{ $dsi }}, 31, '{{ $dsi }} Days', '#f6c23e');
        createGauge('dsoGauge', {{ $dso }}, 31, '{{ $dso }} Days', '#e74a3b');
        createGauge('dpoGauge', {{ $dpo }}, 31, '{{ $dpo }} Days', '#1cc88a');

        // Aging Chart
        const agingCtx = document.getElementById('agingChart').getContext('2d');
        new Chart(agingCtx, {
            type: 'bar',
            data: {
                labels: ['Current', '1-30', '31-60', '61-90', '91+'],
                datasets: [{
                    label: 'Accounts Receivable',
                    data: [
                        {{ $agingReceivable->get('Current')->total_amount ?? 0 }},
                        {{ $agingReceivable->get('1-30')->total_amount ?? 0 }},
                        {{ $agingReceivable->get('31-60')->total_amount ?? 0 }},
                        {{ $agingReceivable->get('61-90')->total_amount ?? 0 }},
                        {{ $agingReceivable->get('91+')->total_amount ?? 0 }}
                    ],
                    backgroundColor: '#4e73df'
                }, {
                    label: 'Accounts Payable',
                    data: [
                        {{ $agingPayable->get('Current')->total_amount ?? 0 }},
                        {{ $agingPayable->get('1-30')->total_amount ?? 0 }},
                        {{ $agingPayable->get('31-60')->total_amount ?? 0 }},
                        {{ $agingPayable->get('61-90')->total_amount ?? 0 }},
                        {{ $agingPayable->get('91+')->total_amount ?? 0 }}
                    ],
                    backgroundColor: '#e74a3b'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Cash Flow Chart
        const cashFlowCtx = document.getElementById('cashFlowChart').getContext('2d');
        new Chart(cashFlowCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($profitLoss->pluck('month')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M'))) !!},
                datasets: [{
                    label: 'Net Profit',
                    data: {!! json_encode($profitLoss->pluck('net_profit')) !!},
                    borderColor: '#1cc88a',
                    backgroundColor: 'rgba(28, 200, 138, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Working Capital Chart
        const wcCtx = document.getElementById('workingCapitalChart').getContext('2d');
        new Chart(wcCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($workingCapital->pluck('month')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M'))) !!},
                datasets: [{
                    label: 'Net Working Capital',
                    data: {!! json_encode($workingCapital->pluck('net_working_capital')) !!},
                    borderColor: '#f6c23e',
                    yAxisID: 'y'
                }, {
                    label: 'Gross Working Capital',
                    data: {!! json_encode($workingCapital->pluck('gross_working_capital')) !!},
                    borderColor: '#4e73df',
                    yAxisID: 'y'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Profit & Loss Chart
        const plCtx = document.getElementById('profitLossChart').getContext('2d');
        new Chart(plCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($profitLoss->pluck('month')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M'))) !!},
                datasets: [{
                    label: 'Revenue',
                    data: {!! json_encode($profitLoss->pluck('revenue')) !!},
                    backgroundColor: '#4e73df'
                }, {
                    label: 'COGS',
                    data: {!! json_encode($profitLoss->pluck('cost_of_goods')) !!},
                    backgroundColor: '#e74a3b'
                }, {
                    label: 'Operating Expenses',
                    data: {!! json_encode($profitLoss->pluck('operating_expenses')) !!},
                    backgroundColor: '#f6c23e'
                }, {
                    label: 'Other Income',
                    data: {!! json_encode($profitLoss->pluck('other_income')) !!},
                    backgroundColor: '#1cc88a'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Revenue Breakdown Chart
        const revCtx = document.getElementById('revenueBreakdownChart').getContext('2d');
        new Chart(revCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($profitLoss->pluck('month')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M'))) !!},
                datasets: [{
                    label: 'Revenue',
                    data: {!! json_encode($profitLoss->pluck('revenue')) !!},
                    backgroundColor: '#667eea'
                }, {
                    label: 'Net Profit',
                    data: {!! json_encode($profitLoss->pluck('net_profit')) !!},
                    backgroundColor: '#1cc88a',
                    type: 'line',
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { 
                        beginAtZero: true,
                        position: 'left'
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>