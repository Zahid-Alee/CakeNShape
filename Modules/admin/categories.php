<style>
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

    .close-popup-btn {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-popup-btn:hover,
    .close-popup-btn:focus {
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


<div class="alerts-notifications">
    <div id="success-alert" class="alert alert-success alert-dismissible fade show d-none" role="alert">
        Success message here
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div id="error-alert" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
        Not Enough Blood For This Blood Type
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-heading">Categories</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width:200px" scope="col" class="text-center">Category Name</th>
                            <th style="width:200px" scope="col" class="text-center">Image</th>
                            <th style="width:200px" scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        use DataSource\DataSource;

                        require_once __DIR__ . '../../../lib/DataSource.php';

                        $con = new DataSource;
                        $query = 'SELECT * FROM categories';
                        $categories = $con->select($query);

                        if (!empty($categories)) {
                            foreach ($categories as $category) {
                                ?>
                                <tr>
                                    <td scope="row" class="text-center">
                                        <?php echo $category['CategoryName']; ?>
                                    </td>
                                    <td class="text-center">
                                        <img src="<?php echo substr($category['Image'], 3); ?>" height="75" width="75" />
                                    </td>
                                    <td class="text-center">
                                        <a class="table-icon text-info px-2"
                                            href="Modules/admin/updateCategory.php?CategoryID=<?php echo $category['CategoryID']; ?>"><i
                                                class="fas fa-edit"></i></a>
                                        <span class="table-icon text-danger px-2"
                                            onclick="delCategory('<?php echo $category['CategoryID']; ?>','delete')"><i
                                                class="fas fa-times"></i></span>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "";
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-center b-0">
                                <button class="btn btn-success" onclick="openPopup()">Add Category</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="donation-popup" class="popup">
    <div class="popup-content">
        <div class="popup-header">
            <h2 style="font-family: 'Lobster';">Insert Category</h2>
            <span class="close-popup-btn" onclick="closePopup()">&times;</span>
        </div>
        <div class="popup-body">
            <form id="catInsertionForm" method="post" enctype="multipart/form-data">
                <input type="text" name="method" value="insert" hidden>
                <input type="text" name="CategoryID" value="<?php echo uniqid('cat-'); ?>" hidden>
                <div class="form-group">
                    <label for="CategoryName"><i class="bx bx-category"></i> Category Name</label>
                    <input type="text" class="form-control" name="CategoryName" placeholder="Enter Category Name"
                        required>
                </div>
                <div class="form-group">
                    <label for="Image"><i class="fas fa-file"></i> Image</label>
                    <input type="file" class="form-control" name="Image" required>
                </div>
                <button type="submit" id="submit-btn" class="btn btn-danger"><i class="fas fa-paper-plane"></i>
                    Submit</button>
            </form>
        </div>
    </div>
</div>

<script>

    const form = document.getElementById('catInsertionForm');
    const popup = document.querySelector('.popup');

    form.addEventListener('submit', submitForm);

    const closePopup = () => {
        popup.style.display = 'none';

    }
    const openPopup = () => {

        popup.style.display = 'block';
    }

    function checkValidations(form) {
        const catName = form.CategoryName.value.trim();
        const alphabeticRegex = /^[A-Za-z]+[A-Za-z\s]*\d*$/;

        if (catName === '' || !alphabeticRegex.test(catName)) {
            alert('Invalid category name. Please enter a valid category name starting with an alphabet, containing only alphabets, spaces, and optionally ending with integers.');
            return false;
        }

        return true;
    }





    function submitForm(event) {

        event.preventDefault();

        const form = event.target;
        const formValues = new FormData(form);

        if (checkValidations(form)) {

            fetch('Model/handleCategories.php', {
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


    }


    const delCategory = (id) => {
        let data = {
            id: id,
            method: 'delete'
        }
        fetch('Model/delCategory.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
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