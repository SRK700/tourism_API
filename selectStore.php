<?php
header('Access-Control-Allow-Origin: *');
include "./conn.php";

// SQL query to select all data from the "store" table
$sql = "SELECT * FROM stores";

try {
    // Execute the query
    $result = $conn->query($sql);

    if ($result) {
        // Fetch the result as an associative array
        $data = $result->fetch_all(MYSQLI_ASSOC);

        // Send JSON response
        http_response_code(200);
        echo json_encode($data);
    } else {
        // If query fails, send error response
        http_response_code(500);
        echo json_encode(array("status" => "error", "message" => "Error executing query"));
    }
} catch (Exception $e) {
    // If an error occurred, send error response
    http_response_code(500);
    echo json_encode(array("status" => "error", "message" => "Error: " . $e->getMessage()));
}

// Close the database connection
$conn->close();
?>
