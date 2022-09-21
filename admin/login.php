<?php require_once("includes/header.php"); ?>

<?php 

if($session->is_signed_in()){
    redirect('index.php');
}

if(isset($_POST['submit'])) {

    $username      = trim($_POST['username']);
    $user_password = trim($_POST['user_password']);

    ////  Method to check database user

   $user_found = User::verify_user($username, $user_password);
 
    if($user_found) {
        $session->login($user_found);
        redirect('index.php');
      
    } else {
      $the_message = "Your password or username are incorrect";
    }

    } else {
        $the_message = "";
        $username = "";
        $user_password = "";
}

?>



<div class="col-md-4 col-md-offset-3">

<h4 class="bg-danger"><?php echo $the_message;  ?></h4>
	
<form id="login_id" action="" method="post">
	
<div class="form-group">
	<label for="username">Username</label>
	<input type="text" class="form-control" name="username" value="" >

</div>

<div class="form-group">
	<label for="password">Password</label>
	<input type="password" class="form-control" name="user_password" value="<?php echo htmlentities($user_password); ?>">
	
</div>


<div class="form-group">
<input type="submit" name="submit" value="Submit" class="btn btn-primary">

</div>


</form>


</div>