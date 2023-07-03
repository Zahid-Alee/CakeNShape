<?php

use DataSource\DataSource;

class CakeSalesModel
{
    private $conn;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->conn = new DataSource();
    }

    function getCakeSalesData()
    {
        $query = 'SELECT Category, SUM(Quantity) AS TotalQuantity
                  FROM Sales
                  GROUP BY Category';

        $salesData = $this->conn->select($query);

        return $salesData;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $salesModel = new CakeSalesModel();
    $salesData = $salesModel->getCakeSalesData();

    // Output the response as JSON
    header('Content-Type: application/json');
    echo json_encode($salesData);
}