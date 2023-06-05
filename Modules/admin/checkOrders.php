<?php
// session_start();

$userID = $_SESSION['userID']; ?>

<!--  -->
<table class="table table-striped table-bordered">
    <h3 class="page-heading">Cake Orders</h3>
    <thead class="thead-dark">
        <tr>
            <th scope="col" class='text-center'><i class="fa fa-user px-2"></i>Customer Name</th>
            <th scope="col" class='text-center'><i class="fas fa-sort-numeric-up px-2"></i>Quantity </th>
            <th scope="col" class='text-center'><i class="bx bx-credit-card px-2"></i>PaymentMethod</th>
            <th scope="col" class='text-center'><i class="bx bx-calendar px-2"></i>Order Date</th>
            <th scope="col" class='text-center'><i class="bx bx-calendar px-2"></i>DeliveryDate? Date</th>
            <th scope="col" class='text-center'><i class="fas fa-cog px-2"></i>Action</th>
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
                        <a class="table-icon text-info px-2" style="cursor:pointer"
                            onclick="acceptReq('<?php echo $order['OrderID']; ?>')"><i class="fas fa-check"></i></a>

                        <span class="table-icon text-danger px-2"  style="cursor:pointer" onclick="rejectReq('<?php echo $order['OrderID']; ?>')"><i
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
                location.reload();
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
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    };

</script>