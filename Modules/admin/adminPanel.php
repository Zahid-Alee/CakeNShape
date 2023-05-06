<!-- Navigation Bar -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="/assets/css/admin.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>

    strong {

      color: black;
    }
    .page-heading {

      padding: 10px 0px;
      font-size: 20px;
      font-weight: 700;
      color: #320a0a;
    }

    .main-container {

      display: flex;
    }

    .link-container {
      height: 70%;
      overflow-y: scroll;
    }

    a:hover {
      color: rgb(186, 184, 184);
    }

    table {
      background-color: #fff;
      border: 1px solid #ddd;
      font-family: 'Open Sans', sans-serif;
      font-size: 14px;
      color: black !important;
    }
    .table td, th{
      text-align: center;
      font-size: 13px;
      font-weight: 500;
    }

    .table .thead-dark th {
      color: #fff;
      background-color: #212529;
      /* border-color: #32383e; */
      font-size: 14px;
      font-weight: 500;
    }

    .table-icon {
      margin-right: 5px;
    }

    .table-icon i {
      color: #dc3545;
    }

    tbody tr:nth-of-type(odd) {
      background-color: #f8f9fa;
    }

    .action-icons {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .action-icons a {
      margin-right: 5px;
    }

    #preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: #fff;
      z-index: 9999;
    }

    #loader {
      display: block;
      position: absolute;
      top: 50%;
      left: 50%;
      width: 80px;
      height: 80px;
      margin: -40px 0 0 -40px;
      border: 10px solid #3498db;
      border-top-color: #fff;
      border-radius: 100%;
      animation: spin 2s ease-in-out infinite;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }
  </style>
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
      <span style="color:#c41818; font-size:15px"><?php echo $_SESSION['username'] ?>
        <a href="logout.php"> </i> <i class='bx bx-log-out'></i></a>
      </span>
    </div>
    <div class='dashboard-content px-2'>
      <?php
      $link = isset($_GET['link']) ? $_GET['link'] : 'dashboard';
      if ($link == 'dashboard') {
        require_once 'dashboard.php';
      } elseif ($link == 'cakeStock') {
        require_once 'cakeStock.php';
      } elseif ($link == 'donationRequest') {
        require_once 'donationRequest.php';
      } elseif ($link == 'cakeInsertionForm') {
        require_once 'cakeInsertionForm.php';
      } elseif ($link == 'bloodRequest') {
        require_once 'bloodRequest.php';
      }

      ?>
    </div>
    <div id="preloader">
      <div id="loader"></div>
    </div>

  </section>
  <script>
    window.addEventListener('load', function() {
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