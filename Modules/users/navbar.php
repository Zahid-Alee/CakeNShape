<?php
use DataSource\DataSource;

session_start();
$userID = $_SESSION['userID'];
$totalBill = 0;
$totalDiscount = 0;

require_once __DIR__ . '../../../lib/DataSource.php';

$con = new DataSource;
// Retrieve the cake details based on the CakeID
$queryForCat = 'SELECT * FROM categories ';
$categories = $con->select($queryForCat);

$queryForCart = 'SELECT * FROM cart where userID=? ';
$queryParam = 's';
$queryValue = array($userID);
$cartItems = $con->select($queryForCart, $queryParam, $queryValue);
if (!empty($cartItems)) {
  $cartCount = count($cartItems);
} else {
  $cartCount = 0;
}
?>

<header>
  <nav class="nav-bar">
    <ul class="navigation">
      <li class="nav-items"><i class="fas fa-home"></i> Home</li>
      <li class="nav-items dropdown">
        <i class="bx bx-category"></i>
        <a href="#">Categories</a>
        <ul class="dropdown-menu d-none" onclick="toggleCat()">
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
            echo "<strong>No cake found</strong>";
          }
          ?>

        </ul>
      </li>
      <li class="nav-items">
        <i class="bx bx-cake"></i>
        Custom Design
      </li>
      <li class="nav-items">
        <i class="bx bx-party"></i> See Out Creations
      </li>
      <li class="nav-items">
        <i class="bx bx-user"></i>
        Who We Are
      </li>
      <a class="nav-items" href="logout.php">
        <i class="bx bx-logout"></i>
        <?php echo $userID ?>
      </a>
      <li id="cart-icon">
        <span <i class="fas fa-shopping-cart"></i></span>
        <span id="cart-count" class="cart-count">
          <?php echo $cartCount ?>
        </span>
      </li>
    </ul>
  </nav>
</header>
<div id="cart-container" class="clearfix p-0 ">
  <!-- Shopping cart table -->
  <div class="card">
    <div class="card-header">
      <h2 class="d-flex">Shopping Cart
        <span class="dismiss-btn" onclick="closeCart()"> &times;</span>
      </h2>
    </div>
    <div class="card-body ">
      <div class="table-responsive">
        <table class="table table-bordered m-0">
          <thead>
            <tr>
              <!-- Set columns width -->
              <th class="text-center py-3 px-4" style="min-width: 400px;">Product Name &amp; Details</th>
              <th class="text-right py-3 px-4" style="width: 100px;">Price</th>
              <th class="text-center py-3 px-4" style="width: 120px;">Quantity</th>
              <th class="text-right py-3 px-4" style="width: 100px;">Total</th>
              <th class="text-center align-middle py-3 px-0" style="width: 40px;"><a href="#"
                  class="shop-tooltip float-none text-light" title="" data-original-title="Clear cart"><i
                    class="ino ion-md-trash"></i></a></th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!empty(($cartItems))) {
              foreach ($cartItems as $item) {
                $totalBill = $totalBill + $item['total'];
                $totalDiscount = $totalDiscount + $item['discount'];
                ?>
                <tr>
                  <td class="p-4">
                    <div class="media align-items-center">
                      <!-- <img src="https://bootdey.com/img/Content/avatar/avatar2.png"
                    class="product-img d-block ui-w-40 ui-bordered mr-4" alt=""> -->
                      <div class="media-body">
                        <a href="#" class="d-block text-dark">
                          <?php echo $item['CakeName'] ?>
                        </a>
                      </div>
                    </div>
                  </td>
                  <td class="text-right font-weight-semibold align-middle p-4">
                    <?php echo $item['price'] ?>
                  </td>
                  <td class="align-middle p-4"><input type="text" class="form-control text-center"
                      value="<?php echo $item['quantity'] ?>"></td>
                  <td class="text-right font-weight-semibold align-middle p-4">
                    <?php echo $item['total'] ?>
                  </td>
                  <td class="text-center align-middle px-0"><span onclick="delteCartItem(<?php echo $item
                  ['cartID'] ?>)" class="shop-tooltip close float-none text-danger" title=""
                      data-original-title="Remove">&times;</span></td>
                </tr>

                <?php
              } ?>
              <div>
                <td class="d-flex">
                  <div class="">
                    <label class="text-muted font-weight-normal m-0"> Discount:</label>
                    <div class="text-large"><strong class="px-5">
                        <?php echo $totalDiscount ?>

                      </strong></div>
                  </div>
                  <div class="">
                    <label class="text-muted font-weight-normal m-0">
                      Total Bill:
                    </label>
                    <div class="text-large"><strong>
                        <?php echo $totalBill ?>

                      </strong></div>
                  </div>
                </td>
              </div>
            </tbody>
          </table>

        </div>
        <!-- / Shopping cart table -->

        <div class="float-right">
          <button type="button" class="btn btn-lg btn-default md-btn-flat mt-2 mr-3" onclick='closeCart()'>Back to
            shopping</button>
          <button type="button" class="btn btn-lg btn-primary mt-2" onclick="Checkout()">Checkout</button>
        </div>
        <?php
            }
            ?>
    </div>
  </div>
</div>

<style>
  /* ********Utitlities*********** */

  #cart-icon {
    position: relative;
  }

  .cart-count {
    position: absolute;
    text-align: center;
    height: 20px;
    width: 20px;
    top: -8px;
    right: -8px;
    background-color: red;
    color: white;
    border-radius: 50%;
    /* padding: 4px; */
    font-size: 12px;
    font-weight: bold;
  }

  .disable-scroll {
    overflow: hidden;
  }

  #cart-container {
    position: absolute;
    /* width: auto; */
    /* top: 0; */
    right: 100%;
    z-index: 1;
    height: 100vh !important;
    width: 100vw;
    display: flex;
    flex-flow: column;
    background: rgba(0, 0, 0, 0.15);
    transition: all .3s;

  }

  #cart-container .card {
    box-shadow: 0 1px 15px 1px rgba(52, 40, 104, .08);
    height: 100vh;
    width: 70vw;
    position: relative;
    left: ;
    align-content: flex-end;
  }

  .card-header h2 {
    justify-content: space-between;
  }

  .dismiss-btn {
    color: darkred;
    cursor: pointer;
  }

  .dismiss-btn:hover {
    color: black;
  }

  .card:hover {
    box-shadow: none;
    transform: none;
  }

  .card-body {
    overflow: scroll;
  }

  .product-img {
    width: 80px;
    height: auto;
    border-radius: 50%;
  }

  .ui-product-color {
    display: inline-block;
    overflow: hidden;
    margin: .144em;
    width: .875rem;
    height: .875rem;
    border-radius: 10rem;
    -webkit-box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.15) inset;
    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.15) inset;
    vertical-align: middle;
  }
</style>

<script>
  const cartContainer = document.getElementById('cart-container');
  const body = document.body;

  function openCart() {
    cartContainer.style.right = '0';
    body.classList.add('disable-scroll');
  }

  function closeCart() {
    console.log('close cart')
    cartContainer.style.right = '100%';
    body.classList.remove('disable-scroll');
  }

  // Example event listener for opening the cart
  const cartIcon = document.getElementById('cart-icon');
  cartIcon.addEventListener('click', openCart);

  const toggleCat = () => {

    const element = document.querySelector('.dropdown')
    console.log(element)
  }

  const delteCartItem = (cartID) => {

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
        openCart();
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

// const closeCartBtn=document.getElementById('close-cart')
// cartIcon.addEventListener('click', ());

</script>