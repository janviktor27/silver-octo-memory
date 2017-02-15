<?php include_once'includes/header.php';?>
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
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-4">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>MANAGE</h3>

              <p>MANAGE SCHEDULES</p>
            </div>
            <div class="icon">
              <i class="ion ion-calendar"></i>
            </div>
            <a href="schedules.php?ref=quicklinks" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-4">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>MY</h3>
              <p>CLASSES</p>
            </div>
            <div class="icon">
              <i class="ion ion-home"></i>
            </div>
            <a href="myclass.php?ref=quicklinks" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-4">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>ADVISORY</h3>

              <p>CLASS</p>
            </div>
            <div class="icon">
              <i class="ion ion-university"></i>
            </div>
            <a href="advisoryclass.php?ref=quicklinks" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
//<!-- Main Footer -->
include_once'includes/footer.php';
?>