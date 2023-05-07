<?php 
require_once('../include/Session.php');
require_once('../include/Functions.php');
echo AdminAreaAccess();

include('../dbcon.php');
$search_term = '';
if(isset($_POST['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_POST['search']);
    $sql = "SELECT * FROM student WHERE rollno LIKE '%$search_term%' OR name LIKE '%$search_term%' OR email LIKE '%$search_term%' OR pcontact LIKE '%$search_term%' ";
} else {
    $sql = "SELECT * FROM student";
}
$result = mysqli_query($conn, $sql);
?>

<?php include('../header.php') ?>

<?php include('admin.header.php') ?>

<div class="container">
    <h2 class="text-center">MANAGE USERS</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form-group">
            <label for="search">Search by Name, Roll No, Department, Parent Phone No, or Session:</label>
            <input type="text" class="form-control" id="search" placeholder="Enter search term" name="search" value="<?php echo $search_term; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <hr>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Reg No.</th>
                <th>Full Name</th>
                <th> Phone No.</th>
                <th>email</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['rollno']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['pcontact']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td><img src='../databaseimg/".$row['image']."' alt='img' height='100px' width='100px'></td>";

                echo "<td><a href='updatestudent.php?sid=".$row['id']."' class='btn btn-info btn-xs'>Edit</a> <a href='deleterecord.php?sid=".$row['id']."' class='btn btn-danger btn-xs'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include('../footer.php') ?>
