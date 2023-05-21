<?php

use DataSource\DataSource;


class CakesInsertion
{
    private $conn;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->conn = new DataSource();
    }

    function insertCake()
    {
        $image = file_get_contents($_FILES['Image']['tmp_name']); // Get the image file content
        // $imageData = base64_encode($image); // Encode the image data using base64 encoding
        $query = 'INSERT INTO cakes (CakeID, CakeName, CategoryID, MaterialUsed, Flavor, Weight, Price) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $paramType = 'sssssss';
        $paramValue = array(
            $_POST['CakeID'],
            $_POST['CakeName'],
            $_POST['CategoryID'],
            $_POST['MaterialUsed'],
            $_POST['Flavor'],
            $_POST['Weight'],
            $_POST['Price'],
            // $imageData // Insert the encoded image data
        );
        $CakeID = $this->conn->insert($query, $paramType, $paramValue);
        if (!empty($CakeID)) {
            $response = array(
                "status" => "success",
                "message" => "Inserted successfully"
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
    // $image = file_get_contents($_FILES['Image']['tmp_name']); // Get the image file content
    // $imageData = base64_encode($image);

    $newCake =
        new CakesInsertion;

    $newCake->insertCake();
};
