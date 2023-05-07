<?php require_once('../include/Session.php');?>
<?php require_once('../include/Functions.php');?>
<?php echo AdminAreaAccess(); ?>

<?php include('../header.php') ?>

<?php include('admin.header.php') ?>

<div class="container">
    <h2 class="text-center">MANAGE PAPERS</h2>
    <div class="container">
        <h2>Exam Papers</h2>
        <form method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="Search...">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <br>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Department</th>
                    <th>Subject</th>
                    <th>year of exam</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                include('../dbcon.php');
                if(isset($_POST['search'])){
                    $search_term = mysqli_real_escape_string($conn, $_POST['search']);
                    $sql = "SELECT paper.id, departments.department_name, subjects.subject_name, paper.year, paper.pdf_file
                    FROM paper
                    JOIN departments ON paper.Department = departments.id
                    JOIN subjects ON paper.Subject = subjects.id
                    WHERE departments.department_name LIKE '%$search_term%' OR subjects.subject_name LIKE '%$search_term%' OR paper.year LIKE '%$search_term%'";
                } else {
                    $sql = "SELECT paper.id, departments.department_name, subjects.subject_name, paper.year, paper.pdf_file
                    FROM paper
                    JOIN departments ON paper.Department = departments.id
                    JOIN subjects ON paper.Subject = subjects.id";
                }
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    // Fetch department name using department ID
                    $dept_id = isset($row['Department']) ? $row['Department'] : null;
                    $dept_query = mysqli_query($conn, "SELECT department_name FROM departments WHERE id = '$dept_id'");
                    if(mysqli_num_rows($dept_query) > 0){
                        $dept_row = mysqli_fetch_assoc($dept_query);
                        $department_name = $dept_row['department_name'];
                    }else{
                        $department_name = "Unknown";
                    }
                    
                    // Fetch subject name using subject ID
                    $sub_id = isset($row['Subject']) ? $row['Subject'] : null;
                    $sub_query = mysqli_query($conn, "SELECT subject_name FROM subjects WHERE id = '$sub_id'");
                    if(mysqli_num_rows($sub_query) > 0){
                        $sub_row = mysqli_fetch_assoc($sub_query);
                        $sub_name = $sub_row['subject_name'];
                    }else{
                        $sub_name = "Unknown";
                    }


    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['department_name']."</td>";
    echo "<td>".$row['subject_name']."</td>";
    echo "<td>".$row['year']."</td>";
    echo "<td><a href='download.php?file=".urlencode($row['pdf_file'])."' target='_blank'>View File</a></td>";
    echo "<td><a href='edit_paper.php?id=".$row['id']."' class='btn btn-info btn-xs'>Edit</a> <a href='delete_paper.php?id=".$row['id']."' class='btn btn-danger btn-xs'>Delete</a></td>";
    echo "</tr>";
}

                
            ?>
        </tbody>
    </table>
    <a href="addpaper.php" class="btn btn-primary">Add Paper</a>
</div>

<?php include('../footer.php') ?>
