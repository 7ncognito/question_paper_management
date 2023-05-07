<?php
// Connect to the database
include('../dbcon.php');
require_once('../include/Session.php');
require_once('../include/Functions.php');
echo AdminAreaAccess();
// Get the list of courses
$courses = mysqli_query($conn, 'SELECT * FROM course');

// Handle form submission
if (isset($_POST['submit'])) {
  $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);
  $department_id = mysqli_real_escape_string($conn, $_POST['department_id']);
  $subject = mysqli_real_escape_string($conn, $_POST['subject']);
  $semester = mysqli_real_escape_string($conn, $_POST['semester']);
  $sql = "INSERT INTO subjects (course_id, department_id, subject_name, semester) VALUES ('$course_id', '$department_id', '$subject', '$semester')";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $_SESSION['SuccessMessage'] = "Subject added successfully!";
    header("Location: add_subject.php");
    exit();
  } else {
    $_SESSION['ErrorMessage'] = "Error: " . $sql . "
" . mysqli_error($conn);
    header("Location: add_subject.php");
    exit();
  }
}

include('../header.php');
include('admin.header.php');
?>
<div class="container jumbotron">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2 class="text-center">ADD NEW SUBJECT</h2>
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
<form method="post">
  <label for="course">Select a course:</label>
  <select name="course_id" id="course" class="form-control" onchange="this.form.submit()">
    <option value="">--Select a course--</option>
    <?php while ($course = mysqli_fetch_assoc($courses)) { ?>
      <option value="<?php echo $course['id']; ?>" <?php if(isset($_POST['course_id']) && $_POST['course_id'] == $course['id']) echo 'selected'; ?>><?php echo $course['course']; ?></option>
    <?php } ?>
  </select>

  <?php if (isset($_POST['course_id'])) {
    $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);
    // Get the list of departments for the selected course
    $departments = mysqli_query($conn, "SELECT * FROM departments WHERE course_id = $course_id");
  ?>

    <label for="department">Select a department:</label>
    <select class="form-control" name="department_id" id="department">
      <option value="">--Select a department--</option>
      <?php while ($department = mysqli_fetch_assoc($departments)) { ?>
        <option value="<?php echo $department['id']; ?>"><?php echo $department['department_name']; ?></option>
      <?php } ?>
    </select>

    <label for="subject">Subject Name:</label>
    <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject Name" required>

    <label for="semester">Semester:</label>
    <input type="number" class="form-control" id="semester" name="semester" placeholder="Enter Semester" required>


        <br><br>
    <button type="submit" name="submit" class="btn btn-success btn-lg">ADD SUBJECT</button>
  <?php } ?>


</form>
  </div>
    </div>
</div>
