<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php require_once('../include/Session.php');?>
<?php require_once('../include/Functions.php');?>
<?php echo AdminAreaAccess(); ?>

<?php include('../header.php') ?>
<?php

include('../dbcon.php');
// Select all the queries from the database
$sql = "SELECT * FROM queries";
$result = $conn->query($sql);

// Check if there are any queries to display
if ($result->num_rows > 0) {
    // Loop through each query and display it on the page
    while($row = $result->fetch_assoc()) {
        echo "<h3>Query " . $row["id"] . "</h3>";
        echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
        echo "<p><strong>Query:</strong> " . $row["queries"] . "</p>";
    }
} else {
    // If there are no queries to display, show a message
    echo "No queries found.";
}

$conn->close();

?>
