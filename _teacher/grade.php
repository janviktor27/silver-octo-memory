<?php include_once'includes/header.php';?>
<?php include_once'classes/class.grade.php';?>
<div class="wrapper">
<?php
period_open();
//<!-- Main Header -->
include_once'includes/top_menu.php';
//<!-- Left side column. contains the logo and sidebar -->
include_once'includes/side_bar.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php grdPeriod()?></h1>
	  <h5><strong><?php echo getPupName(); ?></strong></h5>
	  <h5><strong><?php echo getSubj(); ?></strong></h5>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Classes</a></li>
        <li><a href="#">Pupils</a></li>
        <li><a href="#">This class</a></li>
        <li class="active">Grade Student</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	 <div class="row">
	  <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-primary">
			<?php dynamicForm(); ?>
          </div>
          <!-- /.box -->
	  </div>
	  <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Grading period overview</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
			   <thead>
                <tr>
                  <th>Period #</th>
                  <th>Grade</th>
                  <th>Transmuted Grade</th>
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
  <!-- /.content-wrapper -->
<?php modMoreInfo(); ?>	  
<?php
//<!-- Main Footer -->
include_once'includes/footer.php';
?>