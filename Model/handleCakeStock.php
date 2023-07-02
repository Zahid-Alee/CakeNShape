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
        echo "call for updation  ";

        $uploadDir = '../uploads/cakes/';
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

                $query = "UPDATE cakes SET CakeName = ?, CategoryID = ?, MaterialUsed = ?, Flavor = ?, Weight = ?, Quantity = ? , Price = ? , Image = ? WHERE CakeID = ? ";
                $paramType = "ssssiiiss";
                $paramValue = array(
                    $_POST['CakeName'],
                    $_POST['CategoryID'],
                    $_POST['MaterialUsed'],
                    $_POST['Flavor'],
                    $_POST['Weight'],
                    $_POST['Quantity'],
                    $_POST['Price'],
                    $imagePath,
                    $_POST['CakeID']
                );
            }
        } else {

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
                $_POST['CakeID']
            );
        }

        $CakeID = $this->conn->update($query, $paramType, $paramValue);
        if (!empty($CakeID)) {
            $response = array(
                "status" => "success",
                "message" => "Updated successfully"
            );
        } else {
            $response = array(
                "status" => "error",
                "message" => "Update failed"
            );
        }
        return $response;
    }

    function deleteCake($cakeID)
    {


        $query = "SELECT * FROM cakes WHERE CakeID = ?";
        $paramType = "s";
        $paramValue = array($cakeID);
        $result = $this->conn->select($query, $paramType, $paramValue);

        if (!empty($result)) {

            $CakeID = $result[0]['CakeID'];

            $query = "DELETE FROM cakes WHERE CakeID = ?";
            $paramType = "s";
            $paramValue = array($CakeID);
            $this->conn->delete($query, $paramType, $paramValue);

            $response = array(
                "status" => "success",
                "message" => "Record deleted successfully."
            );
        } else {
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
    $handleStock =
        new HandleCakeStock;
    print_r($data);
    if ($_POST['method'] == 'update') {
        echo 'updation call';

        $handleStock->updateCake();
    } elseif ($_POST['method'] == 'delete') {

        // $handleStock->conn->execute("SET FOREIGN_KEY_CHECKS = 0;");

        $handleStock->deleteCake($_POST["CakeID"]);

        // $handleStock->conn->execute("SET FOREIGN_KEY_CHECKS = 1;");
    } else {

    }

}
;