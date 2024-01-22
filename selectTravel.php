<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");

// Include database connection
include './conn.php';

// Select travel data from the tourist_places table
$sql = "SELECT * FROM tourist_places";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Fetch data as an associative array
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Send the JSON response
    echo json_encode($data);
} else {
    // If the query fails, send an error response
    http_response_code(500); // Internal Server Error
    echo json_encode(array('message' => 'Error fetching travel data from the database.'));
}

// Close the database connection
mysqli_close($conn);
?>
