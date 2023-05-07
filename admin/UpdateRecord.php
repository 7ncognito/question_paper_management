<?php require_once('../include/Session.php');?>
<?php require_once('../include/Functions.php');?>
<?php echo AdminAreaAccess(); ?>

<?php 

	include('../dbcon.php');
	$update_record= $_GET['Update'];
	$sql = "select * from student where id = '$update_record'";
	$result = mysqli_query($conn,$sql);

	while ($data_row = mysqli_fetch_assoc($result)) {
		$update_id = $data_row['id']; 
		$Roll = $data_row['rollno'];
		$Name = $data_row['name'];
		$Department = $data_row['Department'];
		$Pcontact = $data_row['pcontact'];
		$session = $data_row['session'];

	}

 ?>

<?php include('../header.php') ?>

<?php include('admin.header.php') ?>

<div class="container jumbotron">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h2 class="text-center">UPDATE STUDENT DETAIL</h2>
			<form action="UpdateRecord.php?update_id=<?php echo $update_id;?>" method="post" enctype="multipart/form-data">
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
				    
				    Phone No.:<input type="text" class="form-control" name="pphone" placeholder="Enter Parent Phone No." required>
				  </div>
				  <div class="form-group">
				    
				    Session<input type="number" class="form-control" name="session" placeholder="Enter Session" required>
				  </div>


				  <button type="submit" name="submit" class="btn btn-success btn-lg">UPDATE</button>
			</form>
		</div>
	</div>
</div>

<?php include('../footer.php') ?>


<?php 
//This php code block is for editing the data that we got after clicking on update button
	if (isset($_POST['submit'])) {
		if (!empty($_POST['roll']) && !empty($_POST['fullname'])) {
		
			include ('../dbcon.php');
			$id = $_GET['update_id'];
			$roll=$_POST['roll'];
			$name=$_POST['fullname'];
			$Department=$_POST['Department'];
			$pphone=$_POST['pphone'];
			$session=$_POST['session'];

			$sql = "UPDATE student SET rollno = '$roll', name = '$name', Department='$Department', pcontact = '$pphone', session = '$session' WHERE id = '$id'";

			$Execute = mysqli_query($conn,$sql);

			if ($Execute) {
				 $_SESSION['SuccessMessage'] = " Data Updated Successfully";
                Redirect_to("updatestudent.php");

			}


		}

	}

 ?>
