<div class="card-body">
    <form id="cakeInsertionForm" method="post">
        <input type="text" name="CakeID" value="<?php echo uniqid('cake-') ?>" hidden>

        <div class="form-group">
            <label for="CakeName"><i class="fas fa-user"></i> Cake Name</label>
            <input type="text" class="form-control" name="CakeName" placeholder="Enter cake name">
        </div>
        <div class="form-group">
            <label for="MaterialUsed"><i class="fas fa-male"></i> Material Used</label>
            <input type="text" class="form-control" name="MaterialUsed" placeholder="Enter material used">
        </div>

        <div class="form-group">
            <label for="CategoryID"><i class="fas fa-notes-medical"></i> Category</label>
            <select class="form-control" name="CategoryID">
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
            <label for="Weight"><i class="fas fa-male"></i> Weight</label>
            <input type="number" class="form-control" name="Weight" placeholder="Enter cake weight in grams">
        </div>
        <div class="form-group">
            <label for="Flavor"><i class="fas fa-male"></i> Flavor</label>
            <input type="text" class="form-control" name="Flavor" placeholder="Enter cake flavor">
        </div>
        <div class="form-group">
            <label for="Price"><i class="fas fa-price"></i> Price</label>
            <input type="number" class="form-control" name="Price" placeholder="Enter cake price">
        </div>
        <div class="form-group">
            <label for="Image"><i class="fas fa-file"></i> Image</label>
            <input type="file" class="form-control" name="Image">
        </div>

        <button type="submit" id="submit-btn" class="btn btn-danger closeModalBtn2 "><i class="fas fa-paper-plane"></i> Submit</button>
    </form>

</div>

<script>
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

            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }
</script>