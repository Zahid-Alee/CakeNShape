<?php

use DataSource\DataSource;


class HandleCart
{
    private $conn;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->conn = new DataSource();
    }

    function addToCart($data)
    {

        $query = 'SELECT * FROM cart WHERE CakeID = ? AND userID=?';
        $paramType = 'ss';
        $paramValue = array($data['cakeID'], $data['userID']);
        $cartItem = $this->conn->select($query, $paramType, $paramValue);

        // If cartId exists, update quantity and price and return success message
        if (!empty($cartItem)) {
            $updatedQuantity = $cartItem[0]['quantity'] + 1;
            $updatedPrice = ($cartItem[0]['price'] * $updatedQuantity) - ($cartItem[0]['discount']);
            $query = 'UPDATE cart SET quantity = ?, total = ? WHERE CakeID = ?';
            $paramType = 'sss';
            $paramValue = array($updatedQuantity, $updatedPrice, $data['cakeID']);
            $this->conn->update($query, $paramType, $paramValue);
            $response = array("message" => "Cart updated successfully.");
            // Reload the current page
            return $response;

        }

        // If donation_id does not exist, insert new record and return success message
        else {
            echo 'inserting cart';
            $query = 'SELECT Image FROM cakes WHERE CakeID = ?';
            $paramType = 's';
            $paramValue = array($data['cakeID']);
            $result = $this->conn->select($query, $paramType, $paramValue);

            if ($result) {
                $imagePath = $result[0]['Image']; // Assuming Image is the column name in the cakes table

                $query = 'INSERT INTO cart (CakeID, userID, CakeName, price, quantity, total, Image) VALUES (?, ?, ?, ?, ?, ?, ?)';
                $paramType = 'sisssss';
                $paramValue = array(
                    $data['cakeID'],
                    $data['userID'],
                    $data['cakeName'],
                    $data['price'],
                    1,
                    $data['price'],
                    $imagePath
                );

                $cartID = $this->conn->insert($query, $paramType, $paramValue);
                $response = array("message" => "Cake added to cart successfully.");
            }

            // echo $image[0];

            // Reload the current page
            return $response;
        }
    }

    function delteItem($data)
    {

        $query = 'DELETE FROM cart WHERE cartID = ?';
        $paramValue = array($data['cartID']);
        $paramType = 'i';
        $id = $this->conn->delete($query, $paramType, $paramValue);
        $response = array('message' => 'cart item has been removed');
        return $response;
    }
    function createUserNotification($id)
    {
        session_start();
        $userID = $_SESSION['userID'];
        $message = "Your Order Has Been Placed";
        $query = "INSERT INTO user_notifications(OrderID, userID, message, notFrom) VALUES (?, ?, ?, ?)";
        $paramType = 'iiss';
        $paramValue = array($id, $userID, $message, 'user');
        return $this->conn->insert($query, $paramType, $paramValue);
    }

    function checkoutCart($data)
    {
        // Get the user ID from the input data
        $userID = $data['userID'];
        // Retrieve the cart items for the user
        $query = 'SELECT * FROM cart WHERE userID = ?';
        $paramValue = array($userID);
        $paramType = 'i';
        $cartItems = $this->conn->select($query, $paramType, $paramValue);

        // Calculate total bill and discount
        $totalBill = 0;
        $totalDiscount = 0;
        foreach ($cartItems as $item) {
            $totalBill += $item['total'];
            $totalDiscount += $item['discount'];
        }

        // Get the current date and delivery date (assuming you have appropriate logic to determine the delivery date)
        $orderDate = date('Y-m-d');
        $deliveryDate = date('Y-m-d', strtotime('+2 hours')); // Example: delivery in 3 days

        // Insert order details into the orders table
        $query = 'INSERT INTO orders (userID, OrderDate, DeliveryDate, PaymentMethod, OrderStatus) VALUES (?, ?, ?, ?, ?)';
        $paramValue = array($userID, $orderDate, $deliveryDate, $data['paymentMethod'], 'Pending'); // Assuming payment method is provided in the input data
        $paramType = 'issss';
        $orderID = $this->conn->insert($query, $paramType, $paramValue); // Get the last inserted order ID
        // Insert cart items into the order-item table
        foreach ($cartItems as $item) {
            if ($item['CakeID']) {
                $query = 'INSERT INTO `order_items` (OrderID, CakeID, Quantity, Subtotal) VALUES (?, ?, ?, ?)';
                $paramValue = array($orderID, $item['CakeID'], $item['quantity'], $item['total']);
                $paramType = 'isid';
                $ordersItemId = $this->conn->insert($query, $paramType, $paramValue);
            }
            else{

                $query = 'INSERT INTO `order_items` (OrderID, Quantity, Subtotal) VALUES ( ?, ?, ?)';
                $paramValue = array($orderID, $item['quantity'], $item['total']);
                $paramType = 'iid';
                $ordersItemId = $this->conn->insert($query, $paramType, $paramValue);
            }

        }

        // Delete the cart items for the user
        $query = 'DELETE FROM cart WHERE userID = ?';
        $paramValue = array($userID);
        $paramType = 'i';
        $cartDelID = $this->conn->delete($query, $paramType, $paramValue);

        $userNotificationId = $this->createUserNotification($orderID);

        if ($userNotificationId) {
            $response = array('message' => 'Checkout successful');
        } else {
            $response = array('message' => 'Checkout unsuccessfull');

        }


        // Prepare and return the response

        return $response;
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    print_r($data);

    if ($data['method'] === 'add') {
        echo 'add call';
        $cartItem = new HandleCart;
        $cartItem->addToCart($data);

    } elseif ($data['method'] === 'remove') {
        echo 'delete call';
        $del = new HandleCart;
        $del->delteItem($data);

    } elseif ($data['method'] === 'checkout') {
        echo 'checkout call';
        $checkout = new HandleCart;
        $checkout->checkoutCart($data);

    } else {
        echo 'no operation';
    }
}