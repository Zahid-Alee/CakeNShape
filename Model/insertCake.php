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
        $uploadDir = '../uploads/cakes/';

        if (isset($_FILES['Image'])) {
            $image = $_FILES['Image'];

            // Generate a unique name for the uploaded image
            $imageName = uniqid() . '_' . $image['name'];
            $imagePath = $uploadDir . $imageName;

            // Move the uploaded image to the desired directory
            if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                // Image uploaded successfully
                $query = 'INSERT INTO cakes (CakeID, CakeName, CategoryID, MaterialUsed, Flavor, Weight, Price, Image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
                $paramType = 'ssssssss';
                $paramValue = array(
                    $_POST['CakeID'],
                    $_POST['CakeName'],
                    $_POST['CategoryID'],
                    $_POST['MaterialUsed'],
                    $_POST['Flavor'],
                    $_POST['Weight'],
                    $_POST['Price'],
                    $imagePath
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
                        "message" => "Error occurred during insertion"
                    );
                }
            } else {
                $response = array(
                    "status" => "error",
                    "message" => "Error uploading image"
                );
            }
        } else {
            $response = array(
                "status" => "error",
                "message" => "Image not found"
            );
        }

        return $response;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newCake = new CakesInsertion;
    $response = $newCake->insertCake();

    // Output the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>