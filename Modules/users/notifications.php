<div class="container mt-5">
  <h1>Notification Box</h1>

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

        <div class="alert <?php echo $notificationTypeClass; ?> notification-box">
          <div class="d-flex justify-content-<?php echo $notFrom === 'admin' ? 'start' : 'end'; ?>">
            <div class="notification-message">
              <h5 class="notification-title">
                <i class="<?php echo $notificationTitleIcon; ?> chat-icon"></i>Notification From
                <?php echo ucfirst($notFrom); ?> 
               <span class="dissmiss-btn" onclick="delNotification(<?php echo $notification['notID'] ?>)">&times;</span> 
              </h5>
              <p>
                <?php echo $message; ?>
              </p>
              <div class="order-details">
                <p>Order Details:</p>
                <p><i class="fas fa-id-badge"></i> Order ID:
                  <?php echo $orderID; ?>
                </p>
                <p><i class="fas fa-box"></i> Products:
                  <?php
                  foreach ($orderItems as $orderItem) {
                    $productName = $orderItem['CakeName'];
                    echo $productName . ", ";
                  }
                  ?>
                </p>
                <p><i class="far fa-calendar-alt"></i> Order Date:
                  <?php echo $orderDate; ?>
                </p>
                <p><i class="far fa-calendar-check"></i> Delivery Date:
                  <?php echo $deliveryDate; ?>
                </p>
                <p><i class="fas fa-credit-card"></i> Payment Method:
                  <?php echo $paymentMethod; ?>
                </p>
                <p><i class="fas fa-info-circle"></i> Order Status:
                  <?php echo $orderStatus; ?>
                </p>
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
const delNotification=(notID)=>{

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


<style>
  .notification-box {
    margin-bottom: 15px;
  }

  .alert-success {
    background-color: #D7F9D7;
    padding: 20px;
    color: #155724;
    border-color: #C3E6CB;
    width: fit-content;
  }

  .alert-danger {
    background-color: #F9D7D7;
    color: #721C24;
    border-color: #F5C6CB;
    width: fit-content;
    padding: 20px;

  }

  .notification-message {
    padding: 10px;
    border-radius: 10px;
    display: inline-block;
    margin-bottom: 5px;
  }

  .notification-title {
    color: #dc3545;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
  }

  .chat-icon {
    font-size: 20px;
    margin-right: 5px;
  }

  .order-details {
    font-weight: bold;
    margin-bottom: 5px;
  }

  .order-details p {
    margin: 0;
  }

  .notification-box.admin-notification .notification-message {
    background-color: #D7F9D7;
    text-align: left;
  }

  .notification-box.user-notification .notification-message {
    background-color: #F9D7D7;
    text-align: right;
  }
</style>