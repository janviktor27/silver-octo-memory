<?php include_once'includes/header.php';?>
<?php include_once'classes/class.section.php';?>
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
	  SET GRADE/SECTIONS
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Manage</a></li>
        <li class="active">GRADE/SECTIONS</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	 <div class="row">
	  <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add Grade/Section</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?php add(); ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="inpSECT" class="col-sm-3 control-label">Section name</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="inpSECT" id="inpSECT" placeholder="Section name" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inpGRLVL" class="col-sm-3 control-label">Grade Level</label>

                  <div class="col-sm-9">
					<select class="form-control" name="inpGRLVL" id="inpGRLVL" required>
					 <option default value="">Grade Level</option>
					 <option value="1">1</option>
					 <option value="2">2</option>
					 <option value="3">3</option>
					 <option value="4">4</option>
					 <option value="5">5</option>
					 <option value="6">6</option>
					 <option value="7">7</option>
					 <option value="8">8</option>
					 <option value="9">9</option>
					 <option value="10">10</option>
					</select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inpTEACHER" class="col-sm-3 control-label">Adviser</label>
                  <div class="col-sm-9">
					<select class="form-control" name="inpTEACHER" id="inpTEACHER" required>
					 <option default value="">Section Adviser</option>
					 <?php optTeacher(); ?>
					</select>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
				<?php addResponse(); ?>
                <button type="submit" name="btn_add" class="btn btn-info pull-right btn-flat"><i class="fa fa-plus-square"></i> Add</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
	  </div>
	  <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">All Sections</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
			  <?php
			  //updResponse();
			  delResponse();?>
              <table class="table table-hover">
			   <thead>
                <tr>
                  <th>Grade/Section</th>
                  <th>Adviser</th>
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
  //updMod();
  delMod()
  ?>
  <!-- /.content-wrapper -->
<?php
//<!-- Main Footer -->
include_once'includes/footer.php';
?>