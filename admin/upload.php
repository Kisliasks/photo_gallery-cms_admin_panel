<?php include("includes/header.php"); ?>

<?php 
if(!$session->is_signed_in()) {
    redirect('login.php');
}
?>

<?php 

$message= "";
if(isset($_FILES['file'])) {

    $photo = new Photo();
    $photo->user_id = $_SESSION['id'];
    $photo->title = $_POST['title'];
    $photo->set_file($_FILES['file']);

    if($photo->save()) {
        $message = "Photo uploaded Successfully";
    } else {
        $message = join("<br>", $photo->errors);
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
            Upload
        </h1>

        <div class="row">
        <div class="col-md-6">
            <?php  echo $message; ?>
        <form action="upload.php" method="post" enctype="multipart/form-data">
        
                <div class="form-group">
                    <input type="text" name="title" class="form-control">
                </div>

                <div class="form-group">
                    <input type="file" name="file" >
                </div>
                    <input type="submit" name="submit">
    
        </form>
        </div>

        </div>  <!-- END OF ROW -->

        <div class="row"  >
            <div class="col-lg-12">
            <div class="my-dropzone">

                <!-- окно загрузчика фото с помощью перетаскивания  --> 
                <form class="dropzone" action="upload.php">

                </form>

                </div>
            </div>

        </div>

    </div>
</div>
<!-- /.row -->

</div>
<!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>