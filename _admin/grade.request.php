<?php include_once'includes/header.php';?>
<?php include_once'classes/class.grade.request.php';?>
<div class="wrapper">
<?php
//<!-- Main Header -->
include_once'includes/top_menu.php';
//<!-- Left side column. contains the logo and sidebar -->
include_once'includes/side_bar.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
		Change Grade Requests
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Set</a></li>
        <li class="active">Subjects</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	 <div class="row">
	  <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">All Subject</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
			   <thead>
                <tr>
                  <th>Student Name(grade level)</th>
                  <th>Teacher Name</th>
                  <th>Subject Name</th>
                  <th>Old Grade</th>
                  <th>New Grade</th>
                  <th></th>
                </tr>
			   </thead>
			   <tbody>
			   <?php theview();?>
			   </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
	  </div>
	 </div>
    </section>
    <!-- /.content -->
  </div>
  <?php
  //Modals!
	gradesMod();
	grantMod();
	delMod();
  ?>
  <!-- /.content-wrapper -->
<?php
//<!-- Main Footer -->
include_once'includes/footer.php';
?>