<?php

// use DataSource\user;
require_once __DIR__ . '/middleware/auth.php';
$checkAuth = new authMiddleware\AuthMiddleware;
$username = null;
$role = null;

if (!$checkAuth->checkAuth()) {
  header('Location:login.php');
  exit; // stop executing the rest of the page
} else {
  $username = $_SESSION["username"];
  $role = $_SESSION["role"];
  session_cache_limiter('nocache');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blood Bank Management System</title>
  <!-- <link rel="stylesheet" href="assets/css/admin.css"> -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body>

  <?php
  if ($role === 'user') {

    include('./Modules/users/userPanel.php');
  } elseif ($role === 'admin') {

    include('./Modules/admin/adminPanel.php');
  } else {
    echo 'not  Allowed';
  }
  ?>

</body>

</html>