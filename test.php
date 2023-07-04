<?php
$feedbacks = array(
  array(
    'name' => 'John Doe',
    'comment' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at semper tellus.',
    'image' => 'john.jpg'
  ),
  array(
    'name' => 'Jane Smith',
    'comment' => 'Ut cursus, elit sed finibus condimentum, nunc massa tincidunt ex, nec mattis odio lacus sit amet ipsum.',
    'image' => 'jane.jpg'
  ),
  array(
    'name' => 'David Johnson',
    'comment' => 'Nullam sit amet tortor dignissim, fringilla urna non, facilisis ipsum.',
    'image' => 'david.jpg'
  ),
);

$totalFeedbacks = count($feedbacks);
$currentFeedbackIndex = 0;

if (isset($_GET['index'])) {
  $currentFeedbackIndex = $_GET['index'];
}

$prevIndex = ($currentFeedbackIndex == 0) ? $totalFeedbacks - 1 : $currentFeedbackIndex - 1;
$nextIndex = ($currentFeedbackIndex == $totalFeedbacks - 1) ? 0 : $currentFeedbackIndex + 1;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Feedback Carousel</title>
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
  <style>
    /* Add your custom styles here */
    .feedback-container {
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
      text-align: center;
    }
    .feedback-container img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
    }
    .feedback-container h4 {
      margin-top: 10px;
    }
    .feedback-container p {
      margin-top: 20px;
    }
  </style>

  <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="feedback-container">
          <img src="<?php echo $feedbacks[$currentFeedbackIndex]['image']; ?>" alt="Feedback Image">
          <h4><?php echo $feedbacks[$currentFeedbackIndex]['name']; ?></h4>
          <p><?php echo $feedbacks[$currentFeedbackIndex]['comment']; ?></p>
        </div>
        <div class="text-center mt-3">
          <a href="?index=<?php echo $prevIndex; ?>" class="btn btn-primary">Previous</a>
          <a href="?index=<?php echo $nextIndex; ?>" class="btn btn-primary">Next</a>
        </div>
      </div>
    </div>
  </div>
  <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

