<?php 
    
    require_once('config/functions.php'); 
    require_once('config/session.php'); 

    
    // $students = getAllByOrder('students','created_at','DESC');
    
    $connect = connect();
    $school_id = $_SESSION['qcpt_mandir']['user_id'];
    $students = "SELECT * FROM students WHERE school_id = '".$school_id."' ORDER BY student_id DESC ";
    $students = getRaw($students);
    
    if(isset($_GET['delete'])){

        $delete_id = $_GET['delete'];
        
        if(delete('students','student_id',$delete_id)){
            $success = "Student Deleted !";
            header('location:students.php');
        }else{
            $error = "Failed to delete an student, try again later";            
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
                                    <h4 class="page-title">Students</h4>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="add_student.php" style="border-radius: 25px;" class="btn btn-primary btn-md"><i class="fa fa-plus"></i> Add Student</a>
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

                            <table id="table_students" class="table table-striped table-responsive table-condensed table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sr.</th>
                                        <!-- <th class="text-center">Id</th> -->
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Medium</th>
                                        <th class="text-center">Std.</th>
                                        <th class="text-center">Stream</th>
                                        <th class="text-center">Fee</th>
                                        <th class="text-center">Contacts</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if(isset($students)){ ?>
                                        <?php $i=1; foreach($students as $rs){ 

                                            // check if fee paid
                                            $where = array(
                                                'school_id' => $rs['school_id'],
                                                'student_id' => $rs['student_id']
                                            );
                                            $fee_status = selectWhereMultiple('fee',$where);

                                        ?>

                                            <tr>
                                                <td class="text-center"><?php echo $i++; ?></td>
                                                <!-- <td class="text-center"><?php echo $rs['student_id']; ?></td> -->
                                                <td class="text-center"><?php echo $rs['student_name']; ?></td>
                                                <td class="text-center"><?php echo $mediums[$rs['student_medium']]; ?></td>
                                                <td class="text-center"><?php echo $standards[$rs['student_standard']]; ?></td> 
                                                <td class="text-center"><?php
                                                    if($rs['student_stream'] != ""){
                                                        echo $streams[$rs['student_stream']]; 
                                                    }else{
                                                        echo "-"; 
                                                    }
                                                 ?></td> 
                                                 <td class="text-center">
                                                     <?php 
                                                        if(isset($fee_status)){ 

                                                            $fee_paid = getOne('fee','student_id',$rs['student_id']);
                                                            $fee_id = $fee_paid['fee_id']; 
                                                            $fee_amount = $fee_paid['amount']; 
                                                            $fee_payment_mode = $fee_paid['payment_mode']; 
                                                            $fee_bank_name = $fee_paid['bank_name']; 
                                                            $fee_cheque_number = $fee_paid['cheque_number']; 
                                                            $fee_ifsc = $fee_paid['ifsc']; 
                                                            $fee_paid_at = date('d-M-Y', strtotime($fee_paid['created_at'])); 

                                                        ?>
                                                            <a href="#" data-toggle="modal" data-target="#feeModal"
                                                            data-fee-id="<?php echo $fee_id; ?>" 
                                                            data-fee-amount="<?php echo $fee_amount; ?>" 
                                                            data-fee-payment-mode="<?php echo $fee_payment_mode; ?>" 
                                                            data-fee-bank-name="<?php echo $fee_bank_name; ?>" 
                                                            data-fee-cheque-number="<?php echo $fee_cheque_number; ?>" 
                                                            data-fee-ifsc="<?php echo $fee_ifsc; ?>" 
                                                            data-fee-paid-at="<?php echo $fee_paid_at; ?>" 
                                                             class="show-fee"><span class='text-primary'>Paid</span></a>
                                                        <?php }else{ ?>
                                                            <a style="border-radius: 10px;" href="fee.php?student_id=<?php echo $rs['student_id']; ?>" class="btn btn-primary btn-xs">Pay Now</a>
                                                        <?php } ?>
                                                 </td>
                                                <td class="text-center"><?php 
                                                    if($rs['student_contact'] != "" && $rs['student_parent_contact'] != ""){
                                                        echo $rs['student_contact'].",".$rs['student_parent_contact'];  
                                                    }else{
                                                        echo $rs['student_contact']." ".$rs['student_parent_contact'];
                                                    } ?>   
                                                </td>
                                                <td class="text-center"><?php echo $rs['student_address']; ?></td> 
                                                <td class="text-right">
                                                    
                                                    <!-- <a href="print_receipt.php?fee_id=<?php echo $fee_id; ?>"><i class="fa fa-print"></i></a> -->

                                                    <a href="add_student.php?edit=<?php echo $rs['student_id']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                    <a onclick=" return confirm('Are you sure?'); " href="students.php?delete=<?php echo $rs['student_id']; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
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

        <!-- Modals -->

        <div id="feeModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Fee Details</h4>
              </div>
              <div class="modal-body">

                <table class="table table-striped table-condensed">
                    <tbody>
                            
                        <tr>
                            <td>Amount :</td>
                            <td><span class="data_fee_amount"></span></td>
                        </tr>
                        
                        <tr>
                            <td>Payment Mode : </td>
                            <td><span class="data_fee_payment_mode"></span></td>
                        </tr>
                        
                        <tr class="bank_details">
                            <td>Bank Name : </td>
                            <td><span class="data_fee_bank_name"></span></td>
                        </tr>
                        
                        <tr class="bank_details">
                            <td>Cheque Number : </td>
                            <td><span class="data_fee_cheque_number"></span></td>
                        </tr>
                        
                        <tr class="bank_details">
                            <td>IFSC : </td>
                            <td><span class="data_fee_ifsc"></span></td>
                        </tr>
                        
                        <tr>
                            <td>Paid at : </td>
                            <td><span class="data_fee_paid_at"></span></td>
                        </tr>
                    
                    </tbody>

                </table>
                
                
              </div>
              
              <div class="modal-footer">
                <a href="" class="btn btn-primary print_receipt"><i class="fa fa-print"></i> Print Receipt</a>
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
              </div>
            </div>

          </div>
        </div>

        <!-- END wrapper -->
        <!-- START Footerscript -->
        <?php require_once('include/footerscript.php'); ?>

        <script>
            
            $('#table_students').dataTable({
                "order": [[ 1, "desc" ]]
            });

            $('.show-fee').on('click', function(){
                
                var data_fee_id = $(this).attr('data-fee-id');
                var data_fee_amount = $(this).attr('data-fee-amount');
                var data_fee_payment_mode = $(this).attr('data-fee-payment-mode');
                var data_fee_bank_name = $(this).attr('data-fee-bank-name');
                var data_fee_cheque_number = $(this).attr('data-fee-cheque-number');
                var data_fee_ifsc = $(this).attr('data-fee-ifsc');
                var data_fee_paid_at = $(this).attr('data-fee-paid-at');

                if(data_fee_payment_mode == 1){
                    $('.bank_details').hide();
                    var mode = "Cash";
                }else{
                    $('.bank_details').show();
                    var mode = "Cheque";
                }
                $('.data_fee_amount').html(data_fee_amount);
                $('.data_fee_payment_mode').html(mode);
                $('.data_fee_bank_name').html(data_fee_bank_name);
                $('.data_fee_cheque_number').html(data_fee_cheque_number);
                $('.data_fee_ifsc').html(data_fee_ifsc);
                $('.data_fee_paid_at').html(data_fee_paid_at);

                $('.print_receipt').attr('href','print_receipt.php?fee_id='+data_fee_id)

            });

        </script>

    </body>
</html>