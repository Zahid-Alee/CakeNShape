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

  <script>
 $(document).ready(function () {
  loadSalesData();
});

function loadSalesData() {
  $.ajax({
    url: 'Model/salesData.php', // Update the file path to the correct PHP file
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      updateChart(data);
    },
    error: function (xhr, status, error) {
      console.error('Error fetching sales data:', error);
    }
  });
}

function updateChart(data) {
  const labels = [];
  const quantities = [];

  if (data && data.length > 0) {
    data.forEach(function (record) {
      labels.push(record.CakeName);
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

  </script>
</body>
</html>
