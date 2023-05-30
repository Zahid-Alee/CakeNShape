<?php

use DataSource\DataSource;


class HandleNotifications
{
    private $conn;

    function __construct()
    {

        require_once __DIR__ . '/../lib/DataSource.php';
        $this->conn = new DataSource();
    }    
    function delNoti($notID)
    {

            // Delete record from blood_stock table
            $query = "DELETE FROM user_notifications WHERE notID = ?";
            $paramType = "s";
            $paramValue = array($notID);
            $this->conn->delete($query, $paramType, $paramValue);

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
    $del= new HandleNotifications;
   $response= $del->delNoti($data);
    
    echo json_encode($response);

}
;