<?php
$userID = $_SESSION['userID'] ?>
<footer>
    <div class="main-content">
        <div class="left box">
            <h2>About us</h2>
            <div class="content">
                <p>CodinNepal is a YouTube channel where you can learn web designing, web development, ui/ux designing,
                    html css tutorial, hover animation and effects, javascript and jquery tutorial and related so on.
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
            <div class="content">
                <div class="place">
                    <span class="fas fa-map-marker-alt"></span>
                    <span class="text">Birendranagar, Surkhet</span>
                </div>
                <div class="phone">
                    <span class="fas fa-phone-alt"></span>
                    <span class="text">+089-765432100</span>
                </div>
                <div class="email">
                    <span class="fas fa-envelope"></span>
                    <span class="text">abc@example.com</span>
                </div>
            </div>
        </div>

        <div class="right box">
            <h2>Contact us</h2>
            <div class="content">
                <form id="feedbackForm">
                    <input type="text" name="userID" value="<?php echo $userID ?>" hidden>
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
            <span class="credit">Created By <a href="mailto:zahid177617@gmail.com">Zahid Ali</a> | </span>
            <span class="far fa-copyright"></span><span> 2023 All rights reserved.</span>
        </center>
    </div>
</footer>

<script>

    const form = document.getElementById('feedbackForm');
    form.addEventListener('submit', submitForm);

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