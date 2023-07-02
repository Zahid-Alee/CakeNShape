<?php
$isLogin ?
    $userID = $_SESSION['userID'] : $userID = null;
?>
<footer>
    <div class="main-content">
        <div class="left box">
            <h2>About us</h2>
            <div class="content">
                <p>Cake N Shape Offers you a variety of delecious cakes and good customer service, Other than that you
                    can order custom cakes of your choice Which makes your event Special.
                </p>
                <div class="social">
                    <a href="https://facebook.com/coding.np"><span class="fab fa-facebook-f"></span></a>
                    <a href="#"><span class="fab fa-twitter"></span></a>
                    <a href="https://instagram.com/coding.np"><span class="fab fa-instagram"></span></a>
                    <a href="https://youtube.com/c/codingnepal"><span class="fab fa-youtube"></span></a>
                </div>
            </div>
        </div>

        <div class="center box">
            <h2>Address</h2>
            <div class="content text-start" style="text-align:left;">
                <div class="place" style="text-align:left;">
                    <span class="fas fa-map-marker-alt"></span>
                    <span class="text text-start">Vehari, University Town</span>
                </div>
                <div class="phone text-start" style="text-align:left;">
                    <span class="fas fa-phone-alt"></span>
                    <span class="text">+089-765432100</span>
                </div>
                <div class="email text-start" style="text-align:left;">
                    <span class="fas fa-envelope"></span>
                    <span class="text">CakeNShape@example.com</span>
                </div>
            </div>
        </div>

        <div class="right box">
            <h2>Submit Feedback</h2>
            <div class="content">
                <form id="feedback">
                    <div class="email">
                        <div class="text">Name *</div>
                        <input type="text" name="name" required></input>
                    </div>

                    <div class="email">
                        <div class="text">Email *</div>
                        <input type="email" name="email" required></input>
                    </div>
                    <div class="msg">
                        <div class="text">Message *</div>
                        <textarea rows="2" cols="25" name="message" required></textarea>
                    </div>

                    <div class="btn">
                        <button type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="bottom">
        <center>
            <span class="credit">Created By <a href="mailto:zahid177617@gmail.com"> Cake N Shape</a> | </span>
            <span class="far fa-copyright"></span><span> 2023 All rights reserved.</span>
        </center>
    </div>
</footer>

<script>

    const feedbackForm = document.getElementById('feedback');
    feedbackForm.addEventListener('submit', submitForm);

    function submitForm(event) {
        event.preventDefault();
        const formValues = new FormData(event.target);
        console.log(formValues);
        fetch('Model/handleFeedback.php', {
            method: 'POST',
            body: formValues
        })
            .then(response => response.text())
            .then(data => {
                console.log('Success:', data);
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

</script>