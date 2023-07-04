<?php

use DataSource\DataSource;

$totalBill = 0;
$totalDiscount = 0;
$checkCart = false;
$checkNotifications = false;
$loggedInUserID = null;

if ($isLogin) {
  session_start();
  $loggedInUserID = $_SESSION['userID'];
} else {
}

require_once __DIR__ . '../../../lib/DataSource.php';

$con = new DataSource;
// Retrieve the cake details based on the CakeID
$queryForCat = 'SELECT * FROM categories ';
$categories = $con->select($queryForCat);

$queryForCart = 'SELECT * FROM cart    where userID=? ';
$queryParam = 's';
$queryValue = array($loggedInUserID);

$query = "SELECT * FROM user_notifications WHERE userID = ?";
$paramType = "i";
$paramValue = array($loggedInUserID);
$notifications = $con->select($query, $paramType, $paramValue);

if (!empty($notifications)) {
  $notCount = count($notifications);
} else {
  $notCount = 0;
}

$cartItems = $con->select($queryForCart, $queryParam, $queryValue);
if (!empty($cartItems)) {
  $cartCount = count($cartItems);
} else {
  $cartCount = 0;
}
?>

<header>
  <div class="header-bg">
    <img src="Modules/users/images/headerBg.png" alt="">
  </div>
  <nav style='z-index:1000;' class="navbar navbar-expand-lg navbar-light  py-2 px-4">
    <a class="navbar-brand" href="#"><i class="bx bx-home"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto" style="background-color:#F6E6E7; z-index:1000;">
        <li class="nav-items dropdown" onclick='toggleCat()'>
          <a class="" href="#">
            <i class="bx bx-category"></i>
            Categories</a>
          <ul class="dropdown-menu d-none"">
          <?php

          if (!empty($categories)) {
            foreach ($categories as $cat) {

              ?>
              <li>
                <?php echo $cat['CategoryName'] ?>
              </li>
              
          <?php
            }
          } else {
            echo "<center class='text-center'>No categories</center>";
          }
          ?>
       <li class=" cat-overlay" onclick='closeCart()'>
        </li>
      </ul>
      </li>
      <?php if ($isLogin) { ?>
        <li class="nav-item">
          <a class="nav-link" href="#" onclick='openPopup()'>
            <i class="bx bx-cake"></i> Custom Cakes
          </a>
        </li>
      <?php } else { ?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">
            <i class="bx bx-cake"></i> Custom Cakes
          </a>
        </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link" href="Modules/users/ourCreations.php">
          <i class="bx bx-party"></i> See Our Creations
        </a>
      </li>
      <?php if ($isLogin) { ?>
        <li class="nav-item">
          <a class="nav-link" href="Modules/users/notifications.php">
            <i class="bx bx-chat px-1"></i> Notifications
            <sup class="text-danger">
              <strong style="font-size: large;">
                <?php echo $notCount ?>
              </strong>
            </sup>
          </a>
        </li>
      <?php } else { ?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">
            <i class="fas fa-bell px-1"></i> Notifications
            <sup class="text-danger">
              <strong style="font-size: large;">
                <?php echo $notCount ?>
              </strong>
            </sup>
          </a>
        </li>
      <?php } ?>
      <?php if ($isLogin) { ?>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">
            <i class="bx bx-log-out"></i>
            <?php echo $username ?>
          </a>
        </li>
      <?php } else { ?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">
            <i class="bx bx-log-in"></i> Login
          </a>
        </li>
      <?php } ?>
      <li class="nav-item" id='cart-icon'>
        <a class="nav-link" href="#">
          <i class="bx bx-cart text-lg"></i>
          <sup class="text-danger">
            <strong style="font-size: large;">
              <?php echo $cartCount ?>
            </strong>
          </sup>
        </a>
      </li>
      </ul>
    </div>
  </nav>
  <div id="cart-container" class="clearfix p-0">
    <!-- Shopping cart table -->
    <div class="card">
      <div class="card-header">
        <h2 class="d-flex">Cake Cart
          <span class="dismiss-btn" onclick="closeCart()">&times;</span>
        </h2>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered m-0">
            <thead>
              <tr>
                <!-- Set columns width -->
                <th class="text-center py-3" style="min-width: 400px;">Product Name &amp; Details</th>
                <th class="text-right py-3" style="width: 100px;">Price</th>
                <th class="text-center py-3" style="width: 120px;">Quantity</th>
                <th class="text-right py-3" style="width: 100px;">Total</th>
                <th class="text-center align-middle py-3" style="width: 40px;">
                  <a href="#" class="shop-tooltip float-none text-light" title="" data-original-title="Clear cart">
                    <i class="ion ion-md-trash"></i>
                  </a>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $totalBillCustom = 0; // Total bill for custom cake orders
              $totalBillShop = 0; // Total bill for orders by shop
              
              if (!empty($cartItems)) {
                foreach ($cartItems as $item) {
                  $total = $item['total'];
                  $discount = $item['discount'];
                  $userID = $item['userID'];

                  if ($item['orderType'] === 'custom') {
                    $totalBillCustom += $total - $discount;
                  } else {
                    $totalBillShop += $total - $discount;
                  }
                  ?>
                  <tr>
                    <td class="p-3">
                      <div class="media align-items-center">
                        <img src="<?php echo substr($item['Image'], 3) ?>"
                          class="product-img d-block ui-w-40 ui-bordered mr-3" alt="">
                        <div class="media-body">
                          <a href="#" class="d-block text-dark">
                            <?php echo $item['CakeName']; ?>
                          </a>
                        </div>
                      </div>
                    </td>
                    <td class="text-right font-weight-semibold align-middle p-3">
                      <?php echo $item['price']; ?>
                    </td>
                    <td class="align-middle p-3">
                      <input type="text" class="form-control text-center" value="<?php echo $item['quantity']; ?>">
                    </td>
                    <td class="text-right font-weight-semibold align-middle p-3">
                      <?php echo $item['total']; ?>
                    </td>
                    <td class="text-center align-middle p-0">
                      <span onclick="delteCartItem(<?php echo $item['cartID']; ?>)"
                        class="shop-tooltip close float-none text-danger" title=""
                        data-original-title="Remove">&times;</span>
                    </td>
                  </tr>
                  <?php
                }
              }
              ?>
            </tbody>
          </table>
        </div>
        <!-- / Shopping cart table -->
        <?php if (!empty($cartItems)) {
          $checkCart = true;
          ?>
          <div class="d-flex justify-content-between">
            <div class="">
              <label class="text-muted font-weight-normal m-0">Discount:</label>
              <div class="text-large">
                <strong class="px-3">
                  <?php echo $totalDiscount; ?>
                </strong>
              </div>
            </div>
            <div class="">
              <label class="text-muted font-weight-normal m-0">Total Bill:</label>
              <div class="text-large">
                <strong>
                  <?php echo $totalBillCustom + $totalBillShop; ?>
                </strong>
              </div>
            </div>
          </div>
        <?php } ?>
        <div class="float-right mt-3">
          <button type="button" class="btn btn-success mr-3 back-to-shopping-btn" onclick="closeCart()">
            Back to shopping
          </button>
          <?php if ($checkCart) {
            echo '<button type="button" class="btn btn-primary" onclick="Checkout(' . $userID . ')">Checkout</button>';
          } ?>
        </div>
      </div>
    </div>
  </div>




  <div class="popup">
    <div class="popup-content">
      <div class="popup-header">
        <h2 style="font-family:'Lobster';"> Order Custom Cake </h2>
        <span class="close-btn" style="cursor:pointer; font-size:20px;" onclick="closePopup()">&times;</span>
      </div>
      <div class="popup-body" style="overflow-y:hidden">
        <div class="card-body">
          <form id="cakeInsertionForm" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="Weight"><i class="fas fa-weight"></i> Weight (pounds) </label>
              <input type="number" class="form-control" name="Weight" min="1" max="4"
                placeholder="Enter cake weight in pounds">
            </div>
            <div class="form-group">
              <label for="Quantity"><i class="fas fa-circle"></i> Quantity </label>
              <input type="number" min="1" max="3" class="form-control" name="Quantity" placeholder='Upload Cake Image'>
            </div>
            <div class="form-group">
              <label for="description"><i class="bx bx-message"></i> Description</label>
              <textarea class="form-control" name="Description" max="4" placeholder="Enter Cake Description" rows="5"
                pattern="^(?!^[0-9])(?!.*\d$)[A-Za-z]+$" required></textarea>
            </div>

            <div class="form-group">
              <label for="Image"><i class="fas fa-file"></i> Image </label>
              <input type="file" class="form-control" name="Image" placeholder='Upload Cake Image'>
            </div>

            <button type="submit" id="submit-btn" class="btn btn-danger closeModalBtn2 "><i
                class="fas fa-paper-plane"></i> Submit</button>
          </form>

        </div>


      </div>

    </div>
  </div>
</header>

<!-- *************************Shopppig Cart**************************** -->

<style>
  i {
    font-weight: bold;
    font-size: 20px;
    vertical-align: middle;
    text-align: center;
  }
</style>


<script>
  const cartContainer = document.getElementById('cart-container');
  const body = document.body;
  const popup = document.querySelector('.popup');

  const closePopup = () => {
    popup.style.display = 'none';

  }
  const openPopup = () => {

    popup.style.display = 'block';
  }
  // Check if the page has been reloaded
  if (performance.navigation.type === 1) {
    const isCartOpen = localStorage.getItem('isCartOpen');
    if (isCartOpen === 'true') {
      openCart();
    } else {
      closeCart(); // Add this line to ensure the cart is closed by default on page load
    }
  }

  function openCart() {
    cartContainer.style.left = '0%';
    body.classList.add('disable-scroll');
    localStorage.setItem('isCartOpen', 'true');
  }

  function closeCart() {
    cartContainer.style.left = '-100%';
    body.classList.remove('disable-scroll');
    localStorage.setItem('isCartOpen', 'false');
  }

  // Example event listener for opening the cart
  const cartIcon = document.getElementById('cart-icon');
  cartIcon.addEventListener('click', openCart);

  // Example event listener for closing the cart
  const dismissBtn = document.querySelector('.dismiss-btn');
  dismissBtn.addEventListener('click', closeCart);

  // Example event listener for "Back to shopping" button
  const backToShoppingBtn = document.querySelector('.back-to-shopping-btn');
  backToShoppingBtn.addEventListener('click', closeCart);

  // Set initial cart state on page load
  window.addEventListener('DOMContentLoaded', () => {
    const cartContainer = document.getElementById('cart-container');
    const isCartOpen = localStorage.getItem('isCartOpen');
    if (isCartOpen === 'true') {
      cartContainer.style.left = '0%';
      body.classList.add('disable-scroll');
    } else {
      cartContainer.style.left = '-100%';
      body.classList.remove('disable-scroll');
    }
  });

  const toggleCat = () => {

    const element = document.querySelector('.dropdown-menu');
    element.classList.toggle('d-none');
  }

  const delteCartItem = async (cartID) => {

    let data = {
      cartID: cartID,
      method: 'remove'
    }

    fetch('Model/handleCart.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
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

  const Checkout = async (userID) => {

    let data = {
      userID: userID,
      method: 'checkout',
      paymentMethod: 'jazzcash'
    }

    fetch('Model/handleCart.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
      .then(response => response.text())
      .then(data => {
        console.log('Response:', data);
        location.reload();
        // openCart();
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }


  const form = document.getElementById('cakeInsertionForm');
  form.addEventListener('submit', submitForm);

  function submitForm(event) {
    event.preventDefault();
    const formValues = new FormData(event.target);
    console.log(formValues)
    fetch('http://localhost/CakeNShape/Model/customCake.php', {
      method: 'POST',
      body: formValues
    })
      .then(response => response.text())
      .then(data => {
        console.log('Success:', data);
        // location.reload();

      })
      .catch((error) => {
        console.error('Error:', error);
      });
  }
</script>