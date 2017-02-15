<?php include_once'includes/header.php';?>
<?php include_once'classes/class.student.grade.php';?>
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
	  My Student Grades
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Grades</a></li>
        <li class="active">All grades</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	 <div class="row">
	  <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">All Grades</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-bordered">
			   <thead>
				  <tr>
					<th style="text-align:center;" rowspan="2">LEARNING AREA</th>
					<th style="text-align:center;" colspan="4">QUARTER</th>
					<th style="text-align:center;" rowspan="2">FINAL GRADE</th>
				  </tr>
				  <tr>
					<td style="text-align:center;">1</td>
					<td style="text-align:center;">2</td>
					<td style="text-align:center;">3</td>
					<td style="text-align:center;">4</td>
				  </tr>
			   </thead>
			   <tbody>
			   <?php theview(); ?>
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
//<!-- Main Footer -->
include_once'includes/footer.php';
?>