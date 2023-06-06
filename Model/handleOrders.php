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

        // Check if there is sufficient quantity for the cakes in the order
        $query = "SELECT oi.CakeID, oi.Quantity, c.Quantity AS AvailableQuantity
                  FROM Order_Items AS oi
                  JOIN Cakes AS c ON oi.CakeID = c.CakeID
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
            // Update the order status to 'approved'
            $query = "UPDATE Orders SET OrderStatus = 'approved' WHERE OrderID = ?";
            $paramType = "i";
            $paramValue = array($orderID);
            $this->conn->update($query, $paramType, $paramValue);

            // Update the cake quantities
            foreach ($orderItems as $orderItem) {
                $cakeID = $orderItem['CakeID'];
                $quantity = $orderItem['Quantity'];

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
        }

        return $response;
    }

    function deleteOrder($data)
    {
        $orderID = $data['orderID'];

        // Delete record from order_items table
        $query = "DELETE FROM order_items WHERE OrderID = ?";
        $paramType = "i";
        $paramValue = array($orderID);
        $ordersDelId = $this->conn->delete($query, $paramType, $paramValue);

        // Delete record from orders table
        $query = "DELETE FROM orders WHERE OrderID = ?";
        $paramType = "i";
        $paramValue = array($orderID);
        $orderItemsDelId = $this->conn->delete($query, $paramType, $paramValue);

        if (!empty($ordersDelId) && !empty($orderItemsDelId)) {
            $response = array(
                "status" => "success",
                "message" => "Record deleted successfully."
            );
        } else {
            $response = array(
                "status" => "error",
                "message" => "Error deleting orders."
            );
        }

        return $response;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

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
