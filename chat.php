<!DOCTYPE html>
<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>
    <script src="https://use.typekit.net/hoy3lrg.js"></script>

    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'><link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
    <link rel="stylesheet" href="assets/css/chat.css" />
</head>
<?php
require_once "includes/database.php";

if(empty($_SESSION['username']) || empty($_SESSION['id'])){
    header("location: login.php");
}
$loggedInUser = mysqli_fetch_array(mysqli_query($connection,"SELECT * from users WHERE id='{$_SESSION['id']}'" ));
if(empty($loggedInUser)){
    header("location: login.php");
}
//Get connected accepted invites
$contactsResult = mysqli_query($connection,"SELECT * FROM invites WHERE status='1' AND (sender_id='{$_SESSION['id']}' OR reciepient_id='{$_SESSION['id']}' )");
$numberOfContacts = mysqli_num_rows($contactsResult);

?>
<script src="assets/js/jquery.3.2.1.min.js"></script>
<script>
    function disabledEventPropagation(event) {
        if (event.stopPropagation){
            event.stopPropagation();
        }
        else if(window.event){
            window.event.cancelBubble=true;
        }
    }
</script>
<body>

<div id="frame">
    <div id="sidepanel">
        <div id="profile">
            <div class="wrap">
                <?php if($loggedInUser['image']): ?>
                    <img id="profile-img" src="<?=$loggedInUser['image']?>" class="online" alt="" />
                <?php else: ?>
                    <img id="profile-img" src="assets/img/defaultAvatar.png" class="online" alt="" />
                <?php endif; ?>
                <p><?=$loggedInUser['username']?></p>
                <div id="status-options">
                    <ul>
                        <li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>
                        <li id="status-away"><span class="status-circle"></span> <p>Away</p></li>
                        <li id="status-busy"><span class="status-circle"></span> <p>Busy</p></li>
                        <li id="status-offline"><span class="status-circle"></span> <p>Offline</p></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="search">
            <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
            <input type="text" placeholder="Search contacts..." />
        </div>
        <div id="contacts">
            <?php if($numberOfContacts>0): ?>
                <ul id="test">
                    <?php while ($contact = mysqli_fetch_array($contactsResult)):
                        if($contact['sender_id']==$_SESSION['id'])
                            $contactId = $contact['reciepient_id'];
                        else
                            $contactId = $contact['sender_id'];
                        $user = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM users where id='{$contactId}'"));
                        ?>
                        <li class="contact" onclick="showMsg(<?=$user['id']?>)">
                            <div class="wrap">
                                <span class="contact-status busy"></span>
                                <?php if($user['image']): ?>
                                    <img id="profile-img" src="<?=$user['image']?>" class="online" alt="" />
                                <?php else: ?>
                                    <img id="profile-img" src="assets/img/defaultAvatar.png" class="online" alt="" />
                                <?php endif; ?>
                                <div class="meta">
                                    <p class="name"><?=$user['username']?></p>
                                    <p class="preview">
                                        <?=($user['about_me']) ? substr($user['about_me'],0,10) :" . . . "?>
                                    </p>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div id="bottom-bar">
            <button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add contact</span></button>
            <button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button>
        </div>
    </div>
    <div class="content">
        <div class="contact-profile" id="headtop">
            <img src="" alt="" id="user-image" />
            <p id="user-full-name"></p>

        </div>
        <div class="messages">
            <ul>
                <!--<li class="sent">
                    <img src="http://emilcarlsson.se/assets/mikeross.png" alt="" />
                    <p>How the hell am I supposed to get a jury to believe you when I am not even sure that I do?!</p>
                </li>
                <li class="replies">
                    <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                    <p>When you're backed against the wall, break the god damn thing down.</p>
                </li>
                <li class="replies">
                    <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                    <p>Excuses don't win championships.</p>
                </li>
                <li class="sent">
                    <img src="http://emilcarlsson.se/assets/mikeross.png" alt="" />
                    <p>Oh yeah, did Michael Jordan tell you that?</p>
                </li>
                <li class="replies">
                    <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                    <p>No, I told him that.</p>
                </li>
                <li class="replies">
                    <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                    <p>What are your choices when someone puts a gun to your head?</p>
                </li>
                <li class="sent">
                    <img src="http://emilcarlsson.se/assets/mikeross.png" alt="" />
                    <p>What are you talking about? You do what they say or they shoot you.</p>
                </li>
                <li class="replies">
                    <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                    <p>Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you do any one of a hundred and forty six other things.</p>
                </li>-->
            </ul>
        </div>
        <div class="message-input">
            <div class="wrap">
                <input type="text" placeholder="Write your message..." />
                <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
                <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/jquery.3.2.1.min.js"></script>
<script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>

<script >$(".messages").animate({ scrollTop: $(document).height() }, "fast");

     $("#profile-img").click(function() {
         $("#status-options").toggleClass("active");
     });

    $(".expand-button").click(function() {
        $("#profile").toggleClass("expanded");
        $("#contacts").toggleClass("expanded");
    });

    $("#status-options ul li").click(function() {
        $("#profile-img").removeClass();
        $("#status-online").removeClass("active");
        $("#status-away").removeClass("active");
        $("#status-busy").removeClass("active");
        $("#status-offline").removeClass("active");
        $(this).addClass("active");

        if($("#status-online").hasClass("active")) {
            $("#profile-img").addClass("online");
        } else if ($("#status-away").hasClass("active")) {
            $("#profile-img").addClass("away");
        } else if ($("#status-busy").hasClass("active")) {
            $("#profile-img").addClass("busy");
        } else if ($("#status-offline").hasClass("active")) {
            $("#profile-img").addClass("offline");
        } else {
            $("#profile-img").removeClass();
        };

        $("#status-options").removeClass("active");
    });

    function newMessage() {
        message = $(".message-input input").val();
        if($.trim(message) == '') {
            return false;
        }
        //$imgsrc=$('.img1 img').attr('src');
        imageSrc = $('#user-image').attr('src');
        $('<li class="sent"><img src='+imageSrc+' alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
        $('.message-input input').val(null);
        $('.contact.active .preview').html('<span>You: </span>' + message);
        $(".messages").animate({ scrollTop: $(document).height() }, "fast");
        //Save to db
        $.ajax({
            type: "POST",
            url: "saveUserMessages.php",
            data: {id : id},
            success: function (message) {
                updateUI(message);
            },
            error: function () {
            }
        });
    }

    $('.submit').click(function() {
        newMessage();
    });

    $(window).on('keydown', function(e) {
        if (e.which == 13) {
            newMessage();
            return false;
        }
    });

    function showMsg(id) {
        $.ajax({
            type: "POST",
            url: "getUserMessages.php",
            data: {id : id},
            success: function (message) {
                updateUI(message);
            },
            error: function () {
            }
        });
    }
    function updateUI(data) {
        data =JSON.parse(data);
        var onlineStatus;
        if (data.image) {
            onlineStatus = '<span class=\'contact-status busy\'></span>';
            //$('#headtop').append(onlineStatus);
            $("#user-image").attr("src", data.image);
        } else {
            onlineStatus = '<span class=\'contact-status busy\'></span>';
            //$('#headtop').appendChild(onlineStatus);
            $("#user-image").attr("src", "assets/img/defaultAvatar.png");
        }
        if(data.first_name || data.last_name){
            $("#user-full-name").html(data.last_name +" " +data.first_name);
        }else{
            $("#user-full-name").html(data.username);
        }
    }


</script>
</body>
</html>