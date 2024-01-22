<?php
header('Access-Control-Allow-Origin: *');
include "./conn.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get place_id from POST data
    $placeId = isset($_POST['place_id']) ? $_POST['place_id'] : '';

    // SQL query to delete a record based on place_id
    $sql = "DELETE FROM tourist_places WHERE place_id = ?";

    try {
        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Bind the parameter
        $stmt->bind_param('s', $placeId);

        // Execute the query
        $stmt->execute();

        // Check if the query was successful
        if ($stmt->affected_rows > 0) {
            // If successful, return success message
            http_response_code(200);
            echo json_encode(array("status" => "success", "message" => "Data deleted successfully"));
        } else {
            // If no rows affected, return error message
            http_response_code(500);
            echo json_encode(array("status" => "error", "message" => "No records found for deletion"));
        }

        $stmt->close();
    } catch (Exception $e) {
        // If an error occurred, return error message
        http_response_code(500);
        echo json_encode(array("status" => "error", "message" => "Error: " . $e->getMessage()));
    }
} else {
    // If place_id parameter is not set, return error message
    http_response_code(400);
    echo json_encode(array("status" => "error", "message" => "Missing place_id parameter"));
}

// Close the database connection
$conn->close();
?>
