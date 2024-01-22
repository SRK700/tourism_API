<?php
header('Access-Control-Allow-Origin: *');
include "./conn.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the request
    $departure_time = isset($_POST['departure_time']) ? $_POST['departure_time'] : '';
    $arrival_time = isset($_POST['arrival_time']) ? $_POST['arrival_time'] : '';
    $place_id_from = isset($_POST['place_id_from']) ? $_POST['place_id_from'] : '';
    $place_id_to = isset($_POST['place_id_to']) ? $_POST['place_id_to'] : '';

    // Insert new record into the "bus_schedule" table
    $sql = "INSERT INTO bus_schedule (departure_time, arrival_time, place_id_from, place_id_to) VALUES ('$departure_time', '$arrival_time', $place_id_from, $place_id_to)";

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
