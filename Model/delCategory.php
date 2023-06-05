<?php

use DataSource\DataSource;


class DelCategory
{
    private $conn;

    function __construct()
    {

        require_once __DIR__ . '/../lib/DataSource.php';
        $this->conn = new DataSource();
    }


    function delCat($categoryID)
    {
        $query = "SELECT CakeID FROM cakes WHERE CategoryID = ?";
        $paramType = "s";
        $paramValue = array($categoryID); // Replace $categoryID with the actual CategoryID you want to delete
        $cakeIDs = $this->conn->select($query, $paramType, $paramValue);

        if ($cakeIDs) {
            // Delete records from the cart table associated with the retrieved CakeIDs
            $cakeIDsArray = array_column($cakeIDs, 'CakeID');
            $placeholders = rtrim(str_repeat('?,', count($cakeIDsArray)), ',');
            $query = "DELETE FROM cart WHERE CakeID IN ($placeholders)";
            $paramType = str_repeat('s', count($cakeIDsArray));
            $paramValue = $cakeIDsArray;
            $this->conn->delete($query, $paramType, $paramValue);

            // Delete order items associated with the retrieved CakeIDs
            $query = "DELETE FROM order_items WHERE CakeID IN ($placeholders)";
            $paramType = str_repeat('s', count($cakeIDsArray));
            $paramValue = $cakeIDsArray;
            $this->conn->delete($query, $paramType, $paramValue);

            // Delete cakes with the retrieved CakeIDs
            $query = "DELETE FROM cakes WHERE CakeID IN ($placeholders)";
            $paramType = str_repeat('s', count($cakeIDsArray));
            $paramValue = $cakeIDsArray;
            $this->conn->delete($query, $paramType, $paramValue);
        }

        // Delete the category
        $query = "DELETE FROM categories WHERE CategoryID = ?";
        $paramType = "s";
        $paramValue = array($categoryID); // Replace $categoryID with the actual CategoryID you want to delete
        $this->conn->delete($query, $paramType, $paramValue);

        $response = array(
            "status" => "success",
            "message" => "Record deleted successfully."
        );


        $response = array(
            "status" => "success",
            "message" => "Record deleted successfully."
        );





        return $response;
    }



}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    print_r($data);

    $del = new DelCategory;
    $del->delCat($data['id']);

}
;