

<div class="card-body">
    <form id="cakeInsertionForm" method="post" enctype="multipart/form-data">
        <input type="text" name="CakeID" value="<?php echo uniqid('cake-') ?>" hidden>

        <div class="form-group">
            <label for="CakeName"> Cake Name</label>
            <input type="text" class="form-control" name="CakeName" placeholder="Enter cake name" required>
        </div>
        <div class="form-group">
            <label for="MaterialUsed"> Material Used</label>
            <input type="text" class="form-control" name="MaterialUsed" placeholder="Enter material used" required>
        </div>

        <div class="form-group">
            <label for="CategoryID"> Category</label>
            <select class="form-control" name="CategoryID" required>
                <option value="" disabled selected>Select Category</option>

                <?php

                use DataSource\DataSource;

                require_once __DIR__ . '/../../lib/DataSource.php';
                $con = new DataSource;
                $query = 'SELECT * FROM Categories';
                $categories = $con->select($query);
                if (!empty($categories)) {
                    foreach ($categories as $cat) {
                        ?>
                        <option value="<?php echo $cat['CategoryID']; ?>"><?php echo $cat['CategoryName']; ?></option>
                        <?php
                    }
                } else {
                    echo "<strong>No Categories found!</strong>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="Weight"> Weight</label>
            <input type="number" class="form-control" name="Weight" required placeholder="Enter cake weight in grams">
        </div>
        <div class="form-group">
            <label for="Flavor"> Flavor</label>
            <input type="text" class="form-control" name="Flavor" placeholder="Enter cake flavor" required>
        </div>
        <div class="form-group">
            <label for="Price"> Price</label>
            <input type="number" class="form-control" name="Price" placeholder="Enter cake price" required>
        </div>
        <div class="form-group">
            <label for="Quantity"> Quantity</label>
            <input type="number" class="form-control" name="Quantity" placeholder="Enter cake price" required>
        </div>
        <div class="form-group">
            <label for="Discount"> Discount</label>
            <input type="number" class="form-control" name="Discount" placeholder="Enter cake price" required>
        </div>
        <div class="form-group">
            <label for="Image"> Image</label>
            <input type="file" class="form-control" name="Image" required>
        </div>

        <button type="submit" id="submit-btn" class="btn btn-danger closeModalBtn2 "><i class="fas fa-paper-plane"></i>
            Submit</button>
    </form>

</div>

<script>


const successAlert = document.getElementById('success-alert');
    // const errorAlert = document.getElementById('error-alert');

    // const createNotification = (message, callback) => {
    //     const alertElement = successAlert;
    //     alertElement.innerHTML = message;
    //     alertElement.classList.remove('d-none');
    //     const intervalId = setTimeout(() => {
    //         alertElement.classList.add('d-none');
    //         clearTimeout(intervalId);
    //         if (callback) {
    //             // callback();
    //             location.reload()
    //         }
    //     }, 2000);
    // };
    const form = document.getElementById('cakeInsertionForm');
    form.addEventListener('submit', submitForm);

    function submitForm(event) {
        event.preventDefault();
        const formValues = new FormData(event.target);
        console.log(formValues)
        fetch('http://localhost/CakeNShape/Model/insertCake.php', {
            method: 'POST',
            body: formValues
        })
            .then(response => response.text())
            .then(data => {
                console.log('Success:', data);
                location.reload();

            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }
</script>