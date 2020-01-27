<?php 

    require_once('config/functions.php');
    require_once('config/session.php');
    
    if(isset($_POST['submit'])){

        $next_id = 'SELECT AUTO_INCREMENT as next_id FROM information_schema.TABLES WHERE TABLE_SCHEMA = "qocept_mandir" AND TABLE_NAME = "entries"';
        $next_id = getRaw($next_id);
        $next_id = $next_id[0]['next_id'];

        $receipt_no = 'RC'.sprintf('%07d',($next_id));

        $form_data = array(
            'receipt_no'=>$receipt_no,
            'date'=>$_POST['date'],
            'funding_person'=>$_POST['funding_person'],
            'funding_person_by'=>$_POST['funding_person_by'],
            'mobile_number'=>$_POST['mobile_number'],
            'village'=>$_POST['village'],
            'district'=>$_POST['district'],
            'amount'=>$_POST['amount'],
            'payment_mode'=>$_POST['payment_mode'],
            'cheque_no'=>$_POST['cheque_no'],
            'account_holder_name'=>$_POST['account_holder_name'],
            'bank_name'=>$_POST['bank_name'],
            'payment_mode_name'=>$_POST['payment_mode_name'],
            'transaction_id'=>$_POST['transaction_id']
        );

        if(insert('entries',$form_data)){
            $success = "Entry Added Successfully";
        }else{
            $error = "Failed to add entry, try again later";
        }


    }

    if(isset($_GET['edit'])){

      $edit_id = $_GET['edit'];
      $edit_data = getWhere('entries','id',$edit_id);

      foreach($edit_data as $rs){
      
          $edit_date = $rs['date'];
          $edit_funding_person = $rs['funding_person'];
          $edit_funding_person_by = $rs['funding_person_by'];
          $edit_mobile_number = $rs['mobile_number'];
          $edit_village = $rs['village'];
          $edit_district = $rs['district'];
          $edit_amount = $rs['amount'];
          $edit_payment_mode = $rs['payment_mode'];
          $edit_cheque_no = $rs['cheque_no'];
          $edit_account_holder_name = $rs['account_holder_name'];
          $edit_bank_name = $rs['bank_name'];
          $edit_payment_mode_name = $rs['payment_mode_name'];
          $edit_transaction_id = $rs['transaction_id'];

        }
      
      }else{

          $edit_date = "";
          $edit_funding_person = "";
          $edit_funding_person_by = "";
          $edit_mobile_number = "";
          $edit_village = "";
          $edit_district = "";
          $edit_amount = "";
          $edit_payment_mode = "";
          $edit_cheque_no = "";
          $edit_account_holder_name = "";
          $edit_bank_name = "";
          $edit_payment_mode_name = "";
          $edit_transaction_id = "";
    
    }

  if(isset($_POST['update'])){

      if($_POST['payment_mode'] == '1'){
  
          $_POST['cheque_no'] = "";
          $_POST['account_holder_name'] = "";
          $_POST['bank_name'] = "";
          $_POST['payment_mode_name'] = "";
          $_POST['transaction_id'] = "";
  
      }else if($_POST['payment_mode'] == '2'){
  
          $_POST['payment_mode_name'] = "";
          $_POST['transaction_id'] = "";
  
      }else if($_POST['payment_mode'] == '3'){
 
          $_POST['cheque_no'] = "";
          $_POST['account_holder_name'] = "";
          $_POST['bank_name'] = "";
   
      }

       $form_data = array(
            'date'=>$_POST['date'],
            'funding_person'=>$_POST['funding_person'],
            'funding_person_by'=>$_POST['funding_person_by'],
            'mobile_number'=>$_POST['mobile_number'],
            'village'=>$_POST['village'],
            'district'=>$_POST['district'],
            'amount'=>$_POST['amount'],
            'payment_mode'=>$_POST['payment_mode'],
            'cheque_no'=>$_POST['cheque_no'],
            'account_holder_name'=>$_POST['account_holder_name'],
            'bank_name'=>$_POST['bank_name'],
            'payment_mode_name'=>$_POST['payment_mode_name'],
            'transaction_id'=>$_POST['transaction_id']
        );

        if(update('entries','id',$_GET['edit'],$form_data)){
            $success = "Entry Updated Successfully";
        }else{
            $error = "Failed to update entry, try again later";
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
                                  <h4 class="page-title">Add Entry</h4>
                                  </div>
                                  <div class="col-md-6 text-right">
                                      <a href="entries.php" class="btn btn-primary btn-md">View Entries</a>
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

                        <form method="post" enctype="multipart/form-data">

                           <div class="col-md-12">

                                <div class="form-group col-md-4">
                                     <label for="date">તારીખ<span class="text-danger">*</span></label>
                                     <input type="date" class="form-control" tabindex="1" id="date" name="date" required <?php if($edit_date != ""){ ?> value="<?php echo date('Y-m-d', strtotime($edit_date)); ?>" <?php }else{ ?> value="<?php echo date('Y-m-d'); ?>" <?php } ?> >
                                </div> 
                               
                               <div class="form-group col-md-4">
                                   <label for="funding_person">શ્રીમાન <span class="text-danger">*</span></label>
                                   <input type="text" class="form-control" id="funding_person" name="funding_person" required <?php if($edit_funding_person != ""){ ?> value="<?php echo $edit_funding_person; ?>" <?php } ?> tabindex="2" >
                               </div>

                               <div class="form-group col-md-4">
                                   <label for="funding_person_by">હસ્તે <span class="text-danger">*</span> &nbsp;<input class="pull-right" type="checkbox" id="funding_person_same_as_above"></label> 
                                   <input type="text" class="form-control" id="funding_person_by" name="funding_person_by" required <?php if($edit_funding_person_by != ""){ ?> value="<?php echo $edit_funding_person_by; ?>" <?php } ?> tabindex="3">
                               </div>

                               <div class="form-group col-md-4">
                                   <label for="mobile_number">મોબાઈલ નંબર<span class="text-danger">*</span></label>
                                   <input type="number" class="form-control" id="mobile_number" name="mobile_number" required <?php if($edit_mobile_number != ""){ ?> value="<?php echo $edit_mobile_number; ?>" <?php } ?> tabindex="4">
                               </div>

                               <div class="form-group col-md-4">
                                   <label for="village">ગામ<span class="text-danger">*</span></label>
                                   <input type="text" class="form-control" id="village" name="village" required <?php if($edit_village != ""){ ?> value="<?php echo $edit_village; ?>" <?php } ?> tabindex="5">
                               </div>

                               <div class="form-group col-md-4">
                                   <label for="district">જિલ્લો <span class="text-danger">*</span></label>
                                   <input type="text" class="form-control" id="district" name="district" required <?php if($edit_district != ""){ ?> value="<?php echo $edit_district; ?>" <?php } ?> tabindex="6">
                               </div>

                               <div class="form-group col-md-4">

                                   <label for="payment_mode">પેમેન્ટ પદ્ધતિ</label>
                                    
                                    <select name="payment_mode" id="payment_mode" class="select2 payment_mode" required="" tabindex="7">

                                        <option <?php if($edit_payment_mode == "1"){ echo "selected";  } ?> value="1">રોકડ</option>
                                        <option <?php if($edit_payment_mode == "2"){ echo "selected";  } ?> value="2">ચેક</option>
                                        <option <?php if($edit_payment_mode == "3"){ echo "selected";  } ?> value="3">ટ્રાન્સફર</option>
                                    
                                    </select>
                               </div>

                               <div class="form-group col-md-4 ">
                                   <label for="amount">રકમ<span class="text-danger">*</span></label>
                                   <input type="number" class="form-control" id="amount" name="amount" required <?php if($edit_amount != ""){ ?> value="<?php echo $edit_amount; ?>" <?php } ?> tabindex="8">
                               </div>

                               <div class="cheque-payment-block"  style="display: none;">
                                 
                                 <div class="form-group col-md-4 cheque-block">
                                     <label for="cheque_no">ચેક નંબર</label>
                                     <input type="text" class="form-control" id="cheque_no" name="cheque_no" <?php if($edit_cheque_no != ""){ ?> value="<?php echo $edit_cheque_no; ?>" <?php } ?> tabindex="9">
                                 </div>

                                 <div class="form-group col-md-4">
                                     <label for="account_holder_name">ખાતાધારકનું નામ</label>
                                     <input type="text" class="form-control" id="account_holder_name" name="account_holder_name" <?php if($edit_account_holder_name != ""){ ?> value="<?php echo $edit_account_holder_name; ?>" <?php } ?> tabindex="10">
                                 </div>

                                 <div class="form-group col-md-4">
                                     <label for="bank_name">બેંકનું નામ</label>
                                     <input type="text" class="form-control" id="bank_name" name="bank_name" <?php if($edit_bank_name != ""){ ?> value="<?php echo $edit_bank_name; ?>" <?php } ?> tabindex="11">
                                 </div>

                               </div>

                               <div class="other-payment-block" style="display: none;">

                                   <div class="form-group col-md-4">
                                       <label for="payment_mode_name">ટ્રાન્સફર પદ્ધતિ (PayTM,GPay,BHIM)</label>
                                       <input type="text" class="form-control" id="payment_mode_name" name="payment_mode_name" <?php if($edit_payment_mode_name != ""){ ?> value="<?php echo $edit_payment_mode_name; ?>" <?php } ?> tabindex="12">
                                   </div>

                                   <div class="form-group col-md-4">
                                       <label for="transaction_id">Transaction Id</label>
                                       <input type="text" class="form-control" id="transaction_id" name="transaction_id" <?php if($edit_transaction_id != ""){ ?> value="<?php echo $edit_transaction_id; ?>" <?php } ?> tabindex="13">
                                   </div>

                                  <!--  <div class="form-group col-md-4">
                                       <label for="transaction_document">Transaction Document</label>
                                       <input type="file" id="transaction_document" name="transaction_document" tabindex="4">
                                       <img src="" style="width: 50px;" alt="">
                                   </div> -->

                                </div>


                           </div>    


                           <div class="col-md-12 text-right">
                                   
                                 <?php if(isset($_GET['edit'])){ ?>

                                   <button type="submit" tabindex="8" name="update" class="btn btn-danger"><i class="fa fa-floppy-o"></i> &nbsp;Update entry</button>
                                
                                <?php }else{ ?>
                                
                                   <button type="submit" tabindex="8" name="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> &nbsp;Save</button>

                                <?php } ?>

                             </div>

                            </form>

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
            
            $('.payment_mode').on('change', function(){

                var payment_mode = $(this).val();

                if(payment_mode == '1'){
                  $('.cheque-payment-block').css('display','none');
                  $('.other-payment-block').css('display','none');
                  // $('.cheque-other-block').hide();
                }else if(payment_mode == '2'){
                  $('.cheque-payment-block').css('display','block');
                  $('.other-payment-block').css('display','none');
                  // $('.cheque-other-block').hide();
                }else if(payment_mode == '3'){
                  $('.other-payment-block').css('display','block');
                  $('.cheque-payment-block').css('display','none');
                }

            });

            $('#funding_person_same_as_above').on('change', function(){

                var val = $(this).prop('checked');
                if(val){
                  $('#funding_person_by').val($('#funding_person').val());
                }

            });

        </script>

    </body>
</html>