<?php

use DataSource\DataSource;


class BloodManagement
{
    private $conn;

    function __construct()
    {
        require_once __DIR__ . '../../lib/DataSource.php';
        $this->conn = new DataSource();
    }

    function deleteStock($stockID)
    {
        // Check if record with given stock_id exists in blood_stock table
        $query = "SELECT * FROM blood_stock WHERE stock_id = ?";
        $paramType = "s";
        $paramValue = array($stockID);
        $result = $this->conn->select($query, $paramType, $paramValue);
    
        // If record exists, delete it and return success message
        if (!empty($result)) {
            // Retrieve donation_id value for the corresponding stock_id value
            $donationID = $result[0]['donation_id'];
    
            // Delete record from blood_stock table
            $query = "DELETE FROM blood_stock WHERE stock_id = ?";
            $paramType = "s";
            $paramValue = array($stockID);
            $this->conn->delete($query, $paramType, $paramValue);
    
            // Delete record from blood_donation table
            $query = "DELETE FROM blood_donation WHERE donation_id = ?";
            $paramType = "s";
            $paramValue = array($donationID);
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
    if (isset($data['stock_id'])) {
        $stock_id = $data['stock_id'];
        echo $stock_id;
        $delStock= new BloodManagement;
       $response= $delStock->deleteStock($data['stock_id']);
       echo json_encode($response);
    } else {
        echo 'stock_id is missing';
    }
}

//   Make sure you check your browser console to see if there are any errors logged. If you still have issues, try adding some debug code to your PHP file to see if the request is actually reaching the server and if the data is being received correctly.
  
  
  
  
  
  
