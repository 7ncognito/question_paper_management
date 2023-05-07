<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('location:login.php');
    exit();
}
include('header.php');
include('dbcon.php');

// Fetch user information from database
$uid = $_SESSION['uid'];
$query = "SELECT * FROM student WHERE id='$uid'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Update user information in database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
 
    $pcontact = $_POST['pcontact'];
    $query = "UPDATE student SET name='$name', pcontact='$pcontact' WHERE id='$uid'";
    mysqli_query($conn, $query);
    header('location:dashboard.php');
}

?>

<div class="jumbotron text-center">
    <h2 style="text-align: center;">
        Question Paper Management System
        <span style="float: right;margin-right: 5%;"><a href="logout.php" class="btn btn-danger">Logout</a></span>
    </h2>

</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Update Details</h3>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $data['name']; ?>">
                </div>
              
                <div class="form-group">
                    <label for="pcontact">Contact:</label>
                    <input type="text" class="form-control" id="pcontact" name="pcontact" value="<?php echo $data['pcontact']; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<style type="text/css">
    h3 {
  font-size: 40px;
  color: #333;
  margin-bottom: 5%;
}

p {
  font-size: 25px;
  color: #666;
  border: 1px solid #ccc;
  padding: 12px;
}

.btn {
  display: inline-block;
  padding: 10px 20px;
  background-color: #f00;
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
}
</style>
