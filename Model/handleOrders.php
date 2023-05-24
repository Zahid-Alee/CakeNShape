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
        $query = "UPDATE orders SET OrderStatus = 'approved' WHERE OrderID = ?";
        $paramType = "i"; // Change "s" to "i" for integer
        $paramValue = array(
            intval($data['orderID']), // Convert to integer
        );
        $affectedRows = $this->conn->update($query, $paramType, $paramValue);

        if ($affectedRows > 0) {
            $response = array(
                "status" => "success",
                "message" => "Updated successfully"
            );
        } else {
            $response = array(
                "status" => "error",
                "message" => "Update failed"
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
            $paramType = "s";
            $paramValue = array($$data['orderID']);
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
    print_r($data);

    if ($data['method'] === 'accept') {
        $order = new HandleOrders;
        $order->acceptOrder($data);

    } elseif ($data['method'] === 'reject') {
        echo 'delete call';
        $order = new HandleOrders;
        $order->deleteOrder($data);

    } else {
        echo 'no operation';
    }
}
;