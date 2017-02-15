<?php include_once'includes/header.php';?>
<?php include_once'classes/class.view-this-class.php';?>
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
      <h1><?php echo getGRDLVL();?></h1>
	  <h4><strong><?php echo getSubj(); ?></strong></h4>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Classes</a></li>
        <li><a href="#">Pupils</a></li>
        <li class="active">This class</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	 <div class="row">
	  <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Pupils</h3>
			  <a href="myclass.php?ref=back" class="btn btn-xs btn-danger pull-right"><i class="fa fa-arrow-left"></i></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
			<?php addResponse(); ?>
              <table class="table table-hover">
			   <thead>
                <tr>
                  <th>CIN</th>
                  <th>Name</th>
                  <th>Grading Period</th>
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

<?php
requestModal();
//<!-- Main Footer -->
include_once'includes/footer.php';
?>