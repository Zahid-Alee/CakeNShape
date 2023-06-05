<section class="testimonial text-center">
  <div class="container">

    <div class="heading text-light">
      Customer Reviews
    </div>
    <div id="testimonial4" class="carousel slide text-dark" data-ride="carousel">

      <div class="carousel-inner" role="listbox">

        <?php
        use DataSource\DataSource;

        require_once __DIR__ . '../../../lib/DataSource.php';

        $con = new DataSource;
        // Retrieve the reviews from the feedback table
        $query = 'SELECT feedback.userID,FeedbackText,FeedbackDate,username from feedback inner join users on feedback.userID=users.userID';

        $reviews = $con->select($query);

        if (!empty($reviews)) {
          $active = true;
          foreach ($reviews as $review) {
            $testimonialClass = ($active) ? 'carousel-item active' : 'carousel-item';
            ?>

            <div class="<?php echo $testimonialClass; ?>">
              <div class="testimonial4_slide">
                <img src="https://i.ibb.co/8x9xK4H/team.jpg" class="img-circle img-responsive" />
                <p>
                  <?php echo $review['FeedbackText']; ?>
                </p>
                <h4>
                  <?php echo $review['username']; ?>
                </h4>
              </div>
            </div>

            <?php
            $active = false;
          }
        } else {
          echo "<div class='carousel-item active'>
                  <div class='testimonial4_slide'>
                    <p>No Reviews Yet</p>
                  </div>
                </div>";
        }
        ?>

      </div>
      <a class="carousel-control-prev" href="#testimonial4" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#testimonial4" data-slide="next">
        <span class="carousel-control-next-icon"></span>
      </a>
    </div>
  </div>
</section>