<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', '/tmp/php_errors.log');

use DataSource\DataSource;


class BloodManagement
{
    private $conn;

    function __construct()
    {
        require_once __DIR__ . '../../lib/DataSource.php';
        $this->conn = new DataSource();
    }

    function acceptReq($request_id, $blood_group,$quantity, $request_status) {
        $query = 'SELECT * FROM blood_stock WHERE blood_group = ? AND quantity >= ?';
        $paramType = 'ss';
        $paramValue = array($blood_group, $quantity);
        $result = $this->conn->select($query, $paramType, $paramValue);
    
        if (empty($result)) {
            return array(
                "status" => "error",
                "message" => "Not enough stock available for $blood_group blood type."
            );
        }
    
        $updatedQuantity = $result[0]['quantity'] - $quantity;
        $query = 'UPDATE blood_stock SET quantity = ? WHERE blood_group = ?';
        $paramType = 'ss';
        $paramValue = array($updatedQuantity, $blood_group);
        $this->conn->update($query, $paramType, $paramValue);
    
        $query = 'UPDATE blood_requests SET request_status = ? WHERE request_id = ?';
        $paramType = 'ss';
        $paramValue = array($request_status, $request_id);
        $updatedRows = $this->conn->update($query, $paramType, $paramValue);
    
        if ($updatedRows === false) {
            return array(
                "status" => "error",
                "message" => "Failed to update request status."
            );
        }
    
        return array(
            "status" => "success",
            "message" => "Blood request has been accepted."
        );
    }
    
    

    function RejectReq($reqID)
    {
        // Check if record with given stock_id exists in blood_stock table
        $query = "SELECT * FROM blood_requests WHERE request_id = ?";
        $paramType = "s";
        $paramValue = array($reqID);
        $result = $this->conn->select($query, $paramType, $paramValue);

        // If record exists, delete it and return success message
        if (!empty($result)) {
            $query = "DELETE FROM blood_requests WHERE request_id = ?";
            $paramType = "s";
            $paramValue = array($reqID);
            $this->conn->delete($query, $paramType, $paramValue);
            $response = array(
                "status" => "success",
                "message" => "Record deleted successfully."
            );
        }
        // If record does not exist, return error message
        else {
            $response = array(
                "status" => "error",
                "message" => "Record not found."
            );
        }

        return $response;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $handleReq = new BloodManagement;

    if ($data['method'] === 'reject') {
        $response =  $handleReq->RejectReq($data['request_id']);
    } elseif ($data['method'] === 'accept') {
        // print_r($data);
        // echo 'request accepted';
        $response =  $handleReq->acceptReq(
            $data['request_id'],
            $data['blood_group'],
            $data['quantity'],
            $data['request_status']
        );
    } else {

        $response = array(
            "status" => "error",
            "message" => "wrong method."
        );
    }

    echo json_encode($response);
}
