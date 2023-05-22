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
<table class="table table-striped table-bordered">
    <h3 class="page-heading">Cake Inventory</h3>
    <thead class="thead-dark">
        <tr>
            <th scope="col" class='text-center'><i class="fas fa-sort-numeric-up"></i> Cake Name</th>
            <th scope="col" class='text-center'><i class="fas fa-image"></i> Image</th>
            <th scope="col" class='text-center'><i class="fas fa-tint"></i> Weight</th>
            <th scope="col" class='text-center'><i class="fas fa-tint"></i> Category</th>
            <th scope="col" class='text-center'><i class="fas fa-tint"></i> Quantity</th>
            <th scope="col" class='text-center'><i class="fas fa-dollar-sign"></i> Price</th>
            <th scope="col" class='text-center'><i class="fas fa-cog"></i> Action</th>
        </tr>
    </thead>
    <tbody>
        <?php

        use DataSource\DataSource;

        require_once __DIR__ . '../../../lib/DataSource.php';

        $con = new DataSource;
        $query = 'SELECT CakeID, CakeName, CategoryName, cakes.CategoryID, MaterialUsed, Flavor, Weight, Price, Image, Quantity from cakes inner join categories on categories.CategoryID =cakes.CategoryID ';
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
                    <td class='text-center'><img src="data:image/jpeg;base64,<?php echo base64_encode($cake['Image']); ?>"
                            height="75" width="75" /></td>
                    <td class='text-center'>
                        <?php echo $cake['Weight']; ?> lbs
                    </td>
                    <td class='text-center'>
                        <?php echo $cake['CategoryName']; ?>
                    </td>
                    <td class='text-center'>
                        <?php echo $cake['Quantity']; ?>
                    </td>
                    <td class='text-center'>$
                        <?php echo $cake['Price']; ?>
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
            echo "<strong>No cakes found</strong>";
        }
        ?>
    </tbody>
</table>
<script>
    // let method, result;
    // var successAlert = document.getElementById('success-alert');
    // var errorAlert = document.getElementById('error-alert');

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
            })
            .catch(error => {
                console.error('Error:', error);
            });
    };

</script>