<?php include('dbcon.php'); ?>
<?php include('header.php');?>
<div class="container jumbotron">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h2 class="text-center">INSERT STUDENT DETAIL</h2>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
				  <div class="form-group">
				      Reg No.:<input type="text" class="form-control" name="roll" placeholder="Enter Reg No. if student" notrequired>
				  </div>
				  <div class="form-group">
				    
				    Full Name:<input type="text" class="form-control" name="fullname" placeholder="full name" required>
				  </div>
				 
				  <div class="form-group">
				    
				    contact No.:<input type="text" class="form-control" name="pphone" placeholder="Enter contact No." required>
				  </div>
				  <div class="form-group">
				    
				    email :<input type="email" class="form-control" name="email" placeholder="Enter email_id" required>
				  </div>

				   <div class="form-group">
				    
				    Image:<input type="file" class="form-control" name="simg" >
				  </div>

				  <button type="submit" name="submit" class="btn btn-success btn-lg">INSERT</button>
			</form>
		</div>
	</div>
</div>

<?php include('footer.php') ?>

<?php 
	if (isset($_POST['submit'])) {
		if (!empty($_POST['pphone']) && !empty($_POST['fullname'])) {
			include ('dbcon.php');
			$roll=$_POST['roll'];
			$name=$_POST['fullname'];
			
			$pphone=$_POST['pphone'];
			$email=$_POST['email'];
			include('ImageUpload.php');

			// check if the details already exist in the database
			$sql = "SELECT * FROM `student` WHERE `rollno`='$roll' AND `name`='$name' AND `pcontact`='$pphone' AND `email`='$email'";
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
				$sql = "INSERT INTO `student`( `rollno`, `name`,  `pcontact`, `email`,`image`) VALUES ('$roll','$name','$pphone','$email','$imgName')";
				$run = mysqli_query($conn,$sql);

				if ($run == true) {
					?>
					<script>
						alert("Data Inserted Successfully");
						header('location:dashboard.php')
						
					</script>
					<?php
				} else {
					echo "Error : ".$sql."<br>". mysqli_error($conn); 
					header('location:dashboard.php');
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







