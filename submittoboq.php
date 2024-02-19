<?php
header('Content-Type: application/json');
ob_start(); // Start output buffering

error_reporting(E_ALL);
ini_set('display_errors', '1');

$servername = "db4free.net";
$username = "sql12673867";
$password = "023d2f29";
$dbname = "sql12673867";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Delete data code
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the item identifier from the request body
    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body, true);
    $itemNumber = mysqli_real_escape_string($conn, $data['itemNumber']);

    $sql = "DELETE FROM boq WHERE item_number = '$itemNumber'";

  if ($conn->query($sql) === TRUE) {
      echo json_encode(['message' => 'Deleted successfully']);
  } else {
      echo json_encode(['error' => 'Error deleting data from database: ' . $conn->error, 'query' => $sql]);
  }

    exit; // Make sure to exit after handling the deletion
}

// Insert data code
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table_number = mysqli_real_escape_string($conn, $_POST["tableNumber"]);
    $item_number = mysqli_real_escape_string($conn, $_POST["itemNumber"]);
    $item_description = mysqli_real_escape_string($conn, $_POST["itemDescription"]);
    $quantity = intval($_POST["quantity"]);
    $period = intval($_POST["period"]);
    $origin = mysqli_real_escape_string($conn, $_POST["origin"]);
    $business_unit = mysqli_real_escape_string($conn, $_POST["businessUnit"]);
    $unit_type = mysqli_real_escape_string($conn, $_POST["unitType"]);
    $item_type = mysqli_real_escape_string($conn, $_POST["itemType"]);

    $sql = "INSERT INTO boq (table_number, item_number, item_description, quantity, period, origin, business_unit, unit_type, item_type)
            VALUES ('$table_number', '$item_number', '$item_description', $quantity, $period, '$origin', '$business_unit', '$unit_type', '$item_type')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Inserted successfully']);
        // Redirect to index.php after successful insertion
        header("Location: index.php");
        exit; // Make sure to exit after sending the Location header
    } else {
        echo json_encode(['error' => 'Error inserting data into the database: ' . $conn->error, 'query' => $sql]);
    }
}

// Retrieve data code
$sql = "SELECT table_number, item_number, item_description, quantity, period, origin, business_unit, unit_type, item_type FROM boq";
$result = $conn->query($sql);

$data = array(); // Initialize an array to store fetched data

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; // Add each row of data to the array
    }
    echo json_encode($data); // Output the fetched data as JSON
} else {
    echo json_encode("0 results"); // Output "0 results" as JSON
}

$conn->close();
ob_end_flush(); // Flush the output buffer at the end of the script
?>