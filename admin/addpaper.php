<?php 
require_once('../include/Session.php');
require_once('../include/Functions.php');
echo AdminAreaAccess();

include('../header.php');
include('admin.header.php');
include('../dbcon.php');

$departments = mysqli_query($conn, 'SELECT * FROM departments');
?>
<div class="container jumbotron">
    <div class="row">
        <a href="show.php">MANAGE UPLOADS</a>
        <div class="col-md-6 col-md-offset-3">
            <h2 class="text-center">ADD PAPERS</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="department">Select a department:</label>
                    <select name="department_id" id="department" class="form-control" onchange="this.form.submit()">
                        <option value="">--Select a department--</option>
                        <?php 
                            // Loop through the departments and display them as options
                            while ($department = mysqli_fetch_assoc($departments)) { 
                        ?>
                            <option value="<?php echo $department['id']; ?>" <?php if(isset($_POST['department_id']) && $_POST['department_id'] == $department['id']) echo 'selected'; ?>><?php echo $department['department_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                            <?php 
                // If a department has been selected, retrieve the list of subjects for that department
                if (isset($_POST['department_id'])) {
                    $department_id = mysqli_real_escape_string($conn, $_POST['department_id']);

                    // Retrieve the list of subjects for the selected department from the database
                    $subjects = mysqli_query($conn, "SELECT * FROM subjects WHERE department_id = $department_id");
            ?>

                <div class="form-group">
                    <label for="subject">Select a subject:</label>
                    <select class="form-control" name="subject_id" id="subject">
                        <option value="">--Select a subject--</option>
                        <?php 
                            // Loop through the subjects and display them as options
                            while ($subject = mysqli_fetch_assoc($subjects)) { 
                        ?>
                            <option value="<?php echo $subject['id']; ?>"><?php echo $subject['subject_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>

          

            <div class="form-group">
                <label for="year">Year of exam</label>
                <input type="text" class="form-control" id="year" name="year" placeholder="Year" required>
            </div>

            <div class="form-group">
                <label for="file">PDF File</label>
                <input type="file" class="form-control" id="file" name="file" required accept=".pdf">
            </div>

            <button type="submit" name="submit" class="btn btn-success btn-lg">INSERT</button>
              <?php } ?>
        </form>
    </div>
</div>

<?php 
include('../footer.php');

if (isset($_POST['submit'])) {
    $department_id = mysqli_real_escape_string($conn, $_POST['department_id']);
    $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
// File upload
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if($imageFileType != "pdf") {
    echo "Sorry, only PDF files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$Department = mysqli_real_escape_string($conn, $_POST['department_id']);
$Subject = mysqli_real_escape_string($conn, $_POST['subject_id']);
$year = mysqli_real_escape_string($conn, $_POST['year']);

$sql = "INSERT INTO `paper`( `Department`, `Subject`, year, `pdf_file`) VALUES ('$Department','$Subject','$year','$target_file')";

$run = mysqli_query($conn, $sql);

if ($run == true) {
    ?>
    <script>
        alert("Data Inserted Successfully");
        window.location.href = "admindash.php";
    </script>
    <?php
} else {
    echo "Error : ".$sql."<br>". mysqli_error($conn); 
}

} else {
?>

<?php 
}
?>
<?php 
include('../footer.php');
?>