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

        $query = "UPDATE cakes SET CakeName = ?, CategoryID = ?, MaterialUsed = ?, Flavor = ?, Weight = ?, Price = ?, Quantity = ? WHERE CakeID = ?";
        $paramType = "iisssddi";
        $paramValue = array(
            $_POST['CakeName'],
            $_POST['CategoryID'],
            $_POST['MaterialUsed'],
            $_POST['Flavor'],
            $_POST['Weight'],
            $_POST['Price'],
            $_POST['Quantity'],
            $_POST['CakeID']
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
}

if ($_POST) {

    $data = $_POST;
    print_r($data);
    // $newCake =
    //     new HandleCakeStock;

    // $newCake->updateCake();
};
