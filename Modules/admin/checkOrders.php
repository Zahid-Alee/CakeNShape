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
<!-- Table for displaying orders from the "Orders" table -->
<div class="">
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-heading">Cake Orders</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" class='text-center'>Customer Name</th>
                            <th scope="col" class='text-center'>Address</th>
                            <th scope="col" class='text-center'>Phone</th>
                            <th scope="col" class='text-center'>Zip</th>
                            <th scope="col" class='text-center'>Quantity</th>
                            <th scope="col" class='text-center'>Payment
                            </th>
                            <th scope="col" class='text-center'>Order Date</th>
                            <th scope="col" class='text-center'>Delivery Date</th>
                            <th scope="col" class='text-center'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        use DataSource\DataSource;

                        require_once __DIR__ . '../../../lib/DataSource.php';

                        $con = new DataSource;

                        // Query to retrieve orders from the orders table
                        $query = 'SELECT *
                                  FROM Orders
                                  JOIN Users ON Orders.userID = Users.userID
                                  WHERE Orders.OrderStatus = "Pending"';
                        $orders = $con->select($query);

                        if (!empty($orders)) {
                            foreach ($orders as $order) {
                                $orderID = $order['OrderID'];

                                // Query to retrieve order items from the order_items table
                                $query = 'SELECT oi.CakeID, oi.Quantity, oi.Subtotal, c.CakeName, c.MaterialUsed, c.Flavor, c.Weight, c.Price
                                          FROM Order_Items AS oi
                                          JOIN Cakes AS c ON oi.CakeID = c.CakeID
                                          WHERE oi.OrderID = ?';

                                $paramType = "i";
                                $paramValue = array($orderID);
                                $orderItems = $con->select($query, $paramType, $paramValue);
                                ?>
                                <tr>
                                    <td scope="row" class='text-center'>
                                        <?php echo $order['username']; ?>
                                    </td>
                                    <td scope="row" class='text-center'>
                                        <?php echo $order['address']; ?>
                                    </td>
                                    <td scope="row" class='text-center'>
                                        <?php echo $order['phone']; ?>
                                    </td>
                                    <td scope="row" class='text-center'>
                                        <?php echo $order['zip']; ?>
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
                                        1 hour 30 min
                                    </td>
                                    <td class='text-center'>
                                        <a class="table-icon text-info px-2" style="cursor:pointer"
                                            onclick="acceptReq('<?php echo $orderID; ?>')"><i class="fas fa-check"></i></a>
                                        <span class="table-icon text-danger px-2" style="cursor:pointer"
                                            onclick="rejectReq('<?php echo $orderID; ?>')"><i class="fas fa-times"></i></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="9">
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
                                            echo "<p class='text-center'>No order items found</p>";
                                        } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'><strong>No Orders from shop</strong></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="">
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-heading">Custom Cake Orders</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" class='text-center'>Customer Name</th>
                            <th scope="col" class='text-center'>Address</th>
                            <th scope="col" class='text-center'>Phone</th>
                            <th scope="col" class='text-center'>Zip</th>
                            <th scope="col" class='text-center'>Quantity</th>
                            <th scope="col" class='text-center'>Price</th>
                            <th scope="col" class='text-center'>Order Date</th>
                            <th scope="col" class='text-center'>Delivery Date</th>
                            <th scope="col" class='text-center'>Image</th>
                            <th scope="col" class='text-center'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = 'SELECT *
                                  FROM custom_orders
                                  JOIN Users ON custom_orders.userID = Users.userID';
                        $customOrders = $con->select($query);

                        if (!empty($customOrders)) {
                            foreach ($customOrders as $customOrder) {
                                $customOrderID = $customOrder['id'];

                                // Query to retrieve order items from the custom_order_items table
                                $query = 'SELECT *
                                          FROM custom_order_items
                                          WHERE custom_order_items.OrderID = ?';

                                $paramType = "i";
                                $paramValue = array($customOrderID);
                                $customOrderItems = $con->select($query, $paramType, $paramValue);
                                ?>
                                <tr>
                                    <td scope="row" class='text-center'>
                                        <?php echo $customOrder['username']; ?>
                                    </td>
                                    <td scope="row" class='text-center'>
                                        <?php echo $customOrder['address']; ?>
                                    </td>
                                    <td scope="row" class='text-center'>
                                        <?php echo $customOrder['phone']; ?>
                                    </td>
                                    <td scope="row" class='text-center'>
                                        <?php echo $customOrder['zip']; ?>
                                    </td>
                                   
                                    <td scope="row" class='text-center'>
                                        <?php echo $customOrderItems ? count($customOrderItems) : 0; ?>
                                    </td>
                                    <td class='text-center'>
                                        <?php echo $customOrder['price']; ?>
                                    </td>
                                    <td class='text-center'>
                                        <?php echo $customOrder['OrderDate']; ?>
                                    </td>
                                    <td class='text-center'>
                                        3 hours
                                    </td>
                                    <td class='text-center'>
                                        <?php if ($customOrderItems) { ?>
                                            <img src="<?php echo substr($customOrderItems[0]['Image'], 3); ?>" alt="Cake Image"
                                                width="100">
                                        <?php } else {
                                            echo "-";
                                        } ?>
                                    </td>
                                    <td class='text-center'>
                                        <a class="table-icon text-info px-2" style="cursor:pointer"
                                            onclick="acceptReq('<?php echo $customOrderID; ?>',null,'custom')"><i
                                                class="fas fa-check"></i></a>
                                        <span class="table-icon text-danger px-2" style="cursor:pointer"
                                            onclick="rejectReq('<?php echo $customOrderID; ?>','custom')"><i
                                                class="fas fa-times"></i></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="10">
                                        <?php if ($customOrderItems) { ?>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class='text-center'> <strong>Quantity </strong> </th>
                                                        <th scope="col" class='text-center'><strong>Subtotal </strong></th>
                                                        <th scope="col" class='text-center'><strong>Description</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($customOrderItems as $item) { ?>
                                                        <tr>
                                                            <td class='text-center'>
                                                                <?php echo $item['Quantity']; ?>
                                                            </td>
                                                            <td class='text-center'>
                                                                <?php echo $item['Subtotal']; ?>
                                                            </td>
                                                            <td class='text-center'>
                                                                <?php echo $customOrder['description']; ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        <?php } else {
                                            echo "<p class='text-center'>No custom order items found</p>";
                                        } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'><strong>No custom orders found</strong></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




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

    const acceptReq = (orderID, CakeID, orderType) => {
        let data = {
            orderID: orderID,
            method: 'accept',
            cakeID: CakeID,
            orderType: orderType
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
                console.log(data)
                // createNotification(data.message)
                location.reload()
            })
            .catch(error => {
                console.error('Error:', error);
            });
    };
    const rejectReq = (orderID, orderType) => {
        let data = {
            orderID: orderID,
            method: 'reject',
            // cakeID: CakeID
            orderType: orderType
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




<!-- 




<script>
    // let method, result;
    // var successAlert = document.getElementById('success-alert');
    // var errorAlert = document.getElementById('error-alert');


</script> -->