<?php
require_once "includes/database.php";
session_start();
if(isset($_POST['submit'])){
    $email      = $_POST['email'];
    $users = mysqli_query($connection,"SELECT * FROM users WHERE email='$email' LIMIT 1");
    if(mysqli_num_rows($users)==1){
        $user = mysqli_fetch_array($users);
        $name = $user['username'];
        $email =$user['email'];
        //Generate new password;
        $newPassword = substr(sha1(md5(rand(0,9))),0,5);
        $message = "
                Hi, $name You have successfully reset your password. \n 
                Your login details are : \n
                Email     :  $email \n
                password  :  $newPassword \n  
            ";
        ///Send Mail
        sendMail($email,"Reset Password",$message);
        header("Location: forgotpassword.php?success");
    }else{
        header("Location: forgotpassword.php?err=1");
    }
}
require_once "includes/head.php";
?>

<html lang="en">
<body>

<div class="wrapper">
    <div>

        <?php require_once "includes/header.php"; ?>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="card shadowed" id="centered">
                            <div class="header">
                                <h4 class="title text-center">Forgot Password</h4>
                            </div>
                            <div class="content">
                                <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                                    <?php if(isset($_REQUEST['err'])): ?>
                                        <?php if($_REQUEST['err']='1'): ?>
                                            <div class="alert alert-danger">
                                                <?php echo  "Incorrect email"; ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if (isset($_REQUEST['success'])): ?>
                                        <div class="alert alert-success">
                                            <?php echo  " Reset successful check email ..."; ?>
                                            <script>
                                                setTimeout( function(){
                                                    window.location='login.php'
                                                }, 5000);
                                            </script>
                                        </div>
                                    <?php endif; ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Email Address</label>
                                                <input type="email" class="form-control" placeholder="Email" name="email" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-fill " name="submit">
                                            Reset Password
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>

                </div>
            </div>
        </div>


        <?php require_once "includes/bottom.php"; ?>

    </div>
</div>


</body>
<?php require_once "includes/footer.php"; ?>
</html>
