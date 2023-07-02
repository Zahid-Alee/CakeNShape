<?php

use DataSource\DataSource;


class HandleCategories
{
    private $conn;

    function __construct()
    {

        require_once __DIR__ . '/../lib/DataSource.php';
        $this->conn = new DataSource();
    }

    function insertCat($data)
    {
        $uploadDir = '../uploads/cakes-categories/';

        if (isset($_FILES['Image'])) {
            $image = $_FILES['Image'];

            // Generate a unique name for the uploaded image
            $imageName = uniqid() . '_' . $image['name'];
            $imagePath = $uploadDir . $imageName;

            // Move the uploaded image to the desired directory
            if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                // Image uploaded successfully
                $query = 'INSERT INTO categories (CategoryID , CategoryName, Image) VALUES (?, ?, ?)';
                $paramType = 'sss';
                $paramValue = array(
                    $data['CategoryID'],
                    $data['CategoryName'],
                    $imagePath
                );

                $catID = $this->conn->insert($query, $paramType, $paramValue);

                if (!empty($catID)) {
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
    function updateCat()
    {
        $uploadDir = '../uploads/cakes-categories/';

        $query = '';
        $paramType = '';
        $paramValue = array();

        if ($_FILES['Image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['Image'];

            echo 'Image is set and updating image also';

            // Generate a unique name for the uploaded image
            $imageName = uniqid() . '_' . $image['name'];
            $imagePath = $uploadDir . $imageName;

            if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                $query = "UPDATE categories SET CategoryName = ?, Image = ? WHERE CategoryID = ?";
                $paramType = "ssi";
                $paramValue = array(
                    $_POST['CategoryName'],
                    $imagePath,
                    $_POST['CategoryID']
                );
            }
        } else {
            $query = "UPDATE categories SET CategoryName = ? WHERE CategoryID = ?";
            $paramType = "si";
            $paramValue = array(
                $_POST['CategoryName'],
                $_POST['CategoryID']
            );
        }

        $catID = $this->conn->update($query, $paramType, $paramValue);

        if (!empty($catID)) {
            $response = array(
                "status" => "success",
                "message" => "Updated successfully"
            );
        } else {
            $response = array(
                "status" => "error",
                "message" => "Error occurred during updation"
            );
        }

        return $response;
    }

    function deleteCat($id)
    {
        // Check if record with given stock_id exists in blood_stock table
        $query = "DELETE FROM categories WHERE CategoryID  = ?";

        $paramType = "s";
        $paramValue = array($id);
        $delID = $this->conn->select($query, $paramType, $paramValue);

        // If record exists, delete it and return success message
        if (!empty($delID)) {
            $response = array(
                "status" => "success",
                "message" => "Record deleted successfully."
            );
        }
        // If record does not exist, return error message
        else {
            $response = array(
                "status" => "error",
                "message" => "error deletig record."
            );
        }

        return $response;
    }
}

if ($_POST) {
    $data = $_POST;
    $handleCat =
        new HandleCategories;
    // $data = $_POST;
    print_r($data);
    if ($_POST['method'] == 'insert') {
        echo 'insert call';
        $handleCat->insertCat($data);
    } elseif ($data['method'] == 'delete') {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        echo 'delte call';
        // $handleCat->deleteCat($data);
        $handleCat->conn->execute("SET FOREIGN_KEY_CHECKS = 0;");
        $handleCat->deleteCat($data);
        $handleCat->conn->execute("SET FOREIGN_KEY_CHECKS = 1;");


    } elseif ($data['method'] == 'update') {

        // print($data);
        $handleCat->updateCat();
    }
}
;