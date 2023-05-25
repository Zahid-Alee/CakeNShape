<?php
// session_start();

$userID = $_SESSION['userID']; ?>

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
            <th scope="col" class='text-center'><i class="fas fa-sort-numeric-up"></i>Customer Name</th>
            <th scope="col" class='text-center'><i class="fas fa-sort-numeric-up"></i> </th>
            <th scope="col" class='text-center'><i class="fas fa-image"></i> Image</th>
            <th scope="col" class='text-center'><i class="fas fa-tint"></i> Weight</th>
            <th scope="col" class='text-center'><i class="fas fa-tint"></i> Quantity</th>
            <!-- <th scope="col" class='text-center'><i class="fas fa-tint"></i>Total </th> -->
            <!-- <th scope="col" class='text-center'><i class="fas fa-dollar-sign"></i> Date</th> -->
            <th scope="col" class='text-center'><i class="fas fa-cog"></i> Action</th>
        </tr>
    </thead>
    <tbody>
        <?php

        use DataSource\DataSource;

        require_once __DIR__ . '../../../lib/DataSource.php';

        $con = new DataSource;
        $query = 'SELECT  *
      FROM orders
      JOIN users ON orders.userID = users.userID
      WHERE orders.OrderStatus = "Pending"';


        $orders = $con->select($query);

        if (!empty($orders)) {
            foreach ($orders as $order) {
                ?>
                <tr>
                    <td scope="row" class='text-center'>
                        <?php echo $order['username']; ?>
                    </td>
                    <td scope="row" class='text-center'>
                        <?php echo $order['userID']; ?>
                    </td>
                    <!-- <td class='text-center'><img src="" height="75" width="75" /></td> -->
                    <!-- <td class='text-center'>
                         lbs
                    </td> -->

                    <td class='text-center'>
                        <?php echo $order['PaymentMethod']; ?>
                    </td>
                    <td class='text-center'>$
                        <?php echo $order['OrderDate']; ?>
                    </td>
                    <td class='text-center'>
                        <?php echo $order['DeliveryDate']; ?>
                    </td>
                    <td class='text-center'>
                        <a class="table-icon text-info px-2"
                            onclick="acceptReq('<?php echo $order['OrderID']; ?>')"><i
                                class="fas fa-edit"></i></a>

                        <span class="table-icon text-danger px-2" onclick="rejectReq('<?php echo $order['OrderID']; ?>')"><i
                                class="fas fa-times"></i></span>
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

    const acceptReq = (orderID, CakeID) => {
        let data = {
            orderID: orderID,
            method: 'accept',
            cakeID: CakeID
        };

        fetch('Model/handleOrders.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.text())
            .then(data => {
                console.log('Response:', data);
                // location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    };
    const rejectReq = (orderID) => {
        let data = {
            orderID: orderID,
            method: 'reject',
            // cakeID: CakeID
        };

        fetch('Model/handleOrders.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.text())
            .then(data => {
                console.log('Response:', data);
                // location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    };

</script>