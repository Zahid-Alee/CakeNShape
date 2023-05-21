<?php

use DataSource\DataSource;


class HandleCakeStock
{
    private $conn;

    function __construct()
    {

        require_once __DIR__ . '/../lib/DataSource.php';
        $this->conn = new DataSource();
    }

    function updateCake()
    {

        $query = "UPDATE cakes SET CakeName = ?, CategoryID = ?, MaterialUsed = ?, Flavor = ?, Weight = ?, Quantity = ? , Price = ? WHERE CakeID = ?";
        $paramType = "ssssiiis";
        $paramValue = array(
            $_POST['CakeName'],
            $_POST['CategoryID'],
            $_POST['MaterialUsed'],
            $_POST['Flavor'],
            $_POST['Weight'],
            $_POST['Quantity'],
            $_POST['Price'],
            $_POST['CakeID'],

        );
        $CakeID = $this->conn->update($query, $paramType, $paramValue);
        if (!empty($CakeID)) {
            $response = array(
                "status" => "success",
                "message" => "updated successfully"
            );
        } else {
            $response = array(
                "status" => "error",
                "message" => "Insertion failed"
            );
        }
        return $response;
    }
    function deleteCake($cakeID)
    {
        // Check if record with given stock_id exists in blood_stock table
        $query = "SELECT * FROM cakes WHERE CakeID = ?";
        $paramType = "s";
        $paramValue = array($cakeID);
        $result = $this->conn->select($query, $paramType, $paramValue);

        // If record exists, delete it and return success message
        if (!empty($result)) {
            // Retrieve donation_id value for the corresponding stock_id value
            $CakeID = $result[0]['CakeID'];

            // Delete record from blood_stock table
            $query = "DELETE FROM cakes WHERE CakeID = ?";
            $paramType = "s";
            $paramValue = array($CakeID);
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

if ($_POST) {

    $data = $_POST;
    print_r($data);
    if ($_POST['method']== 'update') {
        echo 'updation call';
        $handleStock =
            new HandleCakeStock;
        $handleStock->updateCake();
    } 
    elseif($_POST['method']=='delete') {
        echo 'delte call';
    $handleStock =
            new HandleCakeStock;
        $handleStock->deleteCake($_POST["CakeID"]);
    }
    else{

    }

}
;