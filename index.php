<?php require_once('config/functions.php'); ?>

<?php 
  
    // school_user_type = 1 = admin
    // school_user_type = 2 = school

    if(isset($_POST['submit'])){

        $username = $_POST['username'];
        $password = $_POST['password'];

        $where = array(
            'admin_username' => $username,
            'admin_password' => md5($password)
        );
        $is_admin = selectWhereMultiple('admins',$where);

        $where2 = array(
            'school_username' => $username,
            'school_password' => $password
        );
        $is_school = selectWhereMultiple('schools',$where2);

        if(isset($is_admin)){

            $_SESSION['qcpt_mandir']['user_type'] = '1';
            $_SESSION['qcpt_mandir']['user_id'] = $is_admin[0]['admin_id'];
            $_SESSION['qcpt_mandir']['user_name'] = $username;
            //header('location:dashboard.php');
			echo '<script>window.location="dashboard.php";</script>';

        }else{
            $error = "Invalid Username or Password";
        }

    }

?>

<!DOCTYPE html>
<html>
    <?php require_once('include/headerscript.php'); ?>

    <body class="bg-transparent">

        <!-- HOME -->
        <section>

            <div class="container-fluid" style=" background: url('assets/images/front-bg.png'); background-repeat: no-repeat;position: absolute; left: 50px; top: 20px; width: 800px;height: 450px;">
                
            </div>
            <div class="container-alt">
                <div class="row">
                    <div class="col-md-4 col-md-offset-8">

                        <div class="wrapper-page" style="margin-top: 100px;">

                            <div class="m-t-40 account-pages">
                                <div class="text-center account-logo-box">
                                    <h2 class="text-uppercase text-white">
                                        મંદિર સિસ્ટમ
                                    </h2>
                                    <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                                </div>
                                <div class="account-content">

                                    <div class="col-md-12">
                                        <?php if(isset($error)){ ?>
                                            <div class="alert alert-danger"><?php echo $error; ?></div>
                                        <?php }else if(isset($warning)){ ?>
                                            <div class="alert alert-warning"><?php echo $warning; ?></div>
                                        <?php }else if(isset($info)){ ?>
                                            <div class="alert alert-info"><?php echo $info; ?></div>
                                        <?php } ?>
                                    </div>

                                    <form class="form-horizontal" method="post">

                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                                <input class="form-control" type="text" required="" placeholder="Username" name="username">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input class="form-control" type="password" required="" placeholder="Password" name="password">
                                            </div>
                                        </div>

                                        <div class="form-group account-btn text-center m-t-10">
                                            <div class="col-xs-12">
                                                <button class="btn w-md btn-bordered btn-danger waves-effect waves-light" name="submit" type="submit">Log In</button>
                                            </div>
                                        </div>

                                    </form>

                                    <div class="clearfix"></div>

                                </div>
                            </div>
                            <!-- end card-box-->


                        </div>
                        <!-- end wrapper -->

                    </div>
                </div>
            </div>
          </section>
          <!-- END HOME -->
    </body>
</html>