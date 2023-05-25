
<style>
    .notification-box {
      margin-bottom: 15px;
      overflow: hidden;
    }

    .user-notification {
      text-align: right;
    }

    .admin-notification {
      text-align: left;
    }

    .notification-message {
      background-color: #f2f2f2;
      padding: 10px;
      border-radius: 10px;
      display: inline-block;
      margin-bottom: 5px;
    }

    .user-notification .notification-message {
      background-color: #F9D7D7;
    }

    .admin-notification .notification-message {
      background-color: #D7F9D7;
    }

    .notification-title {
      color: #dc3545;
      font-weight: bold;
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

    .order-details span {
      font-weight: normal;
    }
  </style>

  <div class="container mt-5">
    <h1>Notification Box</h1>

    <div class="notification-box user-notification">
      <div class="d-flex justify-content-end">
        <div class="notification-message">
          <h5 class="notification-title"><i class="fas fa-user chat-icon"></i> User Notification</h5>
          <p>Your order has been placed.</p>
          <div class="order-details">
            <p>Order Details:</p>
            <p><i class="fas fa-id-badge"></i> Order ID: 12345</p>
            <p><i class="fas fa-box"></i> Products: Product 1, Product 2</p>
            <p><i class="far fa-calendar-alt"></i> Order Date: May 25, 2023</p>
            <p><i class="far fa-calendar-check"></i> Delivery Date: May 30, 2023</p>
          </div>
        </div>
      </div>
    </div>

    <div class="notification-box admin-notification">
      <div class="d-flex justify-content-start">
        <div class="notification-message">
          <h5 class="notification-title"><i class="fas fa-user-shield chat-icon"></i> Admin Notification</h5>
          <p>Your order has been accepted.</p>
          <div class="order-details">
            <p>Order Details:</p>
            <p><i class="fas fa-id-badge"></i> Order ID: 12345</p>
            <p><i class="fas fa-box"></i> Products: Product 1, Product 2</p>
            <p><i class="far fa-calendar-alt"></i> Order Date: May 25, 2023</p>
            <p><i class="far fa-calendar-check"></i> Delivery Date: May 30, 2023</p>
          </div>
        </div>
      </div>
    </div>
    <!-- Add more notification boxes as needed -->
  </div>
