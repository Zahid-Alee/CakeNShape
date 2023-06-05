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
        $feedbackID = uniqid('feedback-');

        // Insert record into the feedback table
        $query = "INSERT INTO feedback (FeedbackID, email, username, phone, FeedbackText) VALUES (?, ?, ?, ?, ?)";
        $paramType = "sssss";
        $paramValue = array($feedbackID, $data['email'], $data['username'], $data['phone'], $data['message']);
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
    $feed = new HandleFeedback;
    $response = $feed->insertFeedback($data);

    echo json_encode($response);
}
