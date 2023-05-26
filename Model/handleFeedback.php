<?php

use DataSource\DataSource;


class HandleFeedback
{
    private $conn;

    function __construct()
    {

        require_once __DIR__ . '/../lib/DataSource.php';
        $this->conn = new DataSource();
    }
    function insertFeedback($data)
    {

        // Delete record from blood_stock table
        $query = "INSERT INTO  feedback (userID,FeedbackText) VALUE(?,?) ";
        $paramType = "is";
        $paramValue = array($data['userID'], $data['message']);
        $feedID = $this->conn->insert($query, $paramType, $paramValue);

        if (!empty($feedID)) {
            $response = array(
                "status" => "success",
                "message" => "Feedback added successfully."
            );
        } else {
            $response = array(
                "status" => "error",
                "message" => "There was and error inserting Feedback."
            );
        }

        return $response;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    print_r($data);
      $feed = new HandleFeedback;
    $response = $feed->insertFeedback($data);

    echo json_encode($response);
}

  


