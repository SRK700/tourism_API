<?php
header('Access-Control-Allow-Origin: *');
include "./conn.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the request
    $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : null;
    $store_name = isset($_POST['store_name']) ? $_POST['store_name'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';

    // Insert new record into the "stores" table
    $sql = "INSERT INTO stores (store_id, store_name, location) VALUES ('$store_id', '$store_name', '$location')";

    try {
        // Execute the query
        $result = $conn->query($sql);

        if ($result) {
            // Send success response code
            http_response_code(200);
            echo json_encode(array("status" => "success", "message" => "Data inserted successfully"));
        } else {
            // Send error response code
            http_response_code(500);
            echo json_encode(array("status" => "error", "message" => "Error inserting data into the database"));
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
