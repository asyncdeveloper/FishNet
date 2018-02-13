<!doctype html>
<html lang="en">
<?php
require_once "includes/database.php";

if(empty($_SESSION['username']) || empty($_SESSION['id'])){
    header("location: login.php");
}

$loggedInUser = mysqli_fetch_array(mysqli_query($connection,"SELECT * from users WHERE id='{$_SESSION['id']}'" ));
if(empty($loggedInUser)){
    header("location: login.php");
}
require_once "includes/head.php";
?>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="assets/img/backgroujdn.jpg">

        <?php  require_once "includes/leftSideBar.php"; ?>

    </div>

    <div class="main-panel">

        <?php  require_once "includes/dashboardNav.php"; ?>

        <div class="content">
            <div class="container-fluid">

                <div class="row">
                    <!--kjdwkjdqwkjdqjkw-->
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="header">
                                <?php if($loggedInUser['user_type']=='fisher'): ?>
                                    <h4 class="title">Recommended Researchers</h4>
                                <?php else: ?>
                                    <h4 class="title">Recommended Experts</h4>
                                <?php endif; ?>
                                <!--<p class="category">Backend development</p>-->
                            </div>
                            <div class="content">
                                <div class="row top-summary">
                                    <?php
                                        $sql = "SELECT * FROM `users` where user_type!='{$loggedInUser['user_type']}' AND id!={$_SESSION['id']} ";
                                        $query = mysqli_query($connection,$sql);
                                    ?>

                                        <?php while($row = mysqli_fetch_array($query)): ?>
                                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-12"
                                                 style="margin-bottom: 10px" >
                                                <div class="widget card">
                                                    <!--Title-->
                                                    <h5 class="card-title text-center">
                                                        <a href="<?="profile.php?id={$row['id']}"?>">
                                                            <?=$row['username']?>
                                                        </a>
                                                        <br><br>
                                                    </h5>
                                                    <!-- end title -->
                                                    <div style="text-align: center; width: -webkit-fill-available" class="imagecontent" >
                                                        <?php if(!empty($row['image'])): ?>
                                                            <img class="image-responsive"
                                                                 alt="Avatar" style="width: 80%; height: 140px;"
                                                                 src="<?=$row['image']?>"
                                                            />
                                                            <?php else: ?>
                                                            <img class="image-responsive"
                                                                 alt="Avatar" style="width: 80%; height: 140px;"
                                                                 src="assets/img/defaultAvatar.png"
                                                            />
                                                        <?php endif; ?>
                                                    </div>
                                                    <!--Card content-->
                                                    <div class="card-body">
                                                        <!--Text-->
                                                        <div class="row" style="padding-top: 10px; padding-bottom: 10px">
                                                            <div class="col-md-12" style="padding-top: 5px; padding-bottom: 5px" >
                                                                <i style="padding-left: 25px ;" class="pe-7s-map-marker"></i>
                                                                <strong><?=($row['city']) ? substr($row['city'],0,20) : "Unknown"?></strong>
                                                            </div>
                                                            <div class="col-md-12 text-center" style="padding-left: 25px ;">
                                                                <a type="button"  class="btn btn-rounded btn-purple" href="<?="profile.php?id={$row['id']}"?>">
                                                                    Invite
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endwhile; ?>
                                </div>

                                <div class="footer">
                                    <!--<hr>-->
                                    <div class="stats">
<!--                                        <i class="fa fa-history"></i> Updated 3 minutes ago-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


     <?php  require_once "includes/bottom.php"; ?>

    </div>
</div>


</body>

<?php require_once "includes/footer.php"; ?>



</html>
