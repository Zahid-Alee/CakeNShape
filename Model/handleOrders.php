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

    function acceptOrder($data)
    {
        // $query = "UPDATE orders SET OrderStatus = 'approved' WHERE OrderID = ?";
        // $paramType = "i"; // Change "s" to "i" for integer
        // $paramValue = array($data['orderID']);
        // $acceptedOrder = $this->conn->update($query, $paramType, $paramValue);
        $message = "Your Order Has Been Accepted";
        $query = "INSERT INTO user_notifications(OrderID, message, notFor) VALUES (?, ?, ?)";
        $paramType = 'iss';
        $paramValue = array($data['orderID'], $message, 'user');
        $notID = $this->conn->insert($query, $paramType, $paramValue);
        

        if (!empty($acceptedOrder)&&!empty($notID)) {
            $response = array(
                "status" => "success",
                "message" => "Updated successfully"
            );
        } else {
            $response = array(
                "status" => "error",
                "message" => "Update failed try again later"
            );
        }

        return $response;
    }
    function deleteOrder($data)
    {
            // Delete record from blood_stock table
            $query = "DELETE FROM order_items WHERE OrderID = ?";
            $paramType = "s";
            $paramValue = array($data['orderID']);
            $this->conn->delete($query, $paramType, $paramValue);

            $query = "DELETE FROM orders WHERE OrderID = ?";
            $paramType = "i";
            $paramValue = array($data['orderID']);
            $this->conn->delete($query, $paramType, $paramValue);

            $response = array(
                "status" => "success",
                "message" => "Record deleted successfully."
            );
    
        return $response;
    }



}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data['method'] === 'accept') {
        $order = new HandleOrders;
        $response=$order->acceptOrder($data);
        echo json_encode($response);

    } elseif ($data['method'] === 'reject') {
        echo 'delete call';
        $order = new HandleOrders;
        $response= $order->deleteOrder($data);
        echo json_encode($response);

    } else {
        echo 'no operation';
    }

}
;