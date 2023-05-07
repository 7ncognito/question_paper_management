<?php
include('dbcon.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $queries = $_POST['queries'];

    // Do some validation on the input data
    if(empty($email) || empty($queries)){
        // If either field is empty, show an error message
        echo "Please fill out all fields.";
        header('dashboard.php');
    } else {
        // If both fields are filled out, save the data to the database
        $sql = "INSERT INTO queries (email, queries) VALUES ('$email', '$queries')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Thank you for submitting your query.')</script>";
              header('Location: dashboard.php');
        } else {
            echo "Sorry, there was a problem submitting your query. Please try again later.";
        }
    }
}

$conn->close();
