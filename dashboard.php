<?php
require_once "includes/database.php";
session_start();
if(empty($_SESSION['username']) || empty($_SESSION['id'])){
    //header("location: login.php");
}

$loggedInUser = mysqli_fetch_array(mysqli_query($connection,"SELECT * from users WHERE id='{$_SESSION['id']}'" ));
if(empty($loggedInUser)){
    //header("location: login.php");
}
if($loggedInUser['country']){
    $loggedInUserCountry = $loggedInUser['country'];
}
if($loggedInUser['state']){
    $loggedInUserState   = $loggedInUser['state'];
}
if($loggedInUser['city']){
    $loggedInUserCity    = $loggedInUser['city'];
}
function format_array($array){
    $array =explode(" ",$array);
    $newArray = array();
    foreach ($array as $value){
        $newArray[]="$value";
    }
    return $newArray;
}
function formatSqlArray($array){
    $string='';
    foreach ($array as $value){
        $string.="'$value',";
    }
    //Remove last occurrence of ,
    $string = removeOccurrence(",","",$string);
    return $string;
}
function removeOccurrence($search, $replace, $subject){
    $pos = strrpos($subject, $search);

    if($pos !== false)
    {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }

    return $subject;
}
if($loggedInUser['species']){
    $loggedInUserSpecies = $loggedInUser['species'];
    $loggedInUserSpecies = str_replace(","," ",$loggedInUserSpecies);
    $loggedInUserSpecies = format_array($loggedInUserSpecies);

    //$loggedInUserSpecies = implode(",",$loggedInUserSpecies);
}
//print_r($loggedInUserSpecies);
//die(1);
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
                                        $recommendedIds = array();
                                        if($loggedInUserSpecies){
                                        //Fetch all users
                                        $sql = "SELECT * FROM users";
                                        $allUsersSet = mysqli_query($connection,$sql);
                                        while ($row = mysqli_fetch_array($allUsersSet)){
                                            if($row['species']){
                                                $userId = $row['id'];
                                                $currentUserSpecies  = $row['species'];
                                                $currentUserSpecies  = str_replace(","," ",$currentUserSpecies);
                                                $currentUserSpecies  = format_array($currentUserSpecies);
                                                //Compare two arrays for common variable
                                                foreach ($loggedInUserSpecies as $val){
                                                    foreach ($currentUserSpecies as $name){
                                                        if($val==$name){
                                                            $recommendedIds[] = $userId;
                                                            break 2;
                                                        }
                                                    }
                                                }

                                            }
                                        }
                                    }
                                        $sql = "SELECT * FROM `users` where user_type!='{$loggedInUser['user_type']}' AND id!={$_SESSION['id']}";
                                        $sql.= " ORDER BY ";
                                        $sqlIds = formatSqlArray($recommendedIds);
                                        if($recommendedIds){
                                            $sql.= " (CASE WHEN users.id IN ($sqlIds) THEN users.id END) DESC ,";
                                        }

                                        if($loggedInUserCity){
                                            $sql.= " (CASE WHEN users.city=$loggedInUserCity THEN users.city END) DESC ,";
                                        }
                                        if($loggedInUserState){
                                            $sql.= " (CASE WHEN users.state=$loggedInUserState THEN users.state END) DESC ,";
                                        }
                                        if($loggedInUserCountry){
                                            $sql.= " (CASE WHEN users.country=$loggedInUserCountry THEN users.country END) DESC ,";
                                        }
                                        $sql.=" date_registered DESC";
                                        $query = mysqli_query($connection,$sql);
                                        echo  mysqli_error($connection);
                                    ?>

                                        <?php while($row = mysqli_fetch_array($query)): ?>
                                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                                <div class="widget card">
                                                    <!--Title-->
                                                    <h5 class="card-title text-center">
                                                        <a href="<?="profile.php?id={$row['id']}"?>">
                                                            <?=ucwords($row['username'])?>
                                                        </a>
                                                        <br><br>
                                                    </h5>
                                                    <!-- end title -->
                                                    <div style="text-align: center; width: -webkit-fill-available" class="imagecontent" >
                                                        <?php if(!empty($row['image'])): ?>
                                                            <img class="image-responsive"
                                                                 alt="Avatar" style="width: 80%; height: 120px; max-width: 140px;"
                                                                 src="<?=$row['image']?>"
                                                            />
                                                            <?php else: ?>
                                                            <img class="image-responsive"
                                                                 alt="Avatar" style="width: 80%; height: 120px; max-width: 140px;"
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
                                                                <?php
                                                                    $country =  $row['country'];
                                                                    //Fetch country Name
                                                                    if($country){
                                                                        $countryName    = mysqli_fetch_array(mysqli_query($connection,"SELECT name FROM countries WHERE id='$country'"));
                                                                        $countryName    = array_shift($countryName);
                                                                    }else
                                                                        $countryName    = "Unknown";
                                                                    //Fetch StateName
                                                                    $state   =  $row['state'];
                                                                    if($state){
                                                                        $stateName      = mysqli_fetch_array(mysqli_query($connection,"SELECT name FROM states WHERE id='$state'"));
                                                                        $stateName      = array_shift($stateName);
                                                                    }else
                                                                        $stateName      = "Unknown";
                                                                ?>
                                                                <strong>
                                                                    <?php
                                                                        if($countryName && $stateName)
                                                                            echo  $stateName.", $countryName";
                                                                        elseif(!$countryName && $stateName)
                                                                            echo  $stateName;
                                                                        elseif($countryName && !$stateName)
                                                                            echo  $countryName;
                                                                        else
                                                                            echo "Unknown";
                                                                    ?>
                                                                </strong>
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
