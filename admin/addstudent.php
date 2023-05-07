<?php require_once('../include/Session.php');?>
<?php require_once('../include/Functions.php');?>
<?php echo AdminAreaAccess(); ?>

<?php include('../header.php') ?>

<?php include('admin.header.php') ?>

<div class="container jumbotron">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h2 class="text-center">INSERT STUDENT DETAIL</h2>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
				  <div class="form-group">
				      Reg No.:<input type="text" class="form-control" name="roll" placeholder="Enter Roll No." >
				  </div>
				  <div class="form-group">
				    
				    Full Name:<input type="text" class="form-control" name="fullname" placeholder="full name" required>
				  </div>
				  <div class="form-group">
					<label for="Department">Department</label>
					<select class="form-control" id="Department" placeholder="Department" name="Department" required>
						<?php
        include('../dbcon.php');
        $sql = "SELECT * FROM Departments";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='".$row['department_name']."'>".$row['department_name']."</option>";
        }
        ?>
					</select>
				</div>
				  <div class="form-group">
				    
				    Phone No.:<input type="text" class="form-control" name="pphone" placeholder="Enter Phone No." required>
				  </div>
				  <div class="form-group">
				    
				    Session<input type="text" class="form-control" name="session" placeholder="Enter Session" required>
				  </div>

				   <div class="form-group">
				    
				    Image:<input type="file" class="form-control" name="simg" required>
				  </div>

				  <button type="submit" name="submit" class="btn btn-success btn-lg">INSERT</button>
			</form>
		</div>
	</div>
</div>

<?php include('../footer.php') ?>

<?php 

	if (isset($_POST['submit'])) {
		if (!empty($_POST['roll']) && !empty($_POST['fullname'])) {
		
			include ('../dbcon.php');
			$roll=$_POST['roll'];
			$name=$_POST['name'];
			$Department=$_POST['Department'];
			$pphone=$_POST['pphone'];
			$session=$_POST['session'];
			include('ImageUpload.php');

			// check if the details already exist in the database
			$sql = "SELECT * FROM `student` WHERE `rollno`='$roll' AND `name`='$name' AND `Department`='$Department' AND `pcontact`='$pphone' AND `session`='$session'";
			$result = mysqli_query($conn, $sql);
			$count = mysqli_num_rows($result);

			if ($count > 0) {
				// details already exist
				?>
				<script>
					alert("Details already exist in the database.");
				</script>
				<?php
			} else {
				// details do not exist, insert the data into the database
				$sql = "INSERT INTO `student`( `rollno`, `name`, `Department`, `pcontact`, `session`,`image`) VALUES ('$roll','$name','$Department','$pphone','$session','$imgName')";
				$run = mysqli_query($conn,$sql);

				if ($run == true) {
					?>
					<script>
						alert("Data Inserted Successfully");
						header("Location: admindash.php");
					</script>
					<?php
				} else {
					echo "Error : ".$sql."<br>". mysqli_error($conn); 
				}
			}
		} else {
				?>
				<script>
					alert("Please insert atleast roll no. and fullname");
				</script>
				<?php
		}
	}

 ?>








