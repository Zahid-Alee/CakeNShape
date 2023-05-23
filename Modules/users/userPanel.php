<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Modules/users/user.css">
    <title>Document</title>
</head>

<body>
    <div class="header-bg">
        <img src="assets/img/Headerback.png" class="w-100 block" alt="Header Image" />
    </div>
    <?php  include('./Modules/users/navbar.php') ?>
    <?php  include('./Modules/users/services.php') ?>
    <?php  include('./Modules/users/categories.php') ?>
    <?php  include('./Modules/users/products.php') ?>
    <?php  include('./Modules/users/footer.php') ?>

</body>
<script>
    const changingBack = document.getElementById('changing-bg');
    const donationBtn = document.getElementById("openModalBtn");
    const requestBtn = document.querySelectorAll('.request-blood-btn')
    const donationPopUp = document.getElementById("donation-popup");
    const requestPopup = document.getElementById("request-popup")
    const closeDonBtn = document.querySelector(".close-donation");
    const closeReqBtn = document.querySelector(".close-request")

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