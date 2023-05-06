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
    
<h3 class="page-heading" >Blood Requests</h3>
    <thead class="thead-dark">
        <tr>

            <th scope="col" class='text-center'><i class="fas fa-sort-numeric-up"></i>
                Stock ID</th>
            <th scope="col" class='text-center'><i class="fas fa-tint"></i> Quatity </th>

            <th scope="col" class='text-center'><i class="fas fa-tint"></i> Blood Group</th>

            <th scope="col" class='text-center'><i class="fas fa-cog"></i>
                Action</th>
        </tr>
    </thead>
    <tbody><?php

            use DataSource\DataSource;

            require_once __DIR__ . '../../../lib/DataSource.php';

            $con = new DataSource;
            $query = 'SELECT stock_id, blood_group,quantity from blood_stock ';
            $paramType = 's';
            $paramArray = array();
            $stocks = $con->select($query, $paramType, $paramArray);

            if (!empty($stocks)) {

                foreach ($stocks as $stock) {


            ?>

                <tr>
                    <th scope="row" class='text-center'>
                        <?php echo $stock['stock_id']; ?>
                    </th>
                    <td>
                        <span class="table-icon"><i class="fas fa-tint"></i></span>
                        <?php echo $stock['quantity']; ?>
                    </td>
                    <td>
                        <span class="table-icon"></span>
                        <?php echo $stock['blood_group']; ?>
                    </td>

                    <td class='text-center'>

                        <span class="table-icon text-danger px-2" onclick="deleteStock('<?php echo $stock['stock_id'] ?>')"><i class="fas fa-times"></i></span>
                    </td>
                </tr>
        <?php
                }
            } else {
                echo "<strong>No requests</strong>";
            }
        ?>
    </tbody>
</table>

<script>
    // let method, result;
    var successAlert = document.getElementById('success-alert');
    var errorAlert = document.getElementById('error-alert');

    const deleteStock = async (stock_id) => {
        const stockID = {
            stock_id: stock_id
        };
        fetch('Model/handleStock.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(stockID)
            })
            .then(response => response.text())
            .then(data => {
                console.log('Success:', data);
                successAlert.classList.remove('d-none');
                errorAlert.classList.add('d-none');
                setTimeout(function() {
                    successAlert.classList.add('d-none');
                    location.reload();
                }, 1300);
            })
            .catch((error) => {
                console.error('Error:', error);
                successAlert.classList.add('d-none');
                errorAlert.classList.remove('d-none');
                setTimeout(function() {
                    errorAlert.classList.add('d-none');
                }, 1300);
            });
    }



</script>