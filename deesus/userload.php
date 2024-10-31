<?php
header("Content-Type: application/json; charset=UTF-8");

include "conn.php"; 
// Query to fetch user information
$sql = "SELECT id, name, email, calls FROM users"; 
$result = $conn->query($sql);

$userList = array();

if ($result->num_rows > 0) {
    // Fetch each user and add to userList
    while($row = $result->fetch_assoc()) {
        $userList[] = array(
            "id" => $row["id"],
            "name" => $row["name"],
            "email" => $row["email"],
            "calls" => $row["calls"] 
        );
    }
}

// Output user list as JSON
echo json_encode($userList);

// Close the connection
$conn->close();
?>
