<?php 
require_once('../include/Session.php');
require_once('../include/Functions.php');
echo AdminAreaAccess();

include('../dbcon.php');

if (isset($_GET['sid'])) {
    $delete_id = $_GET['sid'];
    $sql = "SELECT image FROM student WHERE id = $delete_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $profile_pic = $row['image'];
    
    $sql = "DELETE FROM student WHERE id = $delete_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        unlink("../databaseimg/".$profile_pic);
        $_SESSION['SuccessMessage'] = "Record deleted successfully";
    } else {
        $_SESSION['ErrorMessage'] = "Failed to delete record";
    }
}

header("Location: managestudents.php");
exit;
?>
