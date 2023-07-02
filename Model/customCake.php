<?php

use DataSource\DataSource;

class CustomCake
{
    private $conn;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->conn = new DataSource();
    }

    function placeOrder()
    {
        $uploadDir = '../uploads/custom-cakes/';
        session_start();
        $userID = $_SESSION['userID'];

        if (isset($_FILES['Image'])) {
            $image = $_FILES['Image'];

            // Generate a unique name for the uploaded image
            $imageName = uniqid() . '_' . $image['name'];
            $imagePath = $uploadDir . $imageName;
            $price = 300 * $_POST['Quantity'];

            // Move the uploaded image to the desired directory
            if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                // Image uploaded successfully
                $query = 'INSERT INTO cart (userID,total,quantity,description,Image,OrderType) VALUES(?,?,?,?,?,?)';
                $paramType = 'isssss';
                $paramValue = array(
                    $userID,
                    $price,
                    $_POST['Quantity'],
                    $_POST['Description'],
                    $imagePath,
                    'custom'

                );
                $cartID = $this->conn->insert($query, $paramType, $paramValue);
                $response = array("message" => "Cake added to cart successfully.");
                // Reload the current page
                return $response;

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
    print_r($_POST);
    $newCake = new CustomCake;
    $response = $newCake->placeOrder();

    // Output the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>