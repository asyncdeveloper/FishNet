<!doctype html>
<html lang="en">
<?php
require_once "includes/database.php";

if(isset($_POST['submit'])){
    $usernameOrEmail = $_POST['username'];
    $pass            = sha1($_POST['password']);
    $users = mysqli_query($connection,"SELECT * FROM users WHERE username='$usernameOrEmail' OR email='$usernameOrEmail' AND password='$pass' LIMIT 1");
    if(mysqli_num_rows($users)==1){
        $user = mysqli_fetch_array($users);
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('location: login.php?success');
    }else{
        header("location: login.php?err=1");
    }
}
?>
<?php require_once "includes/head.php"; ?>
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
                                <h4 class="title text-center">Login</h4>
                            </div>
                            <div class="content">
                                <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                                    <?php if(isset($_REQUEST['err'])): ?>
                                        <?php if($_REQUEST['err']='1'): ?>
                                            <div class="alert alert-danger">
                                                <?php echo  "Incorrect email/password "; ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if (isset($_REQUEST['success'])): ?>
                                        <div class="alert alert-success">
                                            <?php echo  " Redirecting to Dashboard ..."; ?>
                                            <script>
                                                setTimeout( function(){
                                                window.location='dashboard.php'
                                                }, 2500);
                                            </script>
                                        </div>
                                    <?php endif; ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Email/Username</label>
                                                <input type="text" class="form-control" placeholder="Email/Username" name="username">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" name="password" placeholder="Password" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-fill " name="submit">
                                            Login
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
