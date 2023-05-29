<section class="reviews">
  <h2>Customer Reviews</h2>
  <div class="reviews-container">

    <?php
    use DataSource\DataSource;

    require_once __DIR__ . '../../../lib/DataSource.php';

    $con = new DataSource;
    // Retrieve the cake details based on the CakeID
    $query = 'SELECT feedback.userID,FeedbackText,FeedbackDate,username from feedback inner join users on feedback.userID=users.userID';

    $reviews = $con->select($query);

    if (!empty($reviews)) {
      foreach ($reviews as $review) {

        ?>


        <div class="review">
          <div class="user">
            <div class="user-image">
              <img src="https://cdn.pixabay.com/photo/2014/04/03/11/47/avatar-312160_640.png" alt="User 2" />

            </div>
            <div class="user-info">
              <p class="name">
                <?php echo $review['username'] ?>
              </p>
              <p class="date">
                <i class="far fa-calendar-alt"></i>
                <?php echo $review['FeedbackDate'] ?>
              </p>
            </div>
          </div>
          <!-- <div class="rating">
            <div class="stars">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="far fa-star"></i>
            </div>
            <p class="score">4/5</p>
          </div> -->
          <p class="message">
            <?php echo $review['FeedbackText'] ?>
          </p>
        </div>





        <?php
      }
    } else {
      echo "<strong>No Reviews Yet</strong>";
    }

    ?>

  </div>

</section>