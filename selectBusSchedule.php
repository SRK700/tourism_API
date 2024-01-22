<?php
header('Access-Control-Allow-Origin: *');
include "./conn.php";

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Select all records from the "bus_schedule" table
    $sql = "SELECT * FROM transportation_schedule";

    try {
        // Execute the query
        $result = $conn->query($sql);

        if ($result) {
            // Fetch all rows as an associative array
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            // Send success response code and data as JSON
            http_response_code(200);
            echo json_encode($rows);
        } else {
            // Send error response code
            http_response_code(500);
            echo json_encode(array("status" => "error", "message" => "Error fetching data from the database"));
        }
    } catch (Exception $e) {
        // If an error occurred, send error response
        http_response_code(500);
        echo json_encode(array("status" => "error", "message" => "Error: " . $e->getMessage()));
    }
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("status" => "error", "message" => "Invalid Request Method"));
}

// Close the database connection
$conn->close();
?>
