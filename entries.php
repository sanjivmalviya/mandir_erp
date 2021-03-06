<?php 
    
    require_once('config/functions.php'); 
    require_once('config/session.php'); 

    $entries = getAllByOrder('entries','created_at','DESC');

    if(isset($_GET['delete'])){

        $delete_id = $_GET['delete'];
        
        if(delete('entries','entry_id',$delete_id)){
            $success = "Entry Deleted !";
            header('location:entries.php');
        }else{
            $error = "Failed to delete an entry, try again later";            
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
                                    <h4 class="page-title">Entries</h4>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="add_entry.php" style="border-radius: 50px;" class="btn btn-primary btn-md"> <i class="fa fa-plus"></i> Add Entry</a>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
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


                            <div class="col-md-12 table-responsive">

                            <table id="table_entries" class="table table-responsive table-condensed table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sr.</th>
                                        <th class="text-center">Receipt NO</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Haste</th>
                                        <th class="text-center">Mobile Number</th>
                                        <th class="text-center">Village</th>
                                        <th class="text-center">District</th>
                                        <th class="text-right">Amount</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if(isset($entries)){ ?>
                                        <?php $i=1; foreach($entries as $rs){ ?>

                                            <tr>
                                                <td class="text-center"><?php echo $i++; ?></td>
                                                <td class="text-center"><?php echo $rs['receipt_no']; ?></td>
                                                <td class="text-center"><?php echo $rs['funding_person']; ?></td>
                                                <td class="text-center"><?php echo $rs['funding_person_by']; ?></td>
                                                <td class="text-center"><?php echo $rs['mobile_number']; ?></td>
                                                <td class="text-center"><?php echo $rs['village']; ?></td>
                                                <td class="text-center"><?php echo $rs['district']; ?></td>
                                                <td class="text-right"><i class="fa fa-rupee"></i> <?php echo $rs['amount']; ?> /-</td>
                                                <td class="text-center">
                                                    <a href="add_entry.php?edit=<?php echo $rs['id']; ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                                    <a href="print.php?id=<?php echo $rs['id']; ?>" class="btn btn-success btn-xs"><i class="fa fa-print"></i> Print</a>
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
            
            $('#table_entries').dataTable();

        </script>

    </body>
</html>