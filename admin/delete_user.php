<?php include("includes/init.php"); ?>

<?php 
if(!$session->is_signed_in()) {
    redirect('login.php');
}
?>

<?php 


if(empty($_GET['id'])) {
   $id = $_GET['id'];
    redirect("users.php");
}

$user = User::find_by_id($_GET['id']);

if($user) {
    $user->delete_photo();
    // $target_path = SITE_ROOT.DS. 'admin' . DS . 'images' . DS . $user->user_image;
    // unlink($target_path);
    redirect("users.php");
    $session->message("The {$user->username} user has been deleted");

} else {
    redirect("users.php");
}


?>