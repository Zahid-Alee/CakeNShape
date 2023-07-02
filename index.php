<?php

// use DataSource\user;
require_once __DIR__ . '/middleware/auth.php';
$checkAuth = new authMiddleware\AuthMiddleware;
// $username = 'guest';
$username = '';
// $role = 'guest';

if (!$checkAuth->checkAuth()) {
  // header('Location:login.php');
  $isLogin = false;
  $role = 'guest';

  // exit; // stop executing the rest of the page
} else {
  $username = $_SESSION["username"];
  $role = $_SESSION["role"];
  $userID = $_SESSION["userID"];
  $isLogin = true;
  session_cache_limiter('nocache');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cake N Shape </title>
  <!-- <link rel="stylesheet" href="assets/css/admin.css"> -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <!-- Bootstrap CSS -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"> -->

  <!-- jQuery -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
  </script>

</head>

<body>

  <?php
  if ($role === 'user' || $role === 'guest') {

    include('./Modules/users/userPanel.php');
  } elseif ($role === 'admin') {

    include('./Modules/admin/adminPanel.php');
  } else {
    include('./Modules/users/userPanel.php');
  }
  ?>

</body>

</html>