<?php require_once('config/functions.php'); ?>
<?php require_once('config/session.php'); ?>

<?php 
    
    // $students = getAllByOrder('students','created_at','DESC');
    
    $connect = connect();
    $school_id = $_SESSION['qcpt_mandir']['user_id'];
    $schools = getAll('schools');

    $students = getAllByOrder('students','student_id','DESC'); 

    if(isset($_POST['search'])){
        
        $search_school_id = $_POST['school_id'];
        if($search_school_id == 0){

             $students = getAllByOrder('students','student_id','DESC');  

        }else{
            
             $students = getWhere('students','school_id',$search_school_id); 
            
        }

    }

    $total_students = count($students);
    
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
                        <!-- <div class="row">
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
                                                </div> -->
                        <!-- end row -->

                        <div class="row" style="margin-top: 20px;">


                            <div class="col-md-12">

                                <form method="post">

                                <div class="col-md-3">

                                    <label for="school_id">Select School</label>
                                    
                                    <select name="school_id" id="school_id" class="select2">

                                        <option value="0">All</option>
                                    
                                        <?php if(isset($schools)){ ?>
                                    
                                            <?php foreach ($schools as $rs) { ?>

                                                <option <?php if(isset($_POST['school_id']) && $_POST['school_id'] == $rs['school_id']){ echo "selected"; } ?> value="<?php echo $rs['school_id']; ?>"><?php echo $rs['school_name']; ?></option>

                                            <?php } ?>
                                        
                                        <?php } ?>
                                    
                                    </select>

                                </div>

                                <div class="col-md-3">
                                    <br>
                                    <button style="margin-top: 8px;" type="submit" class="btn btn-primary" name="search"><i class="fa fa-search"></i> Search </button>
                                </div>

                                </form>

                            </div>
    
                            
                            <div class="col-md-12" style="margin-top: 10px;">

                            <hr>

                            <p style="font-size: 13px;" class="text-primary"> <?php echo $total_students; ?> Records Found for 
                                <?php if(isset($_POST['school_id']) && $_POST['school_id'] != 0){ 
                                    
                                    $this_school_name = getOne('schools','school_id',$_POST['school_id']);
                                    echo $this_school_name['school_name'];

                                 }else{ 

                                    echo "All"; 
                                } ?>
                            </p>

                            <table id="table_students" class="table table-striped table-responsive table-condensed table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">School</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Medium</th>
                                        <th class="text-center">Std.</th>
                                        <th class="text-center">Stream</th>
                                        <th class="text-center">Fee</th>
                                        <th class="text-center">Contacts</th>
                                        <th class="text-center">Address</th>
                                        <!-- <th class="text-right">Actions</th> -->
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if(isset($students)){ ?>
                                        <?php foreach($students as $rs){ 

                                            // check if fee paid
                                            $where = array(
                                                'school_id' => $rs['school_id'],
                                                'student_id' => $rs['student_id']
                                            );
                                            $fee_status = selectWhereMultiple('fee',$where);

                                        ?>

                                            <tr>
                                                <td class="text-center">
                                                <?php 
                                                    $school_name = getOne('schools','school_id',$rs['school_id']);
                                                    echo $school_name = $school_name['school_name']; 
                                                    
                                                ?></td>
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
                                                            <span class="text-danger">Pending</span>
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
                "order": [[ 0, "desc" ]]
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

                $('.print_receipt').prop('href','print_receipt2.php?fee_id='+data_fee_id)

            });

        </script>

    </body>
</html>