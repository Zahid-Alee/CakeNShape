<div class="logo-details container">
  <!-- <i class='bx bxl-c-plus-plus'></i> -->
  <span class="logo_name">Cake N Shape</span>
</div>
<ul class="nav-links">
  <li>
    <a href="?link=dashboard">
      <i class='bx bx-grid-alt'></i>
      <span class="link_name">DashBoard</span>
    </a>
    <ul class="sub-menu blank">
      <li><a class="link_name" href="?link=dashboard">DashBoard</a></li>
    </ul>
  </li>

  <li>
    <a href="?link=categories">
      <i class='bx bx-category-alt'></i>
      <span class="link_name">Categories</span>
    </a>
    <ul class="sub-menu blank">
      <li><a class="link_name" href="?link=categories">Categories</a></li>
    </ul>
  </li>
  <li>
    <a href="?link=cakeStock">
      <i class='bx bx-store'></i>
      <span class="link_name">Check Stock</span>
    </a>
    <ul class="sub-menu blank">
      <li><a class="link_name" href="?link=cakeStock">Check Stock</a></li>
    </ul>
  </li>
  <li>
    <a href="?link=orders">
      <i class='bx bx-cart'></i>
      <span class="link_name">Orders</span>
    </a>
    <ul class="sub-menu blank">
      <li><a class="link_name" href="?link=orders">Orders</a></li>
    </ul>
  </li>
  <!-- <li>
    <a href="?link=sales-data">
    <i class='bx bx-line-chart'></i>
      <span class="link_name">Sales</span>
    </a>
    <ul class="sub-menu blank">
      <li><a class="link_name" href="#">Sales</a></li>
    </ul>
  </li> -->
  <li>
    <div class="profile-details">
      <div class="profile-content">
        <!-- <img src="image/profile.jpg" alt="profile"> -->
        <i class='bx bx-user text-light'></i>
      </div>
      <div class="name-job">
        <div class="profile_name">
          <?php echo $_SESSION['username'] ?>
        </div>
        <div class="job" style="color:#43ffe5">
          <?php echo $_SESSION["role"] ?>
        </div>
      </div>
      <a href="logout.php"><i class='bx bx-log-out text-light'></i></a>
    </div>
  </li>
</ul>