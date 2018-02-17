<?php
require_once "includes/database.php";
require_once "includes/head.php";

if(isset($_POST['submit'])){
    $username     = $_POST['username'];
    $email        = $_POST['email'];
    $password     = $_POST['password'];
    $shaPass      = sha1($password);
    $cpassword    = $_POST['cpassword'];
    $type         = $_POST['type'];
    if($password!=$cpassword){
        $msg= 'Oops passwords not equal';
        header("Location: register.php?err=$msg");
    }else{
        $checkEmail = mysqli_num_rows(mysqli_query($connection,"SELECT email from users WHERE email='$email'"));
        $checkEmail = (int)$checkEmail;
        if($checkEmail>0){
            $msg= 'Email account already exist';
            header("Location: register.php?err=$msg");
        }
        $checkUsername = mysqli_num_rows(mysqli_query($connection,"SELECT username from users WHERE username='$username'"));
        $checkUsername = (int)$checkUsername;
        if($checkUsername>0){
            $msg= 'Username already exist';
            header("Location: register.php?err=$msg");
        }

        die(1);
        //Save to database
        $query = "INSERT INTO users(username,email,password,user_type,date_registered) VALUES ('$username','$email','$shaPass','$type',NOW())";
        $status = mysqli_query($connection,$query);
        if($status){
            header('Location: register.php?success');
        }else{
            $msg= 'Oops unable to connect to server kindly try again';
            header("Location: register.php?err=$msg");
        }
    }
}
?>
<!doctype html>
<html lang="en">
<body>

<div class="wrapper">
    <div >


        <?php require_once "includes/header.php"; ?>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                	<div class="col-md-2"></div>
                    <div class="col-md-8" >
                        <div class="card shadowed">
                            <div class="header">
                                <h4 class="title text-center">Register on FishFarm </h4>
                            </div>
                            <div class="content">
                                <form action="register.php" method="POST">
                                    <?php if(isset($_REQUEST['err'])): ?>
                                            <div class="alert alert-danger">
                                                <?php echo  $_REQUEST['err']; ?>
                                            </div>
                                    <?php elseif (isset($_REQUEST['success'])): ?>
                                        <div class="alert alert-success">
                                            <?php echo  "Account Created Successfully, Redirecting ..."; ?>
                                            <script>
                                                setTimeout( function(){
                                                    window.location='login.php'
                                                }, 2500);
                                            </script>
                                        </div>
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" placeholder="Researcher" name="email" required minlength="6" id="email" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control" placeholder="Username" name="username" minlength="6"  id="uname" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" name="password" required minlength="6" id="password" placeholder="Password" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control" name="cpassword" required minlength="6" id="cpassword" placeholder="Confirm Password" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>User type</label>
                                                <select name="type" id="type" class="form-control" required>
                                                    <option  selected disabled value="">Choose register type</option>
                                                    <option value="researcher">Researcher</option>
                                                    <option value="fisher">Expert</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <input type="submit" name="submit" class="btn btn-info btn-fill" onclick="validateSubmit()" value="Register">
                                    </div>

                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>

                </div>
            </div>
        </div>


        <?php require_once "includes/bottom.php"; ?>

    </div>
</div>


</body>
    <?php require_once "includes/footer.php"; ?>
</html>
