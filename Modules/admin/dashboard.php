<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .chart-container {
            width: 100%;
            height: 400px;
            margin-bottom: 20px;
        }
        .dashboard-heading {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .dashboard-description {
            margin-bottom: 20px;
            font-size: 14px;
            color: #777;
        }
        .sales-data-table {
            margin-bottom: 20px;
        }
        .sales-data-table th {
            font-weight: bold;
            background-color: #f4f4f4;
            color: #333;
        }
        .sales-data-table td {
            font-weight: bold;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class='text-dark'>Dashboard</h1>
        <div class="dashboard-heading">Sales Data</div>
        <div class="dashboard-description">
            This dashboard provides an overview of sales data.
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
        <div class="sales-data-table table-responsive">
            <table id="salesTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class='text-center'>Category</th>
                        <th scope="col" class='text-center'>Total Quantity</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            loadSalesData();
        });

        function loadSalesData() {
            $.ajax({
                url: 'Model/salesData.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    updateBarChart(data);
                    updatePieChart(data);
                    updateTable(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching sales data:', error);
                }
            });
        }

        function updateBarChart(data) {
            const labels = [];
            const quantities = [];

            if (data && data.length > 0) {
                data.forEach(function(record) {
                    labels.push(record.Category);
                    quantities.push(record.TotalQuantity);
                });
            }

            var ctx = document.getElementById("barChart").getContext('2d');
            var barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Quantity',
                        data: quantities,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        function updatePieChart(data) {
            const labels = [];
            const quantities = [];

            if (data && data.length > 0) {
                data.forEach(function(record) {
                    labels.push(record.Category);
                    quantities.push(record.TotalQuantity);
                });
            }

            var ctx = document.getElementById("pieChart").getContext('2d');
            var pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: quantities,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });
        }

        function updateTable(data) {
            var salesTable = $("#salesTable tbody");
            salesTable.empty();

            if (data && data.length > 0) {
                data.forEach(function(record) {
                    var row =
                        "<tr>" +
                        "<td class='text-center'>" + record.Category + "</td>" +
                        "<td class='text-center'>" + record.TotalQuantity + "</td>" +
                        "</tr>";

                    salesTable.append(row);
                });
            } else {
                var row = "<tr><td colspan='2' class='text-center'>No sales data found</td></tr>";
                salesTable.append(row);
            }
        }
    </script>
</body>
</html>
