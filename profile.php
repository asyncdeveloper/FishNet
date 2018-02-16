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
function checkIfMatches($currentPageUserId,$loggedInUser,$connection){
    $currentUser = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM users WHERE id='$currentPageUserId' "));
    $currentUserSpecies  =explode(",",$currentUser['species']);
    $loggedInUserSpecies = explode(",",$loggedInUser['species']);
    $possible=0;
    foreach ($loggedInUserSpecies as $val){
        foreach ($currentUserSpecies as $single){
            if($val==$single){
                $possible+=1;
            }
        }
    }
    if(empty($currentUserSpecies) || empty($loggedInUserSpecies)){
        return 0;
    }
    if($possible){
        return 1;
    }else{
        return 0;
    }

}
if(isset($_REQUEST['id'])){
    $id = $_REQUEST['id'];
    if(!intval($id))
        header("location: dashboard.php");
    elseif ($id==$_SESSION['id'])
        header("location: dashboard.php");
    else{
        $result = checkIfMatches($id,$loggedInUser,$connection);
    }
}
if(isset($_POST['submit'])){
    $senderId = $_SESSION['id'];
    $recipientId = $_POST['reciepient_id'];
    //Save to database
    $status = mysqli_query($connection,"INSERT INTO invites(sender_id,reciepient_id) VALUES('$senderId','$recipientId')");
    if($status){
        header("location:profile.php?id=$recipientId&success");
    }
}

$currentUser = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM users WHERE id='$id' "));
$country =  $currentUser['country'];
//Fetch country Name
if($country){
    $countryName    = mysqli_fetch_array(mysqli_query($connection,"SELECT name FROM countries WHERE id='$country'"));
    $countryName    = array_shift($countryName);
}else
    $countryName    = "Unknown";
//Fetch StateName
$state   =  $currentUser['state'];
if($state){
    $stateName      = mysqli_fetch_array(mysqli_query($connection,"SELECT name FROM states WHERE id='$state'"));
    $stateName      = array_shift($stateName);
}else
    $stateName      = "Unknown";
//Fetch City Name
$city    =  $currentUser['city'];
if($city){
    $cityName      = mysqli_fetch_array(mysqli_query($connection,"SELECT name FROM cities WHERE id='$city'"));
    $cityName      = array_shift($cityName);
}else
    $cityName      = "Unknown";

require_once "includes/head.php";
?>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="#1DC7EA" data-image="assets/img/sidebar-5.jpg">
        <?php require_once "includes/leftSideBar.php"; ?>
    </div>

    <div class="main-panel">

        <?php require_once "includes/dashboardNav.php"; ?>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title text-center">User Profile</h4>
                            </div>
                            <div class="content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <p><?=($currentUser ['first_name']) ? $currentUser ['first_name'] : "Unknown" ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <p><?=($currentUser ['last_name']) ? $currentUser ['last_name'] : "Unknown" ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <p><?php echo $countryName; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>State</label>
                                                <p><?php echo $stateName; ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>City</label>
                                                <p><?php echo $cityName; ?></p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <p><?=($currentUser ['address']) ? $currentUser ['address'] : "Unknown" ?></p>
                                            </div>
                                        </div>

                                    </div>

                                <?php if($currentUser ['type']='fisher'):?>
                                    <label>Species Owned</label>
                                <?php else: ?>
                                    <label>Species Researching On</label>
                                <?php endif; ?>
                                <br>
                                <?php
                                    $skills = explode(",",$currentUser ['species']);
                                    if(!empty($skills[0])):
                                        for($i=0 ; $i<50 ;$i++):
                                            if(!empty($skills[$i])):
                                                ?>
                                                <span class="label label-success">
                                                    <?php
                                                        echo ucwords($skills[$i]);
                                                    ?>
                                                </span>
                                            &nbsp;
                                            <?php endif;  ?>
                                        <?php endfor;  ?>
                                    <?php else: ?>
                                        <p>Unknown</p>
                                <?php endif; ?>
                                <br><br><br><br>
                                    <div class="clearfix"></div>

                                    <?php if(isset($_REQUEST['success'])): ?>
                                        <div class="text-center">
                                            <script>
                                                setTimeout( function(){
                                                    window.location='profile.php?id'.<?=$id?>;
                                                }, 2000);
                                            </script>
                                        </div>
                                    <?php endif; ?>
                                <?php
                                    //Check if invite already sent
                                    $resultSet = mysqli_query($connection, "SELECT status from invites WHERE sender_id='{$_SESSION['id']}' AND reciepient_id='$id'");
                                    if(mysqli_num_rows($resultSet)>0){
                                        $status= mysqli_fetch_array($resultSet);
                                        $status = array_shift($status);
                                        if($status)
                                            $status=1;
                                        else
                                            $status=0;
                                    }else{
                                        $status=2;
                                    }
                                ?>
                                <div class="text-center">
                                    <?php if($result): ?>
                                        <?php if($status==2): ?>
                                            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                                                <input type="hidden" name="reciepient_id" value="<?=$id?>" >
                                                <button name="submit" type="submit" class="btn btn-info btn-fill" >Proceed to Invite</button>
                                            </form>
                                        <?php else: ?>
                                            <button name="submit" type="submit" class="btn btn-success btn-fill" >Invite Sent</button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                            <button name="submit" type="submit" class="btn btn-danger btn-fill">Cannot Invite No Connection Found</button>
                                    <?php endif;  ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-user">
                            <div class="image">

                            </div>
                            <div class="content">
                                <div class="author">
                                    <a href="#">
                                        <?php if($currentUser ['image']): ?>
                                            <img class="avatar border-gray" src="<?=$currentUser ['image']?>" alt="..."/><br>
                                        <?php else: ?>
                                            <img class="avatar border-gray" src="assets/img/defaultAvatar.png" alt="..."/><br>
                                        <?php endif; ?>
                                        <h4 class="title"><?=$currentUser ['first_name']." ".$currentUser ['last_name']?><br />
                                            <small><?=$currentUser ['username']?></small>
                                        </h4>
                                    </a>
                                </div>
                                <p class="description text-center">
                                    <?=$currentUser ['about_me']?>
                                </p>
                                <p class="description text-center">
                                    <strong>Role:&nbsp;
                                        <?php
                                            echo ($currentUser['user_type']=='fisher') ? ucwords("Expert") : "Researcher" ;
                                        ?>
                                    </strong>
                                </p>
                            </div>
                            <hr>
                            <div class="text-center">
                                <button href="#" class="btn btn-simple"><i class="fa fa-facebook-square"></i></button>
                                <button href="#" class="btn btn-simple"><i class="fa fa-twitter"></i></button>
                                <button href="#" class="btn btn-simple"><i class="fa fa-google-plus-square"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <?php require_once "includes/bottom.php"; ?>

    </div>
