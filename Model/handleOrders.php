<?php

use DataSource\DataSource;

class HandleOrders
{
    private $conn;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->conn = new DataSource();
    }

    function createAdminNotification($data)
    {
        $query = "SELECT userID FROM Orders WHERE OrderID = ?";
        $paramType = "i";
        $paramValue = array($data['orderID']);
        $user = $this->conn->select($query, $paramType, $paramValue);

        if (!empty($user)) {
            $userID = $user[0]['userID'];
            $message = "Your Order Has Been Accepted";
            $query = "INSERT INTO user_notifications(OrderID, userID, message, notFrom) VALUES (?, ?, ?, ?)";
            $paramType = 'iiss';
            $paramValue = array($data['orderID'], $userID, $message, 'CakeNShape');
            return $this->conn->insert($query, $paramType, $paramValue);
        } else {
            return "User not found";
        }
    }
    function acceptOrder($data)
    {
        $orderID = $data['orderID'];
        $orderType = $data['orderType'];

        // Check if the order is a custom order or a regular order
        if ($orderType === 'custom') {
            // Update the custom order status to 'approved'
            $query = "UPDATE custom_orders SET OrderStatus = 'approved' WHERE id = ?";
            $paramType = "i";
            $paramValue = array($orderID);
            $this->conn->update($query, $paramType, $paramValue);

            // Fetch custom order details
            $query = "SELECT co.id, co.quantity, co.price, 'custom' AS Category
                  FROM custom_orders AS co
                  WHERE co.id = ?";
            $paramType = "i";
            $paramValue = array($orderID);
            $orderDetails = $this->conn->select($query, $paramType, $paramValue);

            // Insert a single sales record per custom order
            $query = "INSERT INTO Sales (OrderID, Quantity, Subtotal, Category)
                  VALUES (?, ?, ?, ?)";
            $paramType = "isds";
            $paramValue = array(
                $orderID,
                $orderDetails[0]['quantity'],
                $orderDetails[0]['price'],
                $orderDetails[0]['Category']
            );
            $this->conn->insert($query, $paramType, $paramValue);

            // Delete the custom order from the custom_orders table
            $query = "DELETE FROM custom_orders WHERE id = ?";
            $paramType = "i";
            $paramValue = array($orderID);
            $this->conn->delete($query, $paramType, $paramValue);
        } else {
            // Check if there is sufficient quantity for the cakes in the order
            $query = "SELECT oi.CakeID, oi.Quantity, c.Quantity AS AvailableQuantity, c.Price, ca.CategoryName AS Category
                  FROM Order_Items AS oi
                  JOIN Cakes AS c ON oi.CakeID = c.CakeID
                  JOIN Categories AS ca ON c.CategoryID = ca.CategoryID
                  WHERE oi.OrderID = ?";
            $paramType = "i";
            $paramValue = array($orderID);
            $orderItems = $this->conn->select($query, $paramType, $paramValue);

            $insufficientQuantity = false;

            foreach ($orderItems as $orderItem) {
                $cakeID = $orderItem['CakeID'];
                $quantity = $orderItem['Quantity'];
                $availableQuantity = $orderItem['AvailableQuantity'];

                if ($quantity > $availableQuantity) {
                    $insufficientQuantity = true;
                    break;
                }
            }

            if ($insufficientQuantity) {
                $response = array(
                    "status" => "error",
                    "message" => "Insufficient quantity for one or more cakes in the order"
                );
            } else {
                // Update the regular order status to 'approved'
                $query = "UPDATE Orders SET OrderStatus = 'approved' WHERE OrderID = ?";
                $paramType = "i";
                $paramValue = array($orderID);
                $this->conn->update($query, $paramType, $paramValue);

                // Calculate total sales and insert a single sales record per regular order
                $totalQuantity = 0;
                $totalSubtotal = 0;

                foreach ($orderItems as $orderItem) {
                    $quantity = $orderItem['Quantity'];
                    $price = $orderItem['Price'];

                    $totalQuantity += $quantity;
                    $totalSubtotal += $quantity * $price;
                }

                $query = "INSERT INTO Sales (OrderID, Quantity, Subtotal, Category)
                      VALUES (?, ?, ?, ?)";
                $paramType = "isds";
                $paramValue = array(
                    $orderID,
                    $totalQuantity,
                    $totalSubtotal,
                    $orderItems[0]['Category']
                );
                $this->conn->insert($query, $paramType, $paramValue);

                // Update the quantity of cakes in the order
                foreach ($orderItems as $orderItem) {
                    $quantity = $orderItem['Quantity'];
                    $cakeID = $orderItem['CakeID'];

                    $query = "UPDATE Cakes SET Quantity = Quantity - ? WHERE CakeID = ?";
                    $paramType = "is";
                    $paramValue = array($quantity, $cakeID);
                    $this->conn->update($query, $paramType, $paramValue);
                }

                $notID = $this->createAdminNotification($data);

                if (!empty($notID)) {
                    $response = array(
                        "status" => "success",
                        "message" => "Order accepted and updated successfully"
                    );
                } else {
                    $response = array(
                        "status" => "error",
                        "message" => "Failed to create admin notification"
                    );
                }

                // Delete the regular order from the orders table
                $query = "DELETE FROM orders WHERE OrderID = ?";
                $paramType = "i";
                $paramValue = array($orderID);
                $this->conn->delete($query, $paramType, $paramValue);
            }
        }

        return $response;
    }


    function deleteOrder($data)
    {
        $orderID = $data['orderID'];
        $orderType = $data['orderType'];

        // Set foreign key references to null in user_notifications table
        $query = "UPDATE user_notifications SET OrderID = NULL WHERE OrderID = ?";
        $paramType = "i";
        $paramValue = array($orderID);
        $this->conn->update($query, $paramType, $paramValue);

        // Set foreign key references to null in order_items table
        $query = "UPDATE order_items SET OrderID = NULL WHERE OrderID = ?";
        $paramType = "i";
        $paramValue = array($orderID);
        $this->conn->update($query, $paramType, $paramValue);

        // Delete record from orders or custom_orders table based on order type
        if ($orderType === 'custom') {
            $query = "DELETE FROM custom_orders WHERE id = ?";
        } else {
            $query = "DELETE FROM orders WHERE OrderID = ?";
        }

        $paramType = "i";
        $paramValue = array($orderID);
        $this->conn->delete($query, $paramType, $paramValue);

        $response = array(
            "status" => "success",
            "message" => "Order deleted successfully."
        );

        return $response;
    }



}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    print_r($data);


    $order = new HandleOrders;

    if ($data['method'] === 'accept') {
        $response = $order->acceptOrder($data);
        echo json_encode($response);
    } elseif ($data['method'] === 'reject') {
        $response = $order->deleteOrder($data);
        echo json_encode($response);
    } else {
        echo 'No operation specified.';
    }
}