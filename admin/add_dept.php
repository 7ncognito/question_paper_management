<?php
require_once('../include/Session.php');
require_once('../include/Functions.php');
echo AdminAreaAccess();

if (isset($_POST['submit'])) {
    include('../dbcon.php');
    $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);

    $sql = "INSERT INTO departments (course_id,department_name) VALUES ('$course_id','$department')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['SuccessMessage'] = "Department added successfully!";
        header("Location: add_dept.php");
        exit();
    } else {
        $_SESSION['ErrorMessage'] = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

include('../header.php');
include('admin.header.php');
?>

<div class="container jumbotron">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2 class="text-center">ADD NEW DEPARTMENT</h2>
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <div class="form-group">
                    <label for="course">Course :</label>
                   <select class="form-control" name="course_id" id="course_id" required>
    <?php
        include('../dbcon.php');
        $sql = "SELECT * FROM course ";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='".$row['id']."'>".$row['course']."</option>";
        }
    ?>
</select>

                    <label for="department">Department Name:</label>
                    <input type="text" class="form-control" id="department" name="department" placeholder="Enter Department Name" required>
                </div>
                <button type="submit" name="submit" class="btn btn-success btn-lg">ADD DEPARTMENT</button>
            </form>
        </div>
    </div>
</div>

        </div>
    </div>
</div>
<style>
    .table-container {
         margin-left: 15%;
  display: flex;
  justify-content: space-between;
  width: 70%;

    }
    
    .table-container .table {
        width: 48%;
    }
    
    .table-container .table h2 {
        text-align: center;
    }
    
    .table-container .table table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-container .table td,
    .table-container .table th {
        border: 1px solid black;
        padding: 8px;
    }
    
    .table-container .table th {
        background-color: lightblue;
    }
</style>
<div class="table-container">
    <?php
    include('../dbcon.php');
    $sql = "SELECT * FROM course";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $course_id = $row['id'];
        $course_name = $row['course'];

        $sql2 = "SELECT * FROM departments WHERE course_id='$course_id'";
        $result2 = mysqli_query($conn, $sql2);
        ?>
        <div class="table">
            <h2><?php echo $course_name; ?> Courses</h2>
            <table>
                <tr><th>Department Name</th></tr>
                <?php while ($row2 = mysqli_fetch_assoc($result2)) { ?>
                    <tr><td><?php echo $row2['department_name']; ?></td></tr>
                <?php } ?>
            </table>
        </div>
    <?php } ?>
</div>



