<section class="categories">
  <h2 class='section-title'> Categories </h2>
  <div class="category-container">

    <?php
    use DataSource\DataSource;

    require_once __DIR__ . '../../../lib/DataSource.php';

    $con = new DataSource;
    // Retrieve the cake details based on the CakeID
    $query = 'SELECT * from categories';
    $categories = $con->select($query);

    if (!empty($categories)) {
      foreach ($categories as $category) {

        ?>

        <div class="category">
          <span class="tag"> <i class="bx bx-category"></i> </span>
          <div class="img">
            <img src="<?php echo substr($category['Image'], 3) ?>" alt="" />
          </div>
          <div class="details">
            <?php
            $query = 'Select * from cakes where cakes.CategoryID = ?';
            $queryParam = 's';
            $queryValue = array($category['CategoryID']);
            $count = $con->select($query, $queryParam, $queryValue);
            $totalCakes = !empty($count) ? count($count) : 0;
            ?>
            <div class="items">
              Total Cakes :
              <?php echo $totalCakes ?>
            </div>
            <div class="name">
              <h3>
                <?php echo $category['CategoryName'] ?>
              </h3>

            </div>

            <button class="btn btn-success" onclick="showPopup('<?php echo $category['CategoryID'] ?>')">
              Shop By Category
            </button>
          </div>
        </div>
        <?php
      }
    } else {
      echo "<strong>No cakes found</strong>";
    }

    ?>
    <div id="popup" class="pop popup">
      <div style="width:90%; max-width:95%;" class="popup-content">
        <div class="popup-header">
          <h2 style='font-family:Lobster'>Category Products</h2>
          <span class="close-btn" onclick="closeP()">&times;</span>
        </div>
        <div class="popup-body">
          <div id="item-container">
            <?php
            require_once __DIR__ . '../../../lib/DataSource.php';

            $con = new DataSource;
            $categoryID = $_GET['categoryID']; // Retrieve the category ID from the URL
            
            // Fetch products based on the category ID
            $query = 'SELECT CakeID, CakeName, cakes.discount, CategoryName, cakes.CategoryID, MaterialUsed, Flavor, Weight, Price, cakes.Image, Quantity FROM cakes INNER JOIN categories ON categories.CategoryID = cakes.CategoryID WHERE categories.CategoryID = ?';
            $queryParam = 's';
            $queryValue = array($categoryID);
            $cakes = $con->select($query, $queryParam, $queryValue);

            if (!empty($cakes)) {
              foreach ($cakes as $cake) {
                ?>

                <div class="card">
                  <img class="card-img" src="<?php echo substr($cake['Image'], 3) ?>" alt="Chocolate Cake" />
                  <div class="card-title">
                    <?php echo $cake['CakeName'] ?>
                  </div>
                  <div class="card-category"><i class="bx bx-category"></i>
                    <?php echo $cake['CategoryName'] ?>
                  </div>
                  <div class="card-price"><Strong>Rs: </Strong>
                    <?php echo $cake['Price'] ?>
                  </div>
                  <div class="card-discount"><i class="fa fa-tag"></i>
                    <?php echo 'Rs. ' . $cake['discount'] ?> off
                  </div>

                  <?php if ($isLogin) { ?>
                    <button class="add-to-cart"
                      onClick="addCart('<?php echo $cake['CakeID'] ?>', '<?php echo $cake['CakeName'] ?>', '<?php echo $cake['Price'] ?>','<?php echo $_SESSION['userID'] ?>')">Add
                      to Cart</button>
                  <?php } else { ?>
                    <button class="add-to-cart" onClick="location.href='login.php'">Login to Add to Cart</button>
                  <?php } ?>
                </div>

                <?php
              }
            } else {
              echo "<strong>No cakes</strong>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>

  </div>

  </div>
</section>

<script>
  // JavaScript code

  const pop = document.getElementById('popup');

  const showPopup = (categoryID) => {
    localStorage.setItem('categoryPopupOpen', 'true');
    window.location.href = window.location.pathname + '?categoryID=' + categoryID;
    pop.style.display = 'block';
  };

  const closeP = () => {
    localStorage.removeItem('categoryPopupOpen');
    pop.style.display = 'none';
  };

  // Check if the popup was open before the page was reloaded
  window.addEventListener('DOMContentLoaded', () => {
    const isPopupOpen = localStorage.getItem('categoryPopupOpen');
    if (isPopupOpen) {
      pop.style.display = 'block';
    }
  });

  const addToCart = (CakeID, CakeName, Price, userID) => {
    console.log(Price, CakeName, CakeID);
    let data = {
      cakeID: CakeID,
      cakeName: CakeName,
      userID: userID,
      price: Price,
      method: 'add'
    };

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
  };
    // Rest of your code...
</script>