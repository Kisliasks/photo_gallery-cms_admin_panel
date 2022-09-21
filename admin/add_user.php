<?php include("includes/header.php"); ?>

<?php 
if(!$session->is_signed_in()) {
    redirect('login.php');
}
?>

<?php 


    $user = new User();
    

    if(isset($_POST['create'])) {
    
        if($user) {
           $user->username = $_POST['username'];
           $user->user_firstname = $_POST['first_name'];
           $user->user_lastname = $_POST['last_name'];
           $user->user_password = $_POST['password'];

            $user->set_photo($_FILES['user_image']);
            $user->save_user_and_image();
            $session->message("The user {$user->username} has been added");
            redirect("users.php");

           $user->save();
        }
    }

?>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
           
                <?php include "includes/top_nav.php"; ?>

           
                    <?php include "includes/side_nav.php"; ?>

            <!-- /.navbar-collapse -->
        </nav>



        <div id="page-wrapper">

        <div class="container-fluid">

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Add user
            <small>Subheading</small>
        </h1>
       <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-8">

            <div class="form-group">
                
                <input type="file" name="user_image" >
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" >
            </div>

       

            <div class="form-group">
                <label for="first name">First name</label>
                <input type="text" name="first_name" class="form-control" >
            </div>

            <div class="form-group">
                <label for="last name">Last name</label>
                <input type="text" name="last_name" class="form-control" >
            </div>    

            <div class="form-group">
                <label for="password">Password</label>
                <input type="text" name="password" class="form-control" >
            </div>   
            
            <div class="form-group">
           
                <input type="submit" name="create" class="btn btn-primary" >
            </div>   

           </div>
      
       </form>

    </div>
</div>
<!-- /.row -->

</div>
<!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>