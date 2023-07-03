<style>
    strong {

        font-weight: 500;
    }

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

    .close-btn {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-btn:hover,
    .close-btn:focus {
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


<!-- <div class="alerts-notifications">
    <div id="success-alert" class="alert alert-success alert-dismissible fade show d-none" role="alert">
        Success message here
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div id="error-alert" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
        Not Enough Blood For This Blood Type
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

</div> -->
<div class="container">
    <table class="table table-striped table-bordered">
        <h3 class="page-heading">Cake Inventory</h3>
        <thead class="thead-dark">
            <tr>
                <th scope="col" class='text-center'> Cake Name</th>
                <th scope="col" class='text-center'> Image</th>
                <th scope="col" class='text-center'> Weight</th>
                <th scope="col" class='text-center'> Category</th>
                <th scope="col" class='text-center'> Quantity</th>
                <th scope="col" class='text-center'> Price </th>
                <th scope="col" class='text-center'> Action</th>
            </tr>
        </thead>
        <tbody>
            <?php

            use DataSource\DataSource;

            require_once __DIR__ . '../../../lib/DataSource.php';

            $con = new DataSource;
            $query = 'SELECT CakeID, CakeName, CategoryName, cakes.CategoryID, MaterialUsed, Flavor, Weight, Price, cakes.Image, Quantity from cakes inner join categories on categories.CategoryID =cakes.CategoryID ';
            $paramType = '';
            $paramArray = array();
            $cakes = $con->select($query, $paramType, $paramArray);

            if (!empty($cakes)) {
                foreach ($cakes as $cake) {
                    ?>
                    <tr>
                        <td scope="row" class='text-center'>
                            <?php echo $cake['CakeName']; ?>
                        </td>
                        <td class='text-center'><img src="<?php echo substr($cake['Image'], 3) ?>" height="75" width="75" /></td>
                        <td class='text-center'>
                            <?php echo $cake['Weight']; ?> lbs
                        </td>
                        <td class='text-center'>
                            <?php echo $cake['CategoryName']; ?>
                        </td>
                        <td class='text-center'>
                            <?php echo $cake['Quantity']; ?>
                        </td>
                        <td class='text-center'>
                            Rs. <?php echo $cake['Price']; ?>
                        </td>
                        <td class='text-center'>
                            <a class="table-icon text-info px-2"
                                href="Modules/admin/updateCake.php?CakeID=<?php echo $cake['CakeID']; ?>"><i
                                    class="fas fa-edit"></i></a>

                            <span class="table-icon text-danger px-2"
                                onclick="deleteCake('<?php echo $cake['CakeID']; ?>','delete')"><i class="fas fa-times"></i></span>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "";
            }
            ?>

        <tfoot>
            <tr>
                <td colspan="7" class="text-center">
                    <button class="btn btn-success" onclick='openPopup()'>Add Cake</button>
                </td>
            </tr>
        </tfoot>
        </tbody>
        <div class="popup">
            <div class="popup-content">
                <div class="popup-header">
                    <h2 style='font-family:Lobster'>Insert Cakes (Admin side) </h2>
                    <span class="close-btn" onclick="closePopup()">&times;</span>
                </div>
                <div class="popup-body">
                    <div class="card-body">
                        <form id="cakeInsertionForm" method="post" enctype="multipart/form-data">
                            <input type="text" name="CakeID" value="<?php echo uniqid('cake-') ?>" hidden>

                            <div class="form-group">
                                <label for="CakeName"><i class="bx bx-cake"></i> <strong>Cake Name</strong></label>
                                <input type="text" class="form-control" name="CakeName" placeholder="Enter cake name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="MaterialUsed"><strong>Material Used</strong> </label>
                                <input type="text" class="form-control" name="MaterialUsed"
                                    placeholder="Enter material used" required>
                            </div>

                            <div class="form-group">
                                <label for="CategoryID"><i class="bx bx-category-alt"></i><strong>Category</strong> </label>
                                <select class="form-control" name="CategoryID" required>
                                    <option value="" disabled selected>Select Category</option>
                                    <?php
                                    $query = 'SELECT * FROM Categories';
                                    $categories = $con->select($query);
                                    if (!empty($categories)) {
                                        foreach ($categories as $cat) {
                                            ?>
                                            <option value="<?php echo $cat['CategoryID']; ?>"><?php echo $cat['CategoryName']; ?></option>
                                            <?php
                                        }
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="Weight"> <strong>Weight (grams) </strong></label>
                                <input type="number" class="form-control" name="Weight"
                                    placeholder="Enter cake weight in grams" required>
                            </div>
                            <div class="form-group">
                                <label for="Flavor"> <strong>Flavor</strong></label>
                                <input type="text" class="form-control" name="Flavor" placeholder="Enter cake flavor"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="Price"><strong>Rs. Price</strong></label>
                                <input type="number" class="form-control" name="Price" placeholder="Enter cake price"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="Quantity"><strong>Quantity</strong> </label>
                                <input type="number" class="form-control" name="Quantity" placeholder="Enter cake price"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="Discount"> <strong>Discount</strong></label>
                                <input type="number" class="form-control" name="Discount" placeholder="Enter cake price"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="Image"> <strong>Image</strong> </label>
                                <input type="file" class="form-control" name="Image" required>
                            </div>

                            <button type="submit" id="submit-btn" class="btn btn-danger closeModalBtn2 "><i
                                    class="fas fa-paper-plane"></i> Submit</button>
                        </form>

                    </div>


                </div>

            </div>
        </div>
    </table>
</div>



<script>


    const form = document.getElementById('cakeInsertionForm');
    form.addEventListener('submit', submitForm);
    const popup = document.querySelector('.popup');
    const closePopup = () => {
        popup.style.display = 'none';

    }
    const openPopup = () => {

        popup.style.display = 'block';
    }

    const deleteCake = async (cakeID, method) => {
        let data = new URLSearchParams();
        data.append('CakeID', cakeID);
        data.append('method', method);

        fetch('http://localhost/CakeNShape/Model/handleCakeStock.php', {
            method: 'POST',
            body: data
        })
            .then(response => response.text())
            .then(data => {
                console.log('Success:', data);
                // location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    };
    function checkValidations(form) {
        const cakeName = form.CakeName.value.trim();
        const materialUsed = form.MaterialUsed.value.trim();
        const weight = parseFloat(form.Weight.value);
        const price = parseFloat(form.Price.value);
        const discount = parseFloat(form.Discount.value);
        const alphabeticRegex = /^[A-Za-z]+[A-Za-z\s]*\d*$/;


        if (cakeName === '' || !alphabeticRegex.test(cakeName)) {
            alert('Invalid Cakename');
            return false;
        }

        if (materialUsed === '') {
            alert('Material used cannot be empty');
            return false;
        }

        if (isNaN(weight) || weight <= 0 || weight > 5000) {
            alert('Weight should be a number between 0 and 5000 grams');
            return false;
        }

        if (isNaN(price) || price <= 0) {
            alert('Price should be a number greater than 0');
            return false;
        }

        if (isNaN(discount) || discount < 0 || discount > price) {
            alert('Discount should be a number between 0 and the price of the cake');
            return false;
        }

        return true;
    }


    function submitForm(event) {
        event.preventDefault();

        const form = event.target;
        const formValues = new FormData(form);

        if (checkValidations(form)) {

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


    }

</script>