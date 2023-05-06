<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="style.css"> -->
  <style>
    .sidebar {
  background-color: #f5f5f5;
  padding: 20px;
  height: 100vh;
}

.page-content {
  padding: 20px;
}

  </style>

</head>

<body>

  <div class="container-fluid">

    <div class="row">

      <!-- Sidebar -->
      <div class="col-md-2 sidebar">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="#" data-page="dashboard">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-page="users">Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-page="products">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-page="orders">Orders</a>
          </li>
        </ul>
      </div>

      <!-- Page content -->
      <div class="col-md-10 page-content">
        <?php include('dashboard.php'); ?>
      </div>

    </div>

  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="app.js">

    // Listen for clicks on sidebar links
$('.nav-link').on('click', function(e) {
  e.preventDefault();
  var page = $(this).data('page');
  $('.nav-link').removeClass('active');
  $(this).addClass('active');
  $.ajax({
    url: page + '.php',
    success: function(data) {
      $('.page-content').html(data);
    }
  });
});

  </script>
</body>

</html>
