<section class="categories">
  <h2 class='section-title'>Shop by Category</h2>
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
          </div>
        </div>
        <?php
      }
    } else {
      echo "<strong>No cakes found</strong>";
    }

    ?>
    <!-- <h3>Birtday Cake</h3> -->

  </div>
</section>

<script>
  // JavaScript code

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