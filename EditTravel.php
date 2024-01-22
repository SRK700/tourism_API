<?php
header('Access-Control-Allow-Origin: *');
include "./conn.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the request
    $placeId = isset($_POST['place_id']) ? $_POST['place_id'] : '';
    $placeName = isset($_POST['place_name']) ? $_POST['place_name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '';
    $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '';

    // Prepare and execute the SQL query
    $sql = "UPDATE tourist_places SET 
            place_name = '$placeName',
            description = '$description',
            latitude = '$latitude',
            longitude = '$longitude'
            WHERE place_id = $placeId";

    $result = mysqli_query($conn, $sql);

    // Check the query result
    if ($result) {
        // Send success response code and message
        http_response_code(200);
        echo json_encode(array("message" => "Data updated successfully"));
    } else {
        // Send error response code and message
        http_response_code(500);
        echo json_encode(array("message" => "Error updating data. " . mysqli_error($conn)));
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(array("message" => "Invalid Request Method"));
}

// Close the database connection
mysqli_close($conn);
?>
