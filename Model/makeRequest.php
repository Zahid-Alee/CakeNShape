<?php

use DataSource\DataSource;
class BloodManagement
{
    private $conn;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->conn = new DataSource();
    }

    function makeReq()
    {

        $query = 'INSERT INTO blood_requests (request_id,hospital_name, blood_group, quantity, location,contact_no) VALUES(?,?,?,?,?,?)';
        $paramType = 'ssssss';
        $paramValue = array(
            $_POST["request_id"],
            $_POST["hospital_name"],
            $_POST["blood_group"],
            $_POST["quantity"],
            $_POST["location"],
            $_POST["contact_no"],
        );
        $donorID = $this->conn->insert($query, $paramType, $paramValue);
        if (!empty($donorID)) {
            $response = array(
                "status" => "success",
                "message" => "You have registered successfully."
            );
        }
        return $response;
    }
}

if ($_POST) {

    $data = $_POST;
    print_r($data);

    $newBloodReq =
        new BloodManagement;

    $newBloodReq->makeReq();
};