</div>


</body>

<?php require_once "includes/footer.php" ?>
<script>
    $(document).ready(function() {
        $("#profilefoto").on('change',function () {
            var imgItem    =    $(this)[0].files;
            var imgCount   =    $(this)[0].files.length;
            var imgPath    =    $(this)[0].value;
            var imgExt     =    imgPath.substring(imgPath.lastIndexOf('.')+1).toLowerCase();
            var imgPreview =    $("#imgPreview");
            var upload ="<a href=\"javascript:document.getElementById('profilefoto').click(); \">Upload portrait</a><br>";
            imgPreview.empty();
            if(imgExt=="gif" || imgExt=="jpg" || imgExt=="png" || imgExt=="jpeg" || imgExt=="bmp"){
                if(typeof(FileReader)!="undefined"){
                    for(var i=0 ; i<imgCount ; i++ ){
                        var reader = new FileReader();
                        var fn = imgItem[i].name;
                        var fs = imgItem[i].size;
                        var upload="<a href=\"javascript:document.getElementById('profilefoto').click(); \">Upload portrait</a><br>";
                        reader.onload = function (e) {
                            $(" <img />",{
                                "src":e.target.result,
                                "width": "116",
                                "height": "116",
                                "alt": "profile photo"
                            },).appendTo(imgPreview);
                            $("<br>"+upload).appendTo(imgPreview);
                        };
                        imgPreview.show();
                        reader.readAsDataURL($(this)[0].files[i]);
                        //save to db
                        var files   = $("#profilefoto")[0].files;

                        //Declaring new Form Data Instance
                        var formData = new FormData();

                        //Looping through uploaded files collection in case there is a Multi File Upload. This also works for single i.e simply remove MULTIPLE attribute from file control in HTML.
                        for (var j = 0; j < files.length; j++) {
                            formData.append(files[j].name, files[j]);
                        }
                        $.ajax({
                            url: "updateimage.php", //You can replace this with MVC/WebAPI/PHP/Java etc
                            method: "post",
                            enctype: 'multipart/form-data',
                            data:  formData,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                Element.prototype.documentOffsetTop = function () {
                                    return this.offsetTop + ( this.offsetParent ? this.offsetParent.documentOffsetTop() : 0 );
                                };
                                var f = document.getElementById("feedback");
                                var top = f.documentOffsetTop() - ( window.innerHeight / 2 );
                                if(response=='1') {
                                    document.getElementById("feedback").style.display = "none";
                                    document.getElementById("success").style.display = "block";
                                    message = "Image Updated Successfully";
                                    $("#success").html(message);
                                    setTimeout( function(){
                                        document.getElementById("success").style.display="none";
                                    }, 5000);
                                }
                                else if(response=='-2'){
                                    document.getElementById("success").style.display="none";
                                    document.getElementById("feedback").style.display="block";
                                    message = "Uploaded Image Too Large (5MB Max) ";
                                    $("#feedback").html(message);
                                    setTimeout( function(){
                                        document.getElementById("feedback").style.display="none";
                                    }, 5000);
                                }
                                else if(response=='-3'){
                                    document.getElementById("success").style.display="none";
                                    document.getElementById("feedback").style.display="block";
                                    message = "Uploaded Image Not Supported (JPEG/PNG only) ";
                                    $("#feedback").html(message);
                                    setTimeout( function(){
                                        document.getElementById("feedback").style.display="none";
                                    }, 5000);
                                }
                                else{
                                    document.getElementById("success").style.display="none";
                                    document.getElementById("feedback").style.display="block";
                                    message = "Unable To Update Profile";
                                    $("#feedback").html(message);
                                    setTimeout( function(){
                                        document.getElementById("feedback").style.display="none";
                                    }, 5000);
                                }
                            },
                            error: function () {
                                document.getElementById("success").style.display="none";
                                document.getElementById("feedback").style.display="block";
                                message = "Unfortunately, an error occurred";
                                $("#feedback").html(message);
                                setTimeout( function(){
                                    document.getElementById("feedback").style.display="none";
                                }, 5000);
                            }
                        });
                    }
                }
                else{
                    imgPreview.html("Browser not supported");
                    $("<br><br><br><br>"+upload).appendTo(imgPreview);
                }
            }
            else{
                imgPreview.html("File uploaded not supported");
                $("<br><br><br><br>"+upload).appendTo(imgPreview);
            }
        });
    });
</script>

</html>
