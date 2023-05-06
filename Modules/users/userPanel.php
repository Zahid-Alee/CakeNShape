<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        :root {
            --primary-color: #d32f2f;
            --text-color: #333;
        }

        #changing-bg {

            position: absolute;
            background: url('./Modules/users/images/Blood3.jpg');
            z-index: -1;
            height: 645px;
            width: 100%;
            top: 0;
            left: 0;
            opacity: 50%;
            transition: all 1.3s;
        }

        .container h1 {
            margin-bottom: 1.5rem !important;
            color: #251717ba;
            font-weight: 700;
            font-family: math;
        }


        p.sub-title {
            font-size: 16px;
            color: #a93636;
            font-weight: 700;
            font-family: monospace;
        }

        /* Add box shadow and hover effects */
        .card {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            transform: translateY(0);
        }

        .card:hover {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        /* Style the title and icons */
        .card-title {
            font-weight: bold;
            color: var(--primary-color);
        }

        .card-text {
            color: var(--text-color);
        }

        .card-text i {
            color: var(--primary-color);
            margin-right: 5px;
        }

        /* Style the button */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #b71c1c;
            border-color: #b71c1c;
        }

        .small-card {
            border: 1px solid lightgrey;
            /* box-shadow: 0 0 15px rgba(0, 0, 0, 0.3); */
            padding: 30px 15px;
            margin-bottom: 30px;
            transition: all 0.3s ease-in-out;
            height: 100%;
        }

        .small-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.3);
            cursor: pointer;
        }

        .small-card .animated-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80px;
            width: 80px;
            border-radius: 50%;
            background-color: #d32f2f;
            margin: 0 auto 20px;
            transition: all 0.3s ease-in-out;
        }

        .small-card .animated-icon:hover {
            transform: rotate(360deg);
        }

        .small-card .animated-icon span {
            color: #fff;
        }

        .small-card .card-title {
            font-weight: 700;
            margin-bottom: 15px;
        }

        .small-card .card-text {
            font-size: 16px;
            line-height: 1.5;
        }

        .custom-map-container {
            height: 400px;
            width: 100%;
        }

        /* The modal (background) */
        .popup {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: scroll;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .popup-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            height: 80%;
            display: flex;
            flex-direction: column;
            max-width: 600px;
        }

        .popup-header {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close-donation,
        .close-request {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-donation:hover,
        .close-request:hover .close-donation:focus,
        .close-request:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;

        }

        .popup-body {
            padding: 10px 0;
            overflow-y: scroll;
        }

        .popup-footer {
            padding: 10px 0;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }

        @media (max-width: 767px) {
            .modal-dialog {
                margin: 0;
                width: 100%;
            }
        }

        @media (min-width: 768px) {
            .modal-dialog {
                margin: 30px auto;
                max-width: 600px;
            }
        }
    </style>
</head>

<body>

    <div id="changing-bg">
    </div>
    <section id='main-section' class=" py-5">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6 text-center">
                    <h1 class="display-4 mb-4">Blood Management System</h1>
                    <p class="sub-title">Be a Lifesaver Donate Blood Today, <br>
                        Your Donation Can Save Lives ,<br>
                        One Pint of Blood Can Save Three Lives Donate Today</p>
                    <div class="d-flex justify-content-around my-5">
                        <div class="card col-sm-4 mx-2">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-tint"></i> Collected</h5>
                                <p class="card-text">10,000+ Bags</p>
                            </div>
                        </div>
                        <div class="card col-sm-4 mx-2">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-hand-holding-heart"></i> Monthly Donations</h5>
                                <p class="card-text">$5,000+</p>
                            </div>
                        </div>
                        <div class="card col-sm-4 mx-2">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-heartbeat"></i> Lives Saved</h5>
                                <p class="card-text">2,500+</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button id='openModalBtn' class="donate-now-btn btn btn-danger btn-lg mr-3" data-toggle="modal" data-target="#exampleModalLong">
                            <i class="fas fa-heart"></i> Donate Now
                        </button>
                        <button href="#" class="btn btn-danger btn-lg mr-3">
                            <i class="fas fa-info-circle"></i> Learn More
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php echo require_once('./Modules/users/services.php') ?>

    <div id="donation-popup" class="popup">
        <div class="popup-content">
            <div class="popup-header">
                <h2>Donate Blood Form</h2>
                <span class="close-donation">&times;</span>
            </div>
            <div class="popup-body">
                <?php echo require_once('./components/donationForm.php') ?>
            </div>

        </div>
    </div>
    <div id="request-popup" class="popup">
        <div class="popup-content">
            <div class="popup-header">
                <h2>Request Blood From </h2>
                <span class="close-request">&times;</span>
            </div>
            <div class="popup-body">
                <?php echo require_once('./Modules/users/requestForm.php') ?>

            </div>

        </div>
    </div>
    <!-- <div class="custom-map-container">
        <iframe class="custom-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3454.177705176766!2d72.31188797547888!3d30.031759274930085!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x393c95446603cf47%3A0xa4c7c9803430aee0!2sCOMSATS%20University%20Islamabad%2C%20Vehari%20Campus!5e0!3m2!1sen!2s!4v1681643596890!5m2!1sen!2s" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div> -->


    <?php

    use DataSource\DataSource;

    require_once __DIR__ . '../../../lib/DataSource.php';

    $con = new DataSource;
    $query = 'SELECT * from   blood_donation where request_status="approved" ';
    $paramType = 's';
    $paramArray = array();
    $bloodPosts = $con->select($query, $paramType, $paramArray);

    if (!empty($bloodPosts)) {

        echo '<div class="container-fluid">';
        echo '<h2 class="heading">Blood Donations</h2>';
        echo '<div class="row">';

        foreach ($bloodPosts as $Post) {

            echo '<div class="col-md-4 col-lg-3 mb-4">';
            echo '<div class="card h-100">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title"><i class="fas fa-user"></i> ' . $Post['donor_name'] . '</h5>';
            echo '<p class="card-text"><i class="fas fa-calendar-alt"></i> ' . $Post['age'] . '</p>';
            echo '<p class="card-text"><i class="fas fa-map-marker-alt"></i> ' . $Post['location'] . '</p>';
            echo '<p class="card-text"><i class="fas fa-tint"></i> ' . $Post['blood_group'] . '</p>';
            echo '<p class="card-text"><i class="fas fa-tint"></i> ' . $Post['quantity'] . '(ml)</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
        echo '<a href="#" class="btn btn-primary request-blood-btn">Request Blood</a>';

        echo '</div>';
    } else {
        echo "<strong>No requests</strong>";
    }
    ?>

<div class="container">
        <h2><i class="fas fa-envelope-open-text text-danger"></i> Contact Us</h2>
        <form action="#" method="post">
            <div class="form-group">
                <label for="name"><i class="fas fa-user text-danger"></i> Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope text-danger"></i> Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone"><i class="fas fa-phone text-danger"></i> Phone:</label>
                <input type="tel" class="form-control" id="phone" placeholder="Enter phone number" name="phone" required>
            </div>
            <div class="form-group">
                <label for="message"><i class="fas fa-comment-dots text-danger"></i> Message:</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Submit</button>
        </form>
    </div>
<!-- Footer -->
<!-- Footer -->
<footer class="text-center text-lg-start bg-white text-muted">
  <!-- Section: Social media -->
  <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
    <!-- Left -->
    <div class="me-5 d-none d-lg-block">
      <span>Get connected with us on social networks:</span>
    </div>
    <!-- Left -->

    <!-- Right -->
    <div>
    <a
        class="btn text-white btn-floating m-1"
        style="background-color: #3b5998;"
        href="#!"
        role="button"
        ><i class="fab fa-facebook-f"></i
      ></a>

      <!-- Twitter -->
      <a
        class="btn text-white btn-floating m-1"
        style="background-color: #55acee;"
        href="#!"
        role="button"
        ><i class="fab fa-twitter"></i
      ></a>

      <!-- Google -->
      <a
        class="btn text-white btn-floating m-1"
        style="background-color: #dd4b39;"
        href="#!"
        role="button"
        ><i class="fab fa-google"></i
      ></a>

      <!-- Instagram -->
      <a
        class="btn text-white btn-floating m-1"
        style="background-color: #ac2bac;"
        href="#!"
        role="button"
        ><i class="fab fa-instagram"></i
      ></a>

      <!-- Linkedin -->
      <a
        class="btn text-white btn-floating m-1"
        style="background-color: #0082ca;"
        href="#!"
        role="button"
        ><i class="fab fa-linkedin-in"></i
      ></a>
      <!-- Github -->
      <a
        class="btn text-white btn-floating m-1"
        style="background-color: #333333;"
        href="#!"
        role="button"
        ><i class="fab fa-github"></i
      ></a>
    </div>
    <!-- Right -->
  </section>
  <!-- Section: Social media -->

  <!-- Section: Links  -->
  <section class="">
    <div class="container text-center text-md-start mt-5">
      <!-- Grid row -->
      <div class="row mt-3">
        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <!-- Content -->
          <h6 class="text-uppercase fw-bold mb-4">
            <i class="fas fa-gem me-3 text-secondary"></i>Company name
          </h6>
          <p>
            Here you can use rows and columns to organize your footer content. Lorem ipsum
            dolor sit amet, consectetur adipisicing elit.
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Products
          </h6>
          <p>
            <a href="#!" class="text-reset">Angular</a>
          </p>
          <p>
            <a href="#!" class="text-reset">React</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Vue</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Laravel</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Useful links
          </h6>
          <p>
            <a href="#!" class="text-reset">Pricing</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Settings</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Orders</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Help</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
          <p><i class="fas fa-home me-3 text-secondary"></i> New York, NY 10012, US</p>
          <p>
            <i class="fas fa-envelope me-3 text-secondary"></i>
            info@example.com
          </p>
          <p><i class="fas fa-phone me-3 text-secondary"></i> + 01 234 567 88</p>
          <p><i class="fas fa-print me-3 text-secondary"></i> + 01 234 567 89</p>
        </div>
        <!-- Grid column -->
      </div>
      <!-- Grid row -->
    </div>
  </section>
  <!-- Section: Links  -->

  <!-- Copyright -->
  <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.025);">
    © 2021 Copyright:
    <a class="text-reset fw-bold" href="https://mdbootstrap.com/">MDBootstrap.com</a>
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->
<!-- Footer -->

</body>
<script>
    const changingBack = document.getElementById('changing-bg');
    const donationBtn = document.getElementById("openModalBtn");
    const requestBtn = document.querySelectorAll('.request-blood-btn')
    const donationPopUp = document.getElementById("donation-popup");
    const requestPopup = document.getElementById("request-popup")
    const closeDonBtn = document.querySelector(".close-donation");
    const closeReqBtn = document.querySelector(".close-request")


    // let bg_images = [
    //     './Modules/users/images/Blood2.jpg',
    //     './Modules/users/images/bg-3.jpg',
    //     './Modules/users/images/Blood3.jpg',
    //     './Modules/users/images/Blood4.jpg',
    //     './Modules/users/images/Blood5.jpg'

    // ]

    // let count = 0;
    // setInterval(() => {
    //     if (count < 5) {

    //         changingBack.style.background = `url(${bg_images[count]}) center center/cover`;

    //     } else {

    //         count = 0;
    //     }
    //     count++;

    // }, 4000);

    donationBtn.onclick = function() {
        donationPopUp.style.display = "block";
    }
    closeDonBtn.onclick = function() {
        donationPopUp.style.display = "none";
    }
    requestBtn.forEach((reqBtn => {
        reqBtn.addEventListener('click', () => {
            requestPopup.style.display = 'block'
        })
    }))
    closeReqBtn.onclick = function() {
        requestPopup.style.display = "none";
    }
</script>

</html>