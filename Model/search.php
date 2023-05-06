<?php
// Connect to database
require_once __DIR__ . '../../lib/DataSource.php';
use DataSource\DataSource;

class BloodManagement
{
    private $conn;

    function __construct()
    {
        $this->conn = (new DataSource())->getConnection();
    }

    function search(){
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        // Get search term from query string
        $searchTerm = mysqli_real_escape_string($this->conn, $_GET['q']);
        $searchType = mysqli_real_escape_string($this->conn, $_GET['type']);
        
        // Query database for search results based on selected option
        if($searchType === 'blood-group') {
            $sql = "SELECT * FROM blood_donation WHERE blood_group LIKE '%$searchTerm%'";
        } else if($searchType === 'location') {
            $sql = "SELECT * FROM blood_donation WHERE location LIKE '%$searchTerm%'";
        } else {
            $sql = "SELECT * FROM blood_donation WHERE blood_group LIKE '%$searchTerm%' OR location LIKE '%$searchTerm%'";
        }
        $result = mysqli_query($this->conn, $sql);
    
        // Check if any results were found
        if (mysqli_num_rows($result) > 0) {
            // Build array of search results
            $results = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $results[] = array(
                    'blood_group' => $row['blood_group'],
                    'location' => $row['location'],
                    'date' => $row['date']
                );
            }
        
            // Return search results as JSON
            header('Content-Type: application/json');
            echo json_encode($results);
        } else {
            // Return empty array if no results were found
            header('Content-Type: application/json');
            echo json_encode(array());
        }
    }
    
}

// Create instance of BloodManagement
$bloodManagement = new BloodManagement();

// Call search method
$bloodManagement->search();
?>
