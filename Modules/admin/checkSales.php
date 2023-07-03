<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1 class='text-dark'>Dashboard</h1>
    <canvas id="myChart" style="max-width: 500px; height: 90%; margin: auto;"></canvas>
    <table id="salesTable" class="table table-bordered">
        <thead>
            <tr>
                <th scope="col" class='text-center'>Category</th>
                <th scope="col" class='text-center'>Total Quantity</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

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
                    updateChart(data);
                    updateTable(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching sales data:', error);
                }
            });
        }

        function updateChart(data) {
            const labels = [];
            const quantities = [];

            if (data && data.length > 0) {
                data.forEach(function(record) {
                    labels.push(record.Category);
                    quantities.push(record.TotalQuantity);
                });
            }

            var ctx = document.getElementById("myChart").getContext('2d');
            var myChart = new Chart(ctx, {
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
                    scales: {
                        y: {
                            beginAtZero: true
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
                    var row = "<tr>" +
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
