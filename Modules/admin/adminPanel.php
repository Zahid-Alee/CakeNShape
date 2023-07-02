<!-- Navigation Bar -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="Modules/admin/sidebar.css">
  <link rel="stylesheet" href="Modules/admin/admin.css">
  <!-- CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <!-- JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  <div class="container-fluid">

  </div>
  <div class="sidebar close">
    <?php require_once 'sidebar.php'; ?>
  </div>
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' style="color:#c41818; font-size:35px"></i>
      <span style="color:#c41818; font-size:15px">
        <?php echo $_SESSION['username'] ?>
        <a href="logout.php"> </i> <i class='bx bx-log-out'></i></a>
      </span>
    </div>
    <div class='dashboard-content px-2' style="width: 100%; height:100%">
      <?php
      $link = isset($_GET['link']) ? $_GET['link'] : 'dashboard';
      if ($link == 'dashboard') {
        include 'dashboard.php';
      } elseif ($link == 'cakeStock') {
        include 'cakeStock.php';
      } elseif ($link == 'donationRequest') {
        include 'donationRequest.php';
      } elseif ($link == 'cakeInsertionForm') {
        include 'cakeInsertionForm.php';
      } elseif ($link == 'bloodRequest') {
        include 'bloodRequest.php';
      } elseif ($link == 'orders') {
        include 'checkOrders.php';
      } elseif ($link == 'sales-data') {
        include 'checkSales.php';
      } elseif ($link == 'categories') {
        include 'categories.php';
      }

      ?>
    </div>
    <div id="preloader">
      <div id="loader"></div>
    </div>

  </section>
  <script>
    window.addEventListener('load', function () {
      var preloader = document.getElementById('preloader');
      preloader.style.display = 'none';
    });

    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
      arrow[i].addEventListener("click", (e) => {
        let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
        arrowParent.classList.toggle("showMenu");
      });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", () => {
      sidebar.classList.toggle("close");
    });
  </script>


</body>

</html>