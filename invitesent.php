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
    <div class="sidebar" data-color="#1DC7EA" data-image="assets/img/backgroujdn.jpg">

        <?php  require_once "includes/leftSideBar.php"; ?>

    </div>

    <div class="main-panel">

        <?php  require_once "includes/dashboardNav.php"; ?>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <?php
                                $result = mysqli_query($connection,"SELECT * FROM invites WHERE sender_id='{$_SESSION['id']}'");
                                if(mysqli_num_rows($result)>0):
                                    ?>
                                    <div class="header">
                                        <?php if($loggedInUser['user_type']=='fisher'): ?>
                                            <h4 class="title">Invitations to Researcher</h4>
                                            <?php else: ?>
                                            <h4 class="title">Invitations to Experts</h4>
                                        <?php endif; ?>
                                    </div>
                                    <div class="content table-responsive table-full-width">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                            <th>Name</th>
                                            <th>Country</th>
                                            <th>State</th>
                                            <th>Date Request Sent</th>
                                            <th>Request Status</th>
                                            </thead>
                                            <tbody>
                                            <?php
                                                while ($expert = mysqli_fetch_array($result)):
                                                    $sid = $expert['sender_id'];
                                                    $rid = $expert['reciepient_id'];
                                                    $userDetails = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM users WHERE id='{$expert['reciepient_id']}'"));
                                                    $country =  $userDetails['country'];
                                                    //Fetch country Name
                                                    if($country){
                                                        $countryName    = mysqli_fetch_array(mysqli_query($connection,"SELECT name FROM countries WHERE id='$country'"));
                                                        $countryName    = array_shift($countryName);
                                                    }else
                                                        $countryName    = "Unknown";
                                                    //Fetch StateName
                                                    $state   =  $userDetails['state'];
                                                    if($state){
                                                        $stateName      = mysqli_fetch_array(mysqli_query($connection,"SELECT name FROM states WHERE id='$state'"));
                                                        $stateName      = array_shift($stateName);
                                                    }else
                                                        $stateName      = "Unknown";
                                                    //Fetch City Name
                                                    $city    =  $userDetails['city'];
                                                    if($city){
                                                        $cityName      = mysqli_fetch_array(mysqli_query($connection,"SELECT name FROM cities WHERE id='$city'"));
                                                        $cityName      = array_shift($cityName);
                                                    }else
                                                        $cityName      = "Unknown";
                                            ?>
                                                <tr>
                                                <td>
                                                    <a href="profile.php?id=<?=$userDetails['id']?>">
                                                        <?=$userDetails['first_name']." ".$userDetails['last_name']?>
                                                    </a>
                                                </td>
                                                    <td><?=$countryName?></td>
                                                    <td><?=$stateName?></td>
                                                <td><?=date("d, F Y",strtotime($expert['date_created']))?></td>
                                                <td>
                                                    <?php if($expert['status']=='0'){
                                                        echo  "Pending";
                                                    } elseif ($expert['status']=='1'){
                                                        echo  "Accepted";
                                                    } elseif ($expert['status']=='4'){
                                                        echo  "Rejected";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                            </tbody>
                                        </table>

                                    </div>
                            <?php  else: ?>
                                <div class="header">

                                    <h4 class="title text-center" style="padding: 20px" >
                                        No Invitations Found
                                    </h4>
                                </div>

                            <?php endif;; ?>
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
