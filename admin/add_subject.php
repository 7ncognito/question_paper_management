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
  $year = mysqli_real_escape_string($conn, $_POST['year']);
  $semester = mysqli_real_escape_string($conn, $_POST['semester']);
  $sql = "INSERT INTO subjects (course_id, department_id, subject_name, year, semester) VALUES ('$course_id', '$department_id', '$subject','$year', '$semester')";
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

    <label for="year">Year:</label>
<select id="year" name="year" id="year" class="form-control" onchange="showSemesters()">
  <option value="">--Select Year--</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
</select>

<label for="semester">Semester:</label>
<select id="semester" name="semester" class="form-control" id="semester" required >
  <option value="">--Select Semester--</option>
</select>

<script>
function showSemesters() {
  var year = document.getElementById("year").value;
  var semester = document.getElementById("semester");
  
  // clear existing options
  semester.innerHTML = "";
  
  // add options based on year selection
  if (year == "1") {
    var option1 = document.createElement("option");
    option1.value = "1";
    option1.text = "1";
    semester.add(option1);
    
    var option2 = document.createElement("option");
    option2.value = "2";
    option2.text = "2";
    semester.add(option2);
  } else {
    var option3 = document.createElement("option");
    option3.value = "3";
    option3.text = "3";
    semester.add(option3);
    
    var option4 = document.createElement("option");
    option4.value = "4";
    option4.text = "4";
    semester.add(option4);
  }
}
</script>





        <br><br>
    <button type="submit" name="submit" class="btn btn-success btn-lg">ADD SUBJECT</button>
  <?php } ?>


</form>
  </div>
    </div>
</div>
<div class="table-container">
    <?php
    include('../dbcon.php'); // connect to database
    
    // select all departments
    $sql = "SELECT * FROM departments";
    $result = mysqli_query($conn, $sql);

    // loop through each department
    while ($row = mysqli_fetch_assoc($result)) {
        $department_id = $row['id'];
        $department_name = $row['department_name'];

        // select all subjects for the department
        $sql2 = "SELECT * FROM subjects WHERE department_id='$department_id'";
        $result2 = mysqli_query($conn, $sql2);
        ?>
         <div class="table">
        <h2><?php echo $department_name; ?></h2>
        <?php if (mysqli_num_rows($result2) > 0) { ?>
            <table>
               
                <?php while ($row2 = mysqli_fetch_assoc($result2)) { ?>
                    <tr><td><?php echo $row2['subject_name']; ?>, YEAR <?php echo $row2['year']; ?>, SEM <?php echo $row2['semester'];?></td></tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No subjects added yet.</p>

        <?php } ?>
        </div>
    <?php } ?>

</div>
<style>
   .table-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
}

.table {
  margin: 10px;
  padding: 10px;
  width: 50%;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0px 0px 5px #ccc;
}

.table h2 {
  margin-top: 0;
  font-size: 24px;
  font-weight: bold;
}

.table table {
  border-collapse: collapse;
  width: 100%;
}

.table table th, .table table td {
  border: 1px solid #ccc;
  padding: 8px;
}

.table table th {
  background-color: #f2f2f2;
  font-weight: bold;
  text-align: left;
}

   
</style>


