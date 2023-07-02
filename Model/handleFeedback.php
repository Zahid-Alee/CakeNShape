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
        print_r($data);
        echo 'hello feedback insertion';
        $feedbackID = uniqid('feedback-');
        // echo $data['email'];


        // Insert record into the feedback table
        $query = "INSERT INTO feedback (FeedbackID, Name, Email, FeedbackText) VALUES (?, ?, ?, ?)";
        $paramType = "ssss";
        $paramValue = array($feedbackID, $data['name'], $data['email'], $data['message']);
        $feedID = $this->conn->insert($query, $paramType, $paramValue);

        if (!empty($feedID)) {
            $response = array(
                "status" => "success",
                "message" => "Feedback added successfully."
            );
        } else {
            $response = array(
                "status" => "error",
                "message" => "There was an error inserting feedback."
            );
        }

        return $response;
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    // print_r($_POST);
    $feed = new HandleFeedback;
    $response = $feed->insertFeedback($data);

    echo json_encode($response);
}