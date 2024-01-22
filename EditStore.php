<?php
header('Access-Control-Allow-Origin: *');
include "./conn.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the request
    $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : '';
    $store_name = isset($_POST['store_name']) ? $_POST['store_name'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';

    // Update record in the "stores" table
    $sql = "UPDATE stores SET store_name = '$store_name', location = '$location' WHERE store_id = $store_id";

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
