<?php
require_once('../include/Session.php');
require_once('../include/Functions.php');
echo AdminAreaAccess();

if(isset($_GET['id'])){
    include('../dbcon.php');
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "DELETE FROM paper WHERE id='$id'";
    if(mysqli_query($conn, $sql)){
        $_SESSION['SuccessMessage'] = "Paper deleted successfully!";
        Redirect_to("show.php.php");
    } else {
        $_SESSION['ErrorMessage'] = "Something went wrong. Please try again!";
        Redirect_to("show.php");
    }
}
?>
