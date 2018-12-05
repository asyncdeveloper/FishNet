<?php
require_once "includes/database.php";
session_start();
require_once "includes/head.php";
?>
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'><link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
<link rel="stylesheet" href="assets/css/chat.css" />
<link rel="stylesheet" href="assets/jGrowl-master/jquery.jgrowl.css" type="text/css"/>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
<body>

<div class="wrapper">
    <div class="sidebar" data-color="#1DC7EA" data-image="assets/img/backgroujdn.jpg">

        <?php  require_once "includes/leftSideBar.php"; ?>

    </div>

    <div class="main-panel">

        <?php  require_once "includes/dashboardNav.php"; ?>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="header">

                                <h4 class="title">Recommended Researchers</h4>
                                <!--<p class="category">Backend development</p>-->
                            </div>
                            <div class="content">
                                <div class="row top-summary">



                                </div>

                                <div class="footer">
                                    <!--<hr>-->
                                    <div class="stats">
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
