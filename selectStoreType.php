<?php
header('Access-Control-Allow-Origin: *');
include "./conn.php";

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Select all records from the "store_types" table
    $sql = "SELECT * FROM store_types";
    
    // Execute the query
    $result = $conn->query($sql);

    if ($result) {
        // Fetch all rows as associative arrays
        $storeTypes = $result->fetch_all(MYSQLI_ASSOC);

        // Send success response code and JSON data
        http_response_code(200);
        echo json_encode($storeTypes);
    } else {
        // Send error response code
        http_response_code(500);
        echo json_encode(array("message" => "Error fetching data from the database"));
    }
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Invalid Request Method"));
}

// Close the database connection
$conn->close();
?>
