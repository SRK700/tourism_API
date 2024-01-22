<?php
header('Access-Control-Allow-Origin: *');
include "./conn.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the request
    $place_id = isset($_POST['place_id']) ? $_POST['place_id'] : '';
    $place_name = isset($_POST['place_name']) ? $_POST['place_name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '';
    $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '';

    // Insert new record into the tourist_places table
    $sqlInsert = "INSERT INTO tourist_places (place_id, place_name, description, latitude, longitude)
                  VALUES ('$place_id', '$place_name', '$description', '$latitude', '$longitude')";
    $resultInsert = mysqli_query($conn, $sqlInsert);

    if ($resultInsert) {
        // Send success response code
        http_response_code(200);
        echo json_encode(array("message" => "Data inserted successfully"));
    } else {
        // Send error response code
        http_response_code(500);
        echo json_encode(array("message" => "Error inserting data into the database"));
    }
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Invalid Request Method"));
}

// Close the database connection
mysqli_close($conn);
?>
