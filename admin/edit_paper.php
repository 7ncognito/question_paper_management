<?php require_once('../include/Session.php');?>
<?php require_once('../include/Functions.php');?>
<?php echo AdminAreaAccess(); ?>

<?php include('../header.php') ?>

<?php include('admin.header.php') ?>

<div class="container">
    <h2 class="text-center">EDIT PAPER</h2>
    <?php 
        include('../dbcon.php');
        if(isset($_POST['submit'])) {
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $Department = mysqli_real_escape_string($conn, $_POST['Department']);
            $Subject = mysqli_real_escape_string($conn, $_POST['Subject']);
            $Semester = mysqli_real_escape_string($conn, $_POST['Semester']);
            $year = mysqli_real_escape_string($conn, $_POST['year']);
            $pdf_file = mysqli_real_escape_string($conn, $_POST['pdf_file']);

            $sql = "UPDATE paper SET Department='$Department', Subject='$Subject', Semester='$Semester', year='$year', pdf_file='$pdf_file' WHERE id='$id'";
            if(mysqli_query($conn, $sql)) {
                $_SESSION["SuccessMessage"]="Paper updated successfully!";
                Redirect_to("show.php");
            } else {
                $_SESSION["ErrorMessage"]="Something went wrong. Please try again!";
            }
        }

        if(isset($_GET['id'])){
            $id = mysqli_real_escape_string($conn, $_GET['id']);
            $sql = "SELECT * FROM paper WHERE id='$id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
        } else {
            Redirect_to("show.php");
        }
    ?>

    <form action="edit_paper.php" method="post">
        <div class="form-group">
            <label for="Department">Department:</label>
            <input type="text" class="form-control" id="Department" placeholder="Enter Department" name="Department" value="<?php echo $row['Department'] ?>" readonly>
        </div>
        <div class="form-group">
            <label for="Subject">Subject:</label>
            <input type="text" class="form-control" id="Subject" placeholder="Enter Subject" name="Subject" value="<?php echo $row['Subject'] ?>" readonly>
        </div>
        <div class="form-group">
            <label for="Semester">Semester:</label>
            <input type="text" class="form-control" id="Semester" placeholder="Enter Semester" name="Semester" value="<?php echo $row['Semester'] ?>" required>
        </div>
        <div class="form-group">
            <label for="year">Year:</label>
            <input type="text" class="form-control" id="year" placeholder="Enter Year" name="year" value="<?php echo $row['year'] ?>" required>
        </div>
        <div class="form-group">
            <label for="pdf_file">PDF File:</label>
            <input type="file" class="form-control" id="pdf_file" name="pdf_file">
        </div>
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
        <button type="submit" class="btn btn-primary" name="submit">Update</button>
    </form>
</div>

<?php include('../footer.php') ?>
