<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Accounting System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f2f3f5;
            color: #898989;
            font-size: 14px;
            font-weight: 300;
        }

        .main-wrapper {
            padding: 30px;
        }

        /* Page Title */
        .page_title {
            margin-bottom: 30px;
        }

        .page_title h4 {
            font-size: 24px;
            color: #000;
            font-weight: 700;
            margin: 0;
        }

        /* Card Counter Styles */
        .card-counter {
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
            padding: 25px 20px;
            border-radius: 12px;
            color: #fff;
            margin-bottom: 25px;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .card-counter::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transition: all 0.5s ease;
        }

        .card-counter:hover::before {
            top: -25%;
            right: -25%;
        }

        .card-counter:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .card-counter i {
            font-size: 38px;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .card-counter .total_no {
            font-size: 28px;
            font-weight: 700;
            margin: 10px 0 5px;
        }

        .card-counter .head_couter {
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            opacity: 0.95;
            font-weight: 400;
        }

        .red_bg { background: linear-gradient(135deg, #ff4748 0%, #e63946 100%); }
        .blue_bg { background: linear-gradient(135deg, #36a9e2 0%, #1e88c7 100%); }
        .yellow_bg { background: linear-gradient(135deg, #fabb3d 0%, #f9a825 100%); }
        .green_bg { background: linear-gradient(135deg, #79c347 0%, #5fa732 100%); }
        .green_bg2 { background: linear-gradient(135deg, #1ed085 0%, #17a86b 100%); }
        .purple_bg { background: linear-gradient(135deg, #8e68ef 0%, #7344e8 100%); }

        /* Chart Cards */
        .chart-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .chart-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }

        .chart-card h5 {
            font-size: 18px;
            color: #000;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f2f3f5;
        }

        /* Table Card */
        .table-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            overflow: hidden;
            margin-bottom: 25px;
        }

        .table-card .card-header {
            background: linear-gradient(135deg, #36a9e2 0%, #1e88c7 100%);
            color: #fff;
            padding: 20px 25px;
            border: none;
        }

        .table-card .card-header h5 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #fff;
            border: none;
            padding: 0;
        }

        .table-card .card-body {
            padding: 0;
        }

        .custom-table {
            margin: 0;
        }

        .custom-table thead th {
            background: #f8f9fa;
            color: #000;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            padding: 15px 20px;
            border: none;
            letter-spacing: 0.5px;
        }

        .custom-table tbody td {
            padding: 15px 20px;
            color: #58718a;
            border-bottom: 1px solid #f2f3f5;
            vertical-align: middle;
        }

        .custom-table tbody tr:hover {
            background: #f8f9fa;
            transition: all 0.2s ease;
        }

        .badge-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-paid {
            background: #79c347;
            color: #fff;
        }

        .badge-pending {
            background: #fabb3d;
            color: #fff;
        }

        .badge-overdue {
            background: #ff4748;
            color: #fff;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            background: #fff;
            color: #58718a;
            transition: all 0.2s ease;
            margin: 0 2px;
        }

        .btn-action:hover {
            background: #36a9e2;
            border-color: #36a9e2;
            color: #fff;
            transform: translateY(-2px);
        }

        /* Quick Actions Card */
        .quick-actions-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            padding: 25px;
            margin-bottom: 25px;
        }

        .quick-actions-card h5 {
            font-size: 18px;
            color: #000;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f2f3f5;
        }

        .btn-quick-action {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            margin-bottom: 10px;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-quick-action i {
            margin-right: 8px;
        }

        .btn-quick-primary {
            background: linear-gradient(135deg, #36a9e2 0%, #1e88c7 100%);
            color: #fff;
        }

        .btn-quick-primary:hover {
            background: linear-gradient(135deg, #1e88c7 0%, #1660a0 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(54, 169, 226, 0.3);
        }

        .btn-quick-success {
            background: linear-gradient(135deg, #1ed085 0%, #17a86b 100%);
            color: #fff;
        }

        .btn-quick-success:hover {
            background: linear-gradient(135deg, #17a86b 0%, #128556 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 208, 133, 0.3);
        }

        .btn-quick-warning {
            background: linear-gradient(135deg, #fabb3d 0%, #f9a825 100%);
            color: #fff;
        }

        .btn-quick-warning:hover {
            background: linear-gradient(135deg, #f9a825 0%, #e89c1a 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(250, 187, 61, 0.3);
        }

        .btn-quick-purple {
            background: linear-gradient(135deg, #8e68ef 0%, #7344e8 100%);
            color: #fff;
        }

        .btn-quick-purple:hover {
            background: linear-gradient(135deg, #7344e8 0%, #5f2dd4 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(142, 104, 239, 0.3);
        }

        /* Notifications Card */
        .notifications-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            padding: 25px;
            margin-bottom: 25px;
        }

        .notifications-card h5 {
            font-size: 18px;
            color: #000;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f2f3f5;
        }

        .notification-item {
            display: flex;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 12px;
            transition: all 0.2s ease;
            border: 1px solid #f2f3f5;
        }

        .notification-item:hover {
            background: #f8f9fa;
            border-color: #e0e0e0;
        }

        .notification-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .notification-icon i {
            font-size: 20px;
        }

        .notification-icon.warning {
            background: rgba(250, 187, 61, 0.15);
            color: #fabb3d;
        }

        .notification-icon.success {
            background: rgba(121, 195, 71, 0.15);
            color: #79c347;
        }

        .notification-icon.info {
            background: rgba(54, 169, 226, 0.15);
            color: #36a9e2;
        }

        .notification-content h6 {
            font-size: 14px;
            font-weight: 600;
            color: #000;
            margin-bottom: 5px;
        }

        .notification-content p {
            font-size: 13px;
            color: #898989;
            margin-bottom: 5px;
        }

        .notification-content small {
            font-size: 12px;
            color: #b0b0b0;
        }

        @media (max-width: 768px) {
            .main-wrapper {
                padding: 15px;
            }
            
            .card-counter {
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <!-- Page Title -->
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title">
                    <h4>Dashboard – Term 1 (2024/2025)</h4>
                </div>
            </div>
        </div>

        <!-- Financial Summary Cards -->
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card-counter blue_bg">
                    <i class="fa fa-credit-card"></i>
                    <p class="total_no">2,450,000</p>
                    <p class="head_couter">Total Fees Billed</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card-counter green_bg">
                    <i class="fa fa-money-bill-wave"></i>
                    <p class="total_no">1,875,500</p>
                    <p class="head_couter">Total Fees Collected</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card-counter red_bg">
                    <i class="fa fa-balance-scale"></i>
                    <p class="total_no">574,500</p>
                    <p class="head_couter">Outstanding Balances</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card-counter yellow_bg">
                    <i class="fa fa-chart-line"></i>
                    <p class="total_no">1,301,000</p>
                    <p class="head_couter">Net Position</p>
                </div>
            </div>
        </div>

        <!-- Extra Income & Expenses Row -->
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="card-counter purple_bg">
                    <i class="fa fa-plus-circle"></i>
                    <p class="total_no">320,000</p>
                    <p class="head_couter">Other Income</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-6">
                <div class="card-counter green_bg2">
                    <i class="fa fa-minus-circle"></i>
                    <p class="total_no">894,500</p>
                    <p class="head_couter">Total Expenses</p>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="chart-card">
                    <h5>Fees vs Collections</h5>
                    <canvas id="feesPieChart" height="200"></canvas>
                </div>
            </div>

            <div class="col-md-6">
                <div class="chart-card">
                    <h5>Expenses Breakdown</h5>
                    <canvas id="expensesPieChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="chart-card">
                    <h5>Net Position Over Time</h5>
                    <canvas id="netLineChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Payments and Quick Actions -->
        <div class="row">
            <div class="col-lg-8">
                <div class="table-card">
                    <div class="card-header">
                        <h5><i class="fa fa-receipt me-2"></i> Recent Payments</h5>
                    </div>
                    <div class="card-body">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Class</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>STU-2024-001</strong></td>
                                    <td>John Kamau</td>
                                    <td>Form 4A</td>
                                    <td><strong>45,000</strong></td>
                                    <td>Oct 05, 2025</td>
                                    <td><span class="badge-status badge-paid">Paid</span></td>
                                    <td>
                                        <button class="btn-action" title="View"><i class="fa fa-eye"></i></button>
                                        <button class="btn-action" title="Print"><i class="fa fa-print"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>STU-2024-087</strong></td>
                                    <td>Mary Wanjiku</td>
                                    <td>Form 3B</td>
                                    <td><strong>38,500</strong></td>
                                    <td>Oct 04, 2025</td>
                                    <td><span class="badge-status badge-paid">Paid</span></td>
                                    <td>
                                        <button class="btn-action" title="View"><i class="fa fa-eye"></i></button>
                                        <button class="btn-action" title="Print"><i class="fa fa-print"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>STU-2024-143</strong></td>
                                    <td>Peter Omondi</td>
                                    <td>Form 2C</td>
                                    <td><strong>32,000</strong></td>
                                    <td>Oct 03, 2025</td>
                                    <td><span class="badge-status badge-pending">Pending</span></td>
                                    <td>
                                        <button class="btn-action" title="View"><i class="fa fa-eye"></i></button>
                                        <button class="btn-action" title="Print"><i class="fa fa-print"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>STU-2024-256</strong></td>
                                    <td>Grace Akinyi</td>
                                    <td>Form 1A</td>
                                    <td><strong>28,000</strong></td>
                                    <td>Oct 02, 2025</td>
                                    <td><span class="badge-status badge-paid">Paid</span></td>
                                    <td>
                                        <button class="btn-action" title="View"><i class="fa fa-eye"></i></button>
                                        <button class="btn-action" title="Print"><i class="fa fa-print"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>STU-2024-189</strong></td>
                                    <td>David Mwangi</td>
                                    <td>Form 4B</td>
                                    <td><strong>45,000</strong></td>
                                    <td>Oct 01, 2025</td>
                                    <td><span class="badge-status badge-overdue">Overdue</span></td>
                                    <td>
                                        <button class="btn-action" title="View"><i class="fa fa-eye"></i></button>
                                        <button class="btn-action" title="Print"><i class="fa fa-print"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>STU-2024-312</strong></td>
                                    <td>Sarah Njeri</td>
                                    <td>Form 3A</td>
                                    <td><strong>38,500</strong></td>
                                    <td>Sep 30, 2025</td>
                                    <td><span class="badge-status badge-paid">Paid</span></td>
                                    <td>
                                        <button class="btn-action" title="View"><i class="fa fa-eye"></i></button>
                                        <button class="btn-action" title="Print"><i class="fa fa-print"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="quick-actions-card">
                    <h5><i class="fa fa-bolt me-2"></i> Quick Actions</h5>
                    <button class="btn-quick-action btn-quick-primary">
                        <i class="fa fa-plus-circle"></i> Record New Payment
                    </button>
                    <button class="btn-quick-action btn-quick-success">
                        <i class="fa fa-file-invoice"></i> Generate Invoice
                    </button>
                    <button class="btn-quick-action btn-quick-warning">
                        <i class="fa fa-user-plus"></i> Add Student
                    </button>
                    <button class="btn-quick-action btn-quick-purple">
                        <i class="fa fa-download"></i> Export Report
                    </button>
                </div>

                <!-- Notifications -->
                <div class="notifications-card">
                    <h5><i class="fa fa-bell me-2"></i> Recent Notifications</h5>
                    
                    <div class="notification-item">
                        <div class="notification-icon warning">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <div class="notification-content">
                            <h6>Payment Overdue Alert</h6>
                            <p>23 students have overdue fee payments for Term 1</p>
                            <small><i class="fa fa-clock"></i> 2 hours ago</small>
                        </div>
                    </div>

                    <div class="notification-item">
                        <div class="notification-icon success">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <div class="notification-content">
                            <h6>Bulk Payment Received</h6>
                            <p>Form 4A class fees received - KES 850,000</p>
                            <small><i class="fa fa-clock"></i> 5 hours ago</small>
                        </div>
                    </div>

                    <div class="notification-item">
                        <div class="notification-icon info">
                            <i class="fa fa-info-circle"></i>
                        </div>
                        <div class="notification-content">
                            <h6>Fee Structure Updated</h6>
                            <p>New fee schedule approved for Term 2, 2025</p>
                            <small><i class="fa fa-clock"></i> 1 day ago</small>
                        </div>
                    </div>

                    <div class="notification-item">
                        <div class="notification-icon warning">
                            <i class="fa fa-bell"></i>
                        </div>
                        <div class="notification-content">
                            <h6>Reminder: End of Month</h6>
                            <p>Monthly financial report due in 3 days</p>
                            <small><i class="fa fa-clock"></i> 1 day ago</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Fees vs Collections Pie Chart
        const feesCtx = document.getElementById('feesPieChart').getContext('2d');
        new Chart(feesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Collected', 'Outstanding'],
                datasets: [{
                    data: [1875500, 574500],
                    backgroundColor: ['#79c347', '#ff4748'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                family: 'Poppins',
                                size: 13
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += new Intl.NumberFormat('en-KE', {
                                    style: 'currency',
                                    currency: 'KES'
                                }).format(context.parsed);
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Expenses Breakdown Pie Chart
        const expensesCtx = document.getElementById('expensesPieChart').getContext('2d');
        new Chart(expensesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Salaries', 'Utilities', 'Maintenance', 'Supplies', 'Transport', 'Others'],
                datasets: [{
                    data: [450000, 125000, 98500, 87000, 78000, 56000],
                    backgroundColor: ['#36a9e2', '#8e68ef', '#fabb3d', '#1ed085', '#ff4748', '#79c347'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                family: 'Poppins',
                                size: 13
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += new Intl.NumberFormat('en-KE', {
                                    style: 'currency',
                                    currency: 'KES'
                                }).format(context.parsed);
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Net Position Line Chart
        const netCtx = document.getElementById('netLineChart').getContext('2d');
        new Chart(netCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Net Position (KES)',
                    data: [850000, 920000, 1050000, 980000, 1150000, 1200000, 1180000, 1250000, 1220000, 1301000, 1280000, 1350000],
                    borderColor: '#36a9e2',
                    backgroundColor: 'rgba(54, 169, 226, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: '#36a9e2',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                family: 'Poppins',
                                size: 13
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += new Intl.NumberFormat('en-KE', {
                                    style: 'currency',
                                    currency: 'KES'
                                }).format(context.parsed.y);
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'KES ' + (value / 1000) + 'K';
                            },
                            font: {
                                family: 'Poppins'
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                family: 'Poppins'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>


<!-- 
<!DOCTYPE html>
<html lang="en">
   <head>
     
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
     
      <title>Pluto - Responsive Bootstrap Admin Panel Templates</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      
      <link rel="icon" href="images/fevicon.png" type="image/png" />
      
      <link rel="stylesheet" href="/css/bootstrap.min.css" />
      
      <link rel="stylesheet" href="/style.css" />
  
      <link rel="stylesheet" href="/css/responsive.css" />
      
      <link rel="stylesheet" href="/css/colors.css" />
      
      <link rel="stylesheet" href="/css/bootstrap-select.css" />
     
      <link rel="stylesheet" href="/css/perfect-scrollbar.css" />
     
      <link rel="stylesheet" href="/css/custom.css" />
      <link rel="stylesheet" href="/css/customallan.css" />
      <link rel="stylesheet" href="/css/dashboard.css">


   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

   </head> -->