<?php 
    
    require_once('config/functions.php'); 
    require_once('config/session.php'); 

    $schools = getAllByOrder('schools','created_at','DESC');

    if(isset($_GET['delete'])){

        $delete_id = $_GET['delete'];
        
        if(delete('schools','school_id',$delete_id)){
            $success = "School Deleted !";
            header('location:schools.php');
        }else{
            $error = "Failed to delete an school, try again later";            
        }

    }

?>
<!DOCTYPE html>
<html>
<?php require_once('include/headerscript.php'); ?>
<body class="fixed-left">
        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <?php require_once('include/topbar.php'); ?>
            <!-- Top Bar End -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php require_once('include/sidebar.php'); ?>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        <div class="row">
							<div class="col-xs-12">
								<div class="page-title-box">
                                    <div class="col-md-6">
                                    <h4 class="page-title">Dashboard</h4>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="add_school.php" style="border-radius: 50px;" class="btn btn-primary btn-md"> <i class="fa fa-plus"></i> Add School</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>
                        <!-- end row -->

                        <div class="row">
                             <div class="col-md-12">
                                <?php if(isset($success)){ ?>
                                    <div class="alert alert-success"><?php echo $success; ?></div>
                                <?php }else if(isset($error)){ ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php }else if(isset($warning)){ ?>
                                    <div class="alert alert-warning"><?php echo $warning; ?></div>
                                <?php }else if(isset($info)){ ?>
                                    <div class="alert alert-info"><?php echo $info; ?></div>
                                <?php } ?>
                            </div>


                            <div class="col-md-12">

                            <table id="table_schools" class="table table-responsive table-condensed table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sr.</th>
                                        <th class="text-center">Code</th>
                                        <th class="text-center">Logo</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Username/Password</th>
                                        <!-- <th class="text-center">Password</th> -->
                                        <th class="text-center">Address</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if(isset($schools)){ ?>
                                        <?php $i=1; foreach($schools as $rs){ ?>

                                            <tr>
                                                <td class="text-center"><?php echo $i++; ?></td>
                                                <td class="text-center"><?php echo $rs['school_code']; ?></td>
                                                <td class="text-center" >
                                                    <img align="center" src="<?php echo $rs['school_logo']; ?>" alt="" class=" text-center" style="width: 20px;height: 30px;">
                                                    
                                                </td>
                                                <td class="text-center"><?php echo $rs['school_name']; ?></td>
                                                <td class="text-center"><?php echo $rs['school_contact']; ?></td>
                                                <td class="text-center"><?php echo $rs['school_username']; ?><hr style="margin: 0;"><?php echo $rs['school_password']; ?></td> 
                                                <td class="text-center"><?php echo $rs['school_address']; ?></td>
                                                <td class="text-right">
                                                    <a href="add_school.php?edit=<?php echo $rs['school_id']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                    <a onclick=" return confirm('Are you sure ?'); " href="schools.php?delete=<?php echo $rs['school_id']; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>

                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>

                        </div>
                        




                    </div> <!-- container -->
                </div> <!-- content -->
            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


           

        </div>
        <!-- END wrapper -->
        <!-- START Footerscript -->
        <?php require_once('include/footerscript.php'); ?>

        <script>
            
            $('#table_schools').dataTable();

        </script>

    </body>
</html>