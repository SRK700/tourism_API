<?php
header('Access-Control-Allow-Origin: *');
include "./conn.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the request
    $type_id = isset($_POST['type_id']) ? $_POST['type_id'] : '';

    // Delete record from the "store_types" table
    $sql = "DELETE FROM store_types WHERE type_id = '$type_id'";

    try {
        // Execute the query
        $result = $conn->query($sql);

        if ($result) {
            // Send success response code
            http_response_code(200);
            echo json_encode(array("status" => "success", "message" => "Data deleted successfully"));
        } else {
            // Send error response code
            http_response_code(500);
            echo json_encode(array("status" => "error", "message" => "Error deleting data from the database"));
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
