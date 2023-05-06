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

    function acceptReq(
        $stock_id,
        $donation_id,
        $blood_group,
        $quantity,
        $requestStatus
    ) {
        // Check if donation_id already exists in blood_stock table
        $query = 'SELECT * FROM blood_stock WHERE blood_group = ?';
        $paramType = 's';
        $paramValue = array($blood_group);
        $result = $this->conn->select($query, $paramType, $paramValue);

        // If bloo_group exists, update quantity and return success message
        if (!empty($result)) {
            $updatedQuantity = $result[0]['quantity'] + $quantity;
            $query = 'UPDATE blood_stock SET quantity = ? WHERE blood_group = ?';
            $paramType = 'ss';
            $paramValue = array($updatedQuantity, $blood_group);
            $this->conn->update($query, $paramType, $paramValue);
        }
        // If donation_id does not exist, insert new record and return success message
        else {
            $query = 'INSERT INTO blood_stock (stock_id, blood_group,quantity) VALUES(?,?,?)';
            $paramType = 'sss';
            $paramValue = array(
                $stock_id,
                $blood_group,
                $quantity,
            );
            $stockID = $this->conn->insert($query, $paramType, $paramValue);
        }
        $query = 'UPDATE blood_donation SET request_status = ? WHERE donation_id = ?';
        $paramType = 'ss';
        $paramValue = array($requestStatus, $donation_id);
        $updatedID = $this->conn->update(
            $query,
            $paramType,
            $paramValue
        );
        $response = array();
        if (!empty($stockID && $updatedID)) {
            $response = array(
                "status" => "success",
                "message" => "You have registered successfully."
            );
        }
        return $response;
    }

    function RejectReq($donorID)
    {
        // Check if record with given stock_id exists in blood_stock table
        $query = "SELECT * FROM blood_donation WHERE donation_id = ?";
        $paramType = "s";
        $paramValue = array($donorID);
        $result = $this->conn->select($query, $paramType, $paramValue);

        // If record exists, delete it and return success message
        if (!empty($result)) {
            $query = "DELETE FROM blood_donation WHERE donation_id = ?";
            $paramType = "s";
            $paramValue = array($donorID);
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
    // print_r($data);

    $insertDonor = new BloodManagement;

    $response = $data['method'] === 'reject'
        ? $insertDonor->RejectReq($data['donation_id'])
        : $insertDonor->acceptReq(
            $data['stock_id'],
            $data['donation_id'],
            $data['blood_group'],
            $data['quantity'],
            $data['request_status']
        );

    echo json_encode($response);
}
