<?php session_start();?>

<?php include('header.php') ?>
            <div class="jumbotron text-center">
            	<h2 style="text-align: center; margin-right: -5%; font-family: fantasy;">
                                Question Paper Management System
                                
                            </h2><span style="float: right;margin-right: 5%;"><a href="login.php" class="btn btn-info btn-lg">Admin Login</a></span>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>
                            
                            STUDENT LOGIN
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 jumbotron">
                            <form action="index.php" method="post">
                              <div class="form-group">
                                  Username:<input type="text" class="form-control" name="name" placeholder=" Enter Your name" required>
                              </div>
                            <div class="form-group">
                                  Password :<input type="text-center" class="form-control" name="pcontact" placeholder="Enter Passoword" required>
                            </div>
                              <div class="form-group">
                                  <input type="submit" name="login" value="LOGIN" class="btn btn-success btn-block text-center" > 
                              </div> 
                              <a href="new_stud.php">Register New</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
    include ('dbcon.php');

    if (isset($_POST['login'])) {

        $name = $_POST['name'];
        $pcontact = $_POST['pcontact'];
        $qry = "SELECT * FROM student WHERE name='$name' AND pcontact='$pcontact'";
        
        $run  = mysqli_query($conn, $qry);

       $row = mysqli_num_rows($run);

        if($row > 0) {
         $data = mysqli_fetch_assoc($run);
                    $id= $data['id'];
                    $_SESSION['uid'] = $id;
                    header('location:dashboard.php');

           
        } else {
      ?>             
    <script>
        alert('username or passoword invalid');
        window.open('login.php','_self');
    </script>
    <?php
                   
                }

}
?>

<?php include('footer.php') ?>

