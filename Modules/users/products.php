<section class="products">
  <h3>Products</h3>
  <div id="item-container">
    <?php
    use DataSource\DataSource;

    require_once __DIR__ . '../../../lib/DataSource.php';

    $con = new DataSource;
    // Retrieve the cake details based on the CakeID
    $query = 'SELECT CakeID, CakeName, CategoryName, cakes.CategoryID, MaterialUsed, Flavor, Weight, Price, cakes.Image, Quantity FROM cakes INNER JOIN categories ON categories.CategoryID = cakes.CategoryID ';

    $cakes = $con->select($query);

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
          <div class="card-price"><i class="bx bx-dollar"></i>
            <?php echo $cake['Price'] ?>
          </div>
          <div class="card-discount"><i class="fa fa-tag"></i> 10% off</div>
          <button class="add-to-cart"
            onClick="addToCart('<?php echo $cake['CakeID'] ?>', '<?php echo $cake['CakeName'] ?>', '<?php echo $cake['Price'] ?>','<?php echo $_SESSION['userID'] ?>')">Add
            to Cart</button>


        </div>
        <?php
      }
    } else {
      echo "<strong>No cake found</strong>";
    }

    ?>


  </div>

  </div>
</section>
<script>
  // JavaScript code

  const addToCart = (CakeID, CakeName, Price, userID) => {
    openCart();
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