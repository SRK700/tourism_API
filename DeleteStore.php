<?php
header('Access-Control-Allow-Origin: *');
include "./conn.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get store_id from POST data
    $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : '';

    // SQL query to delete a record based on store_id
    $sql = "DELETE FROM stores WHERE store_id = $store_id";

    try {
        // Execute the query
        $result = $conn->query($sql);

        if ($result) {
            // If successful, return success message
            http_response_code(200);
            echo json_encode(array("status" => "success", "message" => "Data deleted successfully"));
        } else {
            // If no rows affected, return error message
            http_response_code(500);
            echo json_encode(array("status" => "error", "message" => "Error deleting data from the database"));
        }
    } catch (Exception $e) {
        // If an error occurred, return error message
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
