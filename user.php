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
if(isset($_POST['submit'])){
    $username       = $_POST['username'];
    $firstname      = $_POST['firstname'];
    $lastname       = $_POST['lastname'];
    $country        = $_POST['country'];
    $city           = $_POST['city'];
    $address        = $_POST['address'];
    $postalCode     = $_POST['postalcode'];
    $aboutMe        = $_POST['about_me'];
    $species        = $_POST['species'];
    if($loggedInUser['type']='fisher'){
        $status = mysqli_query($connection,"UPDATE users SET username='$username',first_name='$firstname',last_name='$lastname',
        species='$species',country='$country',city='$city',address='$address',postal_code='$postalCode',about_me='$aboutMe' WHERE id='{$_SESSION['id']}' ");
        if($status){
            header("location: user.php?success");
        }
    }else{
        $status = mysqli_query($connection,"UPDATE users SET username='$username',first_name='$firstname',last_name='$lastname',
        species='$species',country='$country',city='$city',address='$address',postal_code='$postalCode',about_me='$aboutMe' WHERE id='{$_SESSION['id']}' ");
        if($status){
            header("location: user.php?success");
        }
    }
}
require_once "includes/head.php";
?>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="assets/img/backgroujdn.jpg">
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
                                <h4 class="title">Edit Profile</h4>
                            </div>
                            <div class="content">
                                <?php if (isset($_REQUEST['success'])): ?>
                                    <div class="alert alert-success">
                                        <?php echo  "Profile updated successfully"; ?>
                                        <script>
                                            setTimeout( function(){
                                                window.location='dashboard.php'
                                            }, 2500);
                                        </script>
                                    </div>
                                <?php endif; ?>

                                <form action="<?=$_SERVER['PHP_SELF']?>" method="post" >
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Username </label>
                                                <input type="text" name="username" class="form-control" placeholder="Company" value="<?=$loggedInUser['username']?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input name="firstname" type="text" class="form-control" placeholder="First Name" value="<?=$loggedInUser['first_name']?>" maxlength="100">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input name="lastname" type="text" value="<?=$loggedInUser['last_name']?>" class="form-control" placeholder="Last Name"  maxlength="100">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input required type="text" class="form-control" placeholder="Country" value="<?=$loggedInUser['country']?>" name="country" maxlength="100">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input required type="text" class="form-control" placeholder="City" value="<?=$loggedInUser['city']?>" name="city">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="form-control" placeholder="Home Address" value="<?=$loggedInUser['address']?>" name="address">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                                <input type="number" class="form-control" placeholder="ZIP Code" value="<?=$loggedInUser['postal_code']?>" maxlength="10" name="postalcode">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <?php if($loggedInUser['user_type']=='fisher'):?>
                                                    <label>Species Owned <sub style="color: red">*Separate with comma</sub></label>
                                                    <input type="text" class="form-control" placeholder="Mackrel" value="<?=$loggedInUser['species']?>"  name="species">
                                                <?php else: ?>
                                                    <label>Species Researching on <sub style="color: red">*Separate with comma</sub></label>
                                                    <input type="text" class="form-control" placeholder="Mackrel" value="<?=$loggedInUser['species']?>"  name="species">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>About Me</label>
                                                <textarea rows="5" class="form-control" placeholder="Here can be your description" name="about_me"><?=$loggedInUser['about_me']?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button name="submit" type="submit" class="btn btn-success btn-fill">Update Profile</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-user">
                            <div class="image">
                                <div id="feedback" class="alert alert-danger text-center " style="display:none;"></div>
                                <div id="success" class="alert alert-success text-center " style="display:none;"></div>
                            </div>
                            <div class="content">
                                <div class="author">
                                    <input type="file" style="display:none;" id="profilefoto" name="profile" >
                                    <a href="#">
                                        <?php if($loggedInUser['image']): ?>
                                            <div class="profile-picture" id="imgPreview">
                                                <img class="avatar border-gray" src="<?=$loggedInUser['image']?>" alt="..."/><br>
                                                <a href="javascript:document.getElementById('profilefoto').click(); ">Upload portrait</a>
                                            </div>
                                        <?php else: ?>
                                            <div class="profile-picture" id="imgPreview">
                                                <img class="avatar border-gray" src="assets/img/defaultAvatar.png" alt="..."/><br>
                                                <a href="javascript:document.getElementById('profilefoto').click(); ">Upload portrait</a>
                                            </div>
                                        <?php endif; ?>


                                        <h4 class="title"><?=$loggedInUser['first_name']." ".$loggedInUser['last_name']?><br />
                                            <small><?=$loggedInUser['username']?></small>
                                        </h4>
                                    </a>
                                </div>
                                <p class="description text-center">
                                    <?=$loggedInUser['about_me']?>
                                </p>
                                <p class="description text-center">
                                    <strong>Role: &nbsp;<?=ucwords($loggedInUser['user_type'])?></strong>
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
