<?php

use DataSource\DataSource;


class HandleCart
{
    private $conn;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->conn = new DataSource();
    }

    function addToCart($data)
    {
        // session_start();
        // $userID = $_SESSION['userID'];
        // Check if cakeID already exists in cart table
        $query = 'SELECT * FROM cart WHERE CakeID = ? AND userID';
        $paramType = 's';
        $paramValue = array($data['cakeID']);
        $result = $this->conn->select($query, $paramType, $paramValue);

        // If cartId exists, update quantity and price and return success message
        if (!empty($result)) {
            $updatedQuantity = $result[0]['quantity'] + 1;
            $updatedPrice = $result[0]['price'] + $data['price'];
            $query = 'UPDATE cart SET quantity = ?, total = ? WHERE CakeID = ?';
            $paramType = 'sss';
            $paramValue = array($updatedQuantity, $updatedPrice, $data['cakeID']);
            $this->conn->update($query, $paramType, $paramValue);
            $response = array("message" => "Cart updated successfully.");
            // Reload the current page
            return $response;

        }

        // If donation_id does not exist, insert new record and return success message
        else {
            $query = 'INSERT INTO cart (CakeID,userID,CakeName,price,quantity,total) VALUES(?,?,?,?,?,?)';
            $paramType = 'sissss';
            $paramValue = array(
                $data['cakeID'],
                $data['userID'],
                $data['cakeName'],
                $data['price'],
                1,
                $data['price']
            );
            $cartID = $this->conn->insert($query, $paramType, $paramValue);
            $response = array("message" => "Cake added to cart successfully.");
            // Reload the current page
            return $response;
        }
    }

    function delteItem($data)
    {

        $query = 'DELETE FROM cart WHERE cartID = ?';
        $paramValue = array($data['cartID']);
        $paramType = 'i';
        $id = $this->conn->delete($query, $paramType, $paramValue);
        $response = array('message' => 'cart item has been removed');
        return $response;
    }


}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    print_r($data);

    if ($data['method'] === 'add') {
        $cartItem = new HandleCart;
        $cartItem->addToCart($data);

    } elseif ($data['method'] === 'remove') {
        echo 'delete call';
        $del = new HandleCart;
        $del->delteItem($data);

    } else {
        // Handle other cases
    }
}