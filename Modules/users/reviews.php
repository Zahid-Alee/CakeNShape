<style>
  .section-title {
    background-color: ghostwhite;
    color: black;
  }

  .carousel-control-prev-icon,
  .carousel-control-next-icon {
    background-color: black;
    color: black !important;
    height: 30px;
    width: 30px;
    border-radius: 50%;
    display: block;
  }

  .carousel-control-prev,
  .carousel-control-next {
    color: black;
  }

  .testimonial4_slide p,
  .testimonial4_slide h4 {
    color: black;
  }
</style>

<div class="section-title bg-light text-center py-3">
  <h2 class="font-weight-bold">Reviews</h2>
</div>

<section class="testimonial text-center">
  <div id="testimonial4" class="carousel slide text-dark" data-bs-ride="carousel">
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
        foreach ($reviews as $index => $review) {
          $testimonialClass = ($active) ? 'carousel-item active' : 'carousel-item';
          ?>
          <div class="<?php echo $testimonialClass; ?>">
            <div class="testimonial4_slide">
              <img src="https://i.ibb.co/8x9xK4H/team.jpg" class="rounded-circle img-fluid" alt="User Image">
              <p class="mt-3">
                <?php echo $review['FeedbackText']; ?>
              </p>
              <h4 class="font-weight-bold">
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
    <button class="carousel-control-prev" type="button" data-bs-target="#testimonial4" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#testimonial4" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>