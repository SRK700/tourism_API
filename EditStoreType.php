<?php
header('Access-Control-Allow-Origin: *');
include "./conn.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the request
    $type_id = isset($_POST['type_id']) ? $_POST['type_id'] : '';
    $type_name = isset($_POST['type_name']) ? $_POST['type_name'] : '';

    // Update record in the "store_types" table
    $sql = "UPDATE store_types SET type_name = '$type_name' WHERE type_id = '$type_id'";

    try {
        // Execute the query
        $result = $conn->query($sql);

        if ($result) {
            // Send success response code
            http_response_code(200);
            echo json_encode(array("status" => "success", "message" => "Data updated successfully"));
        } else {
            // Send error response code
            http_response_code(500);
            echo json_encode(array("status" => "error", "message" => "Error updating data in the database"));
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
