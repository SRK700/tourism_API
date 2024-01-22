<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: *");
include './conn.php';
error_log('Method: ' . $method);
error_log('Table: ' . $table);
error_log('Key: ' . $key);
$method = $_SERVER['REQUEST_METHOD'];
$request_path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
$request = explode('/', trim($request_path, '/'));
$input = json_decode(file_get_contents('php://input'), true);

$table = preg_replace('/[^a-z0-9_]+/i', '', array_shift($request));
$key = array_shift($request);

switch ($method) {
    case 'GET':
        handleGetRequest($conn, $table, $key);
        break;
    case 'POST':
        handlePostRequest($conn, $table, $input);
        break;
    case 'PUT':
        handlePutRequest($conn, $table, $key, $input);
        break;
    case 'DELETE':
        handleDeleteRequest($conn, $table, $key);
        break;
    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(array('message' => 'Method not allowed.'));
        break;
}

function handleGetRequest($conn, $table, $key) {
    $table = mysqli_real_escape_string($conn, $table);
    $key = mysqli_real_escape_string($conn, $key);

    // Check if $table is empty or invalid
    if (empty($table)) {
        http_response_code(400); // Bad Request
        echo json_encode(array('message' => 'Invalid table name.'));
        return;
    }

    $sql = "SELECT * FROM $table";

    if ($key !== '') {
        $sql .= " WHERE place_id = $key";
    }

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error fetching data from database. Error: ' . mysqli_error($conn)));
    } else {
        $data = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        header("Content-Type: application/json");
        echo json_encode($data);
    }
}

function handlePostRequest($conn, $table, $input) {
    $table = mysqli_real_escape_string($conn, $table);

    $columns = implode(", ", array_keys($input));
    $values = implode("', '", array_map('mysqli_real_escape_string', array_values($input)));

    $sql = "INSERT INTO $table ($columns) VALUES ('$values')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo json_encode(array('message' => 'Data inserted successfully.'));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error inserting data into database. Error: ' . mysqli_error($conn)));
    }
}

function handlePutRequest($conn, $table, $key, $input) {
    $table = mysqli_real_escape_string($conn, $table);
    $key = mysqli_real_escape_string($conn, $key);

    $set = array();

    foreach ($input as $column => $value) {
        $set[] = "$column = '" . mysqli_real_escape_string($conn, $value) . "'";
    }

    $set = implode(", ", $set);

    $sql = "UPDATE $table SET $set WHERE place_id = $key";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo json_encode(array('message' => 'Data updated successfully.'));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error updating data in database. Error: ' . mysqli_error($conn)));
    }
}

function handleDeleteRequest($conn, $table, $key) {
    $table = mysqli_real_escape_string($conn, $table);
    $key = mysqli_real_escape_string($conn, $key);

    $sql = "DELETE FROM $table WHERE place_id = $key";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo json_encode(array('message' => 'Data deleted successfully.'));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Error deleting data from database. Error: ' . mysqli_error($conn)));
    }
}

mysqli_close($conn);
?>
