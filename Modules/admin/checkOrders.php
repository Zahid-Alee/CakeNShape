<div class="alerts-notifications">
    <div id="success-alert" class="alert alert-success alert-dismissible fade show d-none" role="alert">
        Stock Has Been Deleted Successfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
<div class="alerts-notifications">
    <div id="success-alert" class="alert alert-success alert-dismissible fade show d-none" role="alert">
        Stock Has Been Deleted Successfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>

<?php
// session_start();
$userID = $_SESSION['userID'];
?>

<!--  -->
<table class="table table-striped table-bordered">
    <h3 class="page-heading">Cake Orders</h3>
    <thead class="thead-dark">
        <tr>
            <th scope="col" class='text-center'><i class="fa fa-user px-2"></i>Customer Name</th>
            <th scope="col" class='text-center'><i class="fas fa-sort-numeric-up px-2"></i>Quantity</th>
            <th scope="col" class='text-center'><i class="bx bx-credit-card px-2"></i>PaymentMethod</th>
            <th scope="col" class='text-center'><i class="bx bx-calendar px-2"></i>Order Date</th>
            <th scope="col" class='text-center'><i class="bx bx-calendar px-2"></i>Delivery Date</th>
            <th scope="col" class='text-center'><i class="fas fa-cog px-2"></i>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        use DataSource\DataSource;
        require_once __DIR__ . '../../../lib/DataSource.php';

        $con = new DataSource;
        $query = 'SELECT *
                  FROM Orders
                  JOIN Users ON Orders.userID = Users.userID
                  WHERE Orders.OrderStatus = "Pending"';
        $orders = $con->select($query);

        if (!empty($orders)) {
            foreach ($orders as $order) {
                $orderID = $order['OrderID'];
                $query = "SELECT oi.CakeID, oi.Quantity, oi.Subtotal, c.CakeName, c.MaterialUsed, c.Flavor, c.Weight, c.Price
                          FROM Order_Items AS oi
                          JOIN Cakes AS c ON oi.CakeID = c.CakeID
                          WHERE oi.OrderID = ?";
                $paramType = "i";
                $paramValue = array($orderID);
                $orderItems = $con->select($query, $paramType, $paramValue);
                ?>
                <tr>
                    <td scope="row" class='text-center'>
                        <?php echo $order['username']; ?>
                    </td>
                    <td scope="row" class='text-center'>
                        <?php echo $orderItems ? count($orderItems) : 0; ?>
                    </td>
                    <td class='text-center'>
                        <?php echo $order['PaymentMethod']; ?>
                    </td>
                    <td class='text-center'>
                        <?php echo $order['OrderDate']; ?>
                    </td>
                    <td class='text-center'>
                        <?php echo $order['DeliveryDate']; ?>
                    </td>
                    <td class='text-center'>
                        <a class="table-icon text-info px-2" style="cursor:pointer"
                            onclick="acceptReq('<?php echo $orderID; ?>')"><i class="fas fa-check"></i></a>
                        <span class="table-icon text-danger px-2" style="cursor:pointer"
                            onclick="rejectReq('<?php echo $orderID; ?>')"><i class="fas fa-times"></i></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <?php if ($orderItems) { ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" class='text-center'>Cake Name</th>
                                    <th scope="col" class='text-center'>Material Used</th>
                                    <th scope="col" class='text-center'>Flavor</th>
                                    <th scope="col" class='text-center'>Weight</th>
                                    <th scope="col" class='text-center'>Price</th>
                                    <th scope="col" class='text-center'>Quantity</th>
                                    <th scope="col" class='text-center'>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($orderItems as $item) {
                                    ?>
                                    <tr>
                                        <td class='text-center'>
                                            <?php echo $item['CakeName']; ?>
                                        </td>
                                        <td class='text-center'>
                                            <?php echo $item['MaterialUsed']; ?>
                                        </td>
                                        <td class='text-center'>
                                            <?php echo $item['Flavor']; ?>
                                        </td>
                                        <td class='text-center'>
                                            <?php echo $item['Weight']; ?>
                                        </td>
                                        <td class='text-center'>
                                            <?php echo $item['Price']; ?>
                                        </td>
                                        <td class='text-center'>
                                            <?php echo $item['Quantity']; ?>
                                        </td>
                                        <td class='text-center'>
                                            <?php echo $item['Subtotal']; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php } else {
                            echo "<p>No order items found</p>";
                        } ?>
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
    // Your JavaScript code 
    
    
    const successAlert = document.getElementById('success-alert');
    // const errorAlert = document.getElementById('error-alert');

    const createNotification = (message, callback) => {
        const alertElement = successAlert;
        alertElement.innerHTML = message;
        alertElement.classList.remove('d-none');
        const intervalId = setTimeout(() => {
            alertElement.classList.add('d-none');
            clearTimeout(intervalId);
            if (callback) {
                // callback();
                location.reload()
            }
        }, 2000);
    };

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
                console.log('Response:',data);
                console.log(data)
                createNotification(data)
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




<!-- 




<script>
    // let method, result;
    // var successAlert = document.getElementById('success-alert');
    // var errorAlert = document.getElementById('error-alert');


</script> -->