<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="notification.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Document</title>
  <style>
    .order-details {
      display: none;
    }

    .order-details.show {
      display: block;
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <h1 class="p-4 text-center font-weight-bold">Notification Box</h1>

    <?php
    use DataSource\DataSource;

    require_once __DIR__ . '../../../lib/DataSource.php';
    $con = new DataSource;

    session_start();
    $loggedInUserID = $_SESSION['userID']; // Assuming you have the logged-in user's ID stored in the session
    
    $query = "SELECT * FROM user_notifications WHERE userID = ?";
    $paramType = "i";
    $paramValue = array($loggedInUserID);
    $notifications = $con->select($query, $paramType, $paramValue);

    if (!empty($notifications)) {
      foreach ($notifications as $notification) {
        $message = $notification['message'];
        $notFrom = $notification['notFrom'];

        $notificationTypeClass = $notFrom === 'CakeNShape' ? 'alert-success' : 'alert-danger';
        $notificationTitleIcon = $notFrom === 'CakeNShape' ? 'fas fa-user-shield' : 'fas fa-user';

        // Retrieve order details based on OrderID
        $orderID = $notification['OrderID'];
        $orderQuery = "SELECT * FROM Orders WHERE OrderID = ?";
        $orderParamType = 'i';
        $orderParamValue = array($orderID);
        $orderResult = $con->select($orderQuery, $orderParamType, $orderParamValue);

        if (!empty($orderResult)) {
          $order = $orderResult[0];
          $orderDate = $order['OrderDate'];
          $deliveryDate = $order['DeliveryDate'];
          $paymentMethod = $order['PaymentMethod'];
          $orderStatus = $order['OrderStatus'];

          // Retrieve cake details from order_items table
          $orderItemsQuery = "SELECT oi.*, c.* FROM Order_Items oi JOIN Cakes c ON oi.CakeID = c.CakeID WHERE oi.OrderID = ?";
          $orderItemsParamType = 'i';
          $orderItemsParamValue = array($orderID);
          $orderItems = $con->select($orderItemsQuery, $orderItemsParamType, $orderItemsParamValue);

          ?>

          <div class="container my-5">
            <div class="card notification-box">
              <div class="card-header">
                <h5 class="card-title">
                  <span>
                    <i class="<?php echo $notificationTitleIcon; ?> chat-icon pr-3"></i>Notification From
                    <?php echo ucfirst($notFrom); ?>
                  </span>

                  <span class="dissmiss-btn" onclick="delNotification(<?php echo $notification['notID'] ?>)">&times;</span>
                </h5>
              </div>
              <div class="card-body">
                <p class="card-text">
                  <?php echo $message; ?>
                </p>
                <div class="order-details">
                  <p class="order-title">Order Details:</p>
                  <p><i class="fas fa-id-badge"></i><span class="bold"> Order ID:</span>
                    <?php echo $orderID; ?>
                  </p>
                  <p>
                    <?php
                    if ($orderItems) {
                      ?>
                      <i class="fas fa-box"></i> <span class="bold">Products:</span>
                      <?php
                      foreach ($orderItems as $orderItem) {
                        $productName = $orderItem['CakeName'];
                        echo $productName . ", ";
                      }
                    }

                    ?>
                  </p>
                  <p><i class="far fa-calendar-alt"></i><span class="bold"> Order Date:</span>
                    <?php echo $orderDate; ?>
                  </p>
                  <p><i class="far fa-calendar-check"></i> <span class="bold">Delivery Date:</span>
                    <?php echo $deliveryDate; ?>
                  </p>
                  <p><i class="fas fa-credit-card"></i> <span class="bold">Payment Method:</span>
                    <?php echo $paymentMethod; ?>
                  </p>
                  <p><i class="fas fa-info-circle"></i> <span class="bold"> Order Status:</span>
                    <?php echo $orderStatus; ?>
                  </p>
                </div>
                <div class="text-center mt-3 toggle-icon" onclick="toggleOrderDetails(this)">
                  <i class="fa fa-chevron-down toggle-details"></i>
                </div>
              </div>
            </div>
          </div>

          <?php
        } else {
          echo "<strong>No order found for notification</strong>";
        }
      }
    } else {
      echo "<strong>No notifications found</strong>";
    }
    ?>
  </div>

  <script>
    function toggleOrderDetails(icon) {
      var orderDetails = icon.parentElement.parentElement.querySelector('.order-details');
      orderDetails.classList.toggle('show');
    }

    const delNotification = (notID) => {
      fetch('/CakeNShape/Model/handleNotification.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(notID)
      })
        .then(response => response.text())
        .then(data => {
          console.log('Response:', data);
          location.reload();
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }
  </script>
</body>

</html>