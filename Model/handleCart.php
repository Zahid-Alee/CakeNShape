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
        $query = 'SELECT * FROM cart WHERE CakeID = ? AND userID = ?';
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
        } else {
            echo 'inserting cart';
            $query = 'SELECT * FROM cakes WHERE CakeID = ?';
            $paramType = 's';
            $paramValue = array($data['cakeID']);
            $result = $this->conn->select($query, $paramType, $paramValue);

            if ($result) {
                $imagePath = $result[0]['Image']; // Assuming Image is the column name in the cakes table
                $discount = $result[0]['discount'];

                // Check if the order type is custom
                if ($data['orderType'] === 'custom') {
                    $query = 'INSERT INTO custom_orders (userID, CakeName, price, discount, quantity, description) VALUES (?, ?, ?, ?, ?, ?)';
                    $paramType = 'isssis';
                    $paramValue = array(
                        $data['userID'],
                        $data['cakeName'],
                        $data['price'],
                        $discount,
                        1,
                        $data['description']
                    );
                    $orderID = $this->conn->insert($query, $paramType, $paramValue);

                    $query = 'INSERT INTO custom_order_items (OrderID, Quantity, Subtotal, Image) VALUES (?, ?, ?, ?)';
                    $paramType = 'iiis';
                    $paramValue = array(
                        $orderID,
                        1,
                        $data['price'],
                        $imagePath
                    );
                    $this->conn->insert($query, $paramType, $paramValue);
                } else {
                    $query = 'INSERT INTO cart (CakeID, userID, CakeName, price, discount, quantity, total, Image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
                    $paramType = 'sissssss';
                    $paramValue = array(
                        $data['cakeID'],
                        $data['userID'],
                        $data['cakeName'],
                        $data['price'],
                        $discount,
                        1,
                        $data['price'],
                        $imagePath
                    );

                    $cartID = $this->conn->insert($query, $paramType, $paramValue);
                }

                $response = array("message" => "Cake added to cart successfully.");
            }

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

        $orderDate = date('Y-m-d');
        $deliveryDate = date('Y-m-d', strtotime('+2 hours'));

        // Retrieve the orderType from cart
        $orderType = $cartItems[0]['orderType'];
        $desc = $cartItems[0]['description'];

        // Insert order details into the orders table
        if ($orderType === 'custom') {
            $query = 'INSERT INTO custom_orders (userID, CakeName, price, discount,description, quantity) VALUES (?, ?, ?, ?, ?,?)';
            $paramValue = array($userID, 'Custom Cake', $totalBill, $totalDiscount, $desc, count($cartItems));
            $paramType = 'issssi';
            $orderID = $this->conn->insert($query, $paramType, $paramValue);

            foreach ($cartItems as $item) {
                $query = 'INSERT INTO custom_order_items (OrderID, Quantity, Subtotal, Image) VALUES (?, ?, ?, ?)';
                $paramValue = array($orderID, $item['quantity'], $item['total'], $item['Image']);
                $paramType = 'iids';
                $this->conn->insert($query, $paramType, $paramValue);
            }
        } else {
            $query = 'INSERT INTO orders (userID, OrderDate, DeliveryDate, PaymentMethod, OrderStatus, OrderType) VALUES (?, ?, ?, ?, ?, ?)';
            $paramValue = array($userID, $orderDate, $deliveryDate, $data['paymentMethod'], 'Pending', $orderType);
            $paramType = 'isssss';
            $orderID = $this->conn->insert($query, $paramType, $paramValue);

            // Insert cart items into the order-item table
            foreach ($cartItems as $item) {
                $query = 'INSERT INTO order_items (OrderID, CakeID, Quantity, Subtotal) VALUES (?, ?, ?, ?)';
                $paramValue = array($orderID, $item['CakeID'], $item['quantity'], $item['total']);
                $paramType = 'isid';
                $this->conn->insert($query, $paramType, $paramValue);
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
            $response = array('message' => 'Checkout unsuccessful');
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