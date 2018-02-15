<!DOCTYPE html>
<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'><link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
    <link rel="stylesheet" href="assets/css/chat.css" />
    <link rel="stylesheet" href="assets/jGrowl-master/jquery.jgrowl.css" type="text/css"/>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
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
<script src="assets/js/timeago.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/jGrowl-master/jquery.jgrowl.js"></script>


<body>
<div id="jGrowl-container1" class="jGrowl top-right"></div>
<div id="frame">
    <div id="topHeader">
        <div id="h1header">
                <ul>
                    <li>FishNet</li>
                </ul>
        </div>
        <div id="ulheader">
            <ul>
                <a href="dashboard.php"><li>Dashboard</li></a>
                <a href="logout.php"><li>Logout</li></a>
            </ul>
        </div>
    </div>
    <div id="sidepanel">
        <div id="profile">
            <div class="wrap">
                <?php if($loggedInUser['image']): ?>
                    <img id="profile-img" src="<?=$loggedInUser['image']?>" class="online" alt="" />
                <?php else: ?>
                    <img id="profile-img" src="assets/img/defaultAvatar.png" class="online" alt="" />
                <?php endif; ?>
                <strong><p><?=$loggedInUser['username']?></p></strong>
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
            <input  type="text" placeholder="Search contacts..." disabled />
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
                        <li class="contact" onclick="showMsg(<?=$user['id']?>)" id="<?=$user['id']?>">
                            <div class="wrap">
                                <?php
                                    $lastLogin = $user['last_login'];
                                    $currentTime = date('Y-m-d H:i:s', time());
                                    $datetime1 = new DateTime($currentTime);
                                    $datetime2 = new DateTime($lastLogin);
                                    $interval = $datetime1->diff($datetime2);
                                    $status;
                                    $hrs  = (int) $interval->format('%i');
                                    $mins = (int)$interval->format('%h');
                                    if($mins == 0 && $hrs==0){
                                        $status =1 ;
                                    }else{
                                        if($mins>2  || $hrs>0)
                                            $status = 0 ;
                                        else
                                            $status = 1 ;
                                    }
                                        if(!$status):
                                    ?>
                                    <span id="span<?=$user['id']?>" class="contact-status offline"></span>
                                <?php else: ?>
                                    <span id="span<?=$user['id']?>" class="contact-status online"></span>
                                <?php endif; ?>
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
        <div class="contact-profile" id="header-user-info">
            <span class="contact-status busy"></span>
            <img src="" alt="" id="user-image" />
            <p id="user-full-name"></p>
            <span id="last-seen" style="padding-left: 10px;font-size: 12px;font-style: italic;display: none;"></span>
            <input type="hidden" id="receiver_id" value="">
        </div>
        <div class="messages">
            <ul id="messages-list">
            </ul>
        </div>
        <div class="message-input">
            <div class="wrap">
                <input id="input-msg" type="text" placeholder="Write your message..." disabled />
                <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
                <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    <div class="site-footer section-spacing">
        <small>© 2018 All rights reserved. Made with <i class="fa fa-heart pulse"></i> by <a href="#">Team FishNet</a></small>
    </div>
</div>
<script>
    $.jGrowl.defaults.closerTemplate = '<div class="alert alert-info">Close All</div>';
    function showNotification(userName,message) {
        var alertTypes = ['success', 'info', 'warning', 'danger'];
        var alertType = alertTypes[1];
        $('#jGrowl-container1').jGrowl({
            header:  userName +' says \n ',
            message: message ,
            group: 'alert-' + alertType,
            life: 5000
        });
    }

    function allNotification() {
        $.ajax({
            type: "POST",
            url: "getNotificationMessages.php",
            success: function (response) {
                var alertTypes = ['success', 'info', 'warning', 'danger'];
                var alertType = alertTypes[1];
                response =JSON.parse(response);
                var len = response.length;
                for (var i=0; i<len; i++) {
                    var userName     = response[i]['username'];
                    var message      = response[i]['message'];
                    setTimeout(function(){
                        $('#jGrowl-container1').jGrowl({
                            header:  userName +' says \n ',
                            message: message ,
                            group: 'alert-' + alertType,
                            life: 3000
                        });
                    }, i*2000);
                }
            },
            error: function () {
            }
        });

    }

    function formatDate(date) {
        var monthNames = [
            "January", "February", "March",
            "April", "May", "June", "July",
            "August", "September", "October",
            "November", "December"
        ];

        var day = date.getDate();
        var monthIndex = date.getMonth();
        var year = date.getFullYear();

        return day + ' ' + monthNames[monthIndex] + ' ' + year;
    }


    function updateMessageUI(response) {
        var len = response.length;
        var loggedInUser  = parseInt('<?=$_SESSION['id']?>');
        for( var i = 0; i<len; i++){
            var id     = parseInt(response[i]['id']);
            var name   =  response[i]['username'];
            var sender = parseInt(response[i]['sender']);
            var msg    = response[i]['message'];
            var time   = response[i]['timeSent'];
            var title  = formatDate(new Date(time));
            var message; var imageSrc;var imageMarkUp;
            showNotification(name,msg);
            if(sender===loggedInUser){
                imageSrc= $('#profile-img').attr('src');
                imageMarkUp ='<img src='+imageSrc+' alt="" />';
                message = '<li id="'+ id + '" class="sent" >'+ imageMarkUp +'<p title="'+title+'" >'+  msg+ '</p></li>';
            }else{
                imageSrc= $('#user-image').attr('src');
                imageMarkUp ='<img src='+imageSrc+' alt="" />';
                message = '<li  id="'+ id + '" class="replies" >'+imageMarkUp+'<p title="'+title+'" >'+  msg+ '</p></li>';
            }
            $("#messages-list").append(message);
        }
    }

    $(document).ready(function() {
        //get Recent Messages
        window.setInterval(function () {
            var activeChatUser = $('#receiver_id').val();
            var lastMsgId = $('#messages-list li:last-child').attr("id");
            if(activeChatUser && lastMsgId){
                //Fetch latest Message
                $.ajax({
                    type: "POST",
                    url: "getRecentMessages.php",
                    data: {
                        id          : activeChatUser,
                        lastMsgId   : lastMsgId
                    },
                    success: function (response) {
                        response =JSON.parse(response);
                        updateMessageUI(response);
                    },
                    error: function () {
                    }
                });
            }
        },5000);
        //Update every 30 seconds
        window.setInterval('updateSideBarInfo()', 30000);
        //Check for generic notification every thirty seconds
        window.setInterval('allNotification()',30000);
    });

    function updateSideBarInfo(){
        //Loop through side bar users and update online status
        var listItems = $("#test li");
        listItems.each(function(idx, li) {
            var liUser = $(li);
            var liUserId = liUser.attr("id");
            $.ajax({
                url: 'getOnlineStatus.php',
                type: 'post',
                data: {id: liUserId},
                dataType: 'json',
                success: function (response) {
                    updateSideBarIcon(response,liUserId);
                }
            });
        });

    }
    function updateSideBarIcon(data,id) {
        //console.log("Seconds since log in",data)
        //alert(data);
        if(data=='0'){
            //Set to offline
            idName = 'span'+id;
            icon = $("body").find('#' + idName);
            icon.removeClass("online");
            icon.addClass("offline");
        }else{
            idName = 'span'+id;
            icon = $("body").find('#' + idName);
            icon.removeClass("offline");
            $("#last-seen").hide();
            icon.addClass("online");
        }
    }
    function newMessage() {
        message = $(".message-input input").val();
        if($.trim(message) == '') {
            return false;
        }
        imageSrc = $('#user-image').attr('src');
        $('<li class="sent"><img src='+imageSrc+' alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
        $('.message-input input').val(null);
        $('.contact.active .preview').html('<span>You: </span>' + message);
        $(".messages").animate({ scrollTop: $(document).height() }, "fast");
        var sender_id    =   '<?=$_SESSION['id']?>';
        var receiver_id  =   $('#receiver_id').val();
        //Save to db
        $.ajax({
            type: "POST",
            url: "saveUserMessages.php",
            data:
                {
                    sender_id   : sender_id,
                    receiver_id : receiver_id,
                    body        : message
                },
            success: function (message) {
                //updateUI(message);
            },
            error: function () {
            }
        });
    }
    function showMsg(id) {
        $('#messages-list').empty();
        $('#input-msg').prop('disabled',false);
        $.ajax({
            type: "POST",
            url: "getUserInfo.php",
            data: {id : id},
            success: function (message) {
                updateUI(message);
            },
            error: function () {
            }
        });
    }
    function lastSeenText(seconds,d1) {
        return jQuery.timeago(d1);
    }
    function updateUI(data) {
        $("#last-seen").hide();
        data =JSON.parse(data);
        $('#receiver_id').val(data.id);
        if (data.image) {
            $("#user-image").attr("src", data.image);
        } else {
            $("#user-image").attr("src", "assets/img/defaultAvatar.png");
        }
        if(data.first_name || data.last_name){
            $("#user-full-name").html(data.last_name +" " +data.first_name);
        }else{
            $("#user-full-name").html(data.username);
        }
        var userLastLogin = data.last_login;
        var d2 = new Date();
        var d1 = new Date(userLastLogin);
        var seconds =  parseInt((d2- d1)/1000);
        //If use last seen greater than a minute set to offline
        var isOnline = parseInt(data.isActive);
        if(!isOnline){
            //Set to offline
            idName = 'span'+data.id;
            icon = $("body").find('#' + idName);
            icon.removeClass("online");
            icon.addClass("offline");
            $("#last-seen").text(lastSeenText(seconds,d1));
            $("#last-seen").show();
        }else{
            //Set to online
            idName = 'span'+data.id;
            icon = $("body").find('#' + idName);
            icon.removeClass("offline");
            icon.addClass("online");
            $("#last-seen").text("Online");
            $("#last-seen").show();
        }
        getAllMessages(data.id);
    }
    function getAllMessages(id) {
        $.ajax({
            type: "POST",
            url: "getUserMessages.php",
            data: {id : id},
            success: function (response) {
                response =JSON.parse(response);
                var len = response.length;
                var loggedInUser  = parseInt('<?=$_SESSION['id']?>');
                $("#messages-list").empty();
                for( var i = 0; i<len; i++){
                    var id     = parseInt(response[i]['id']);
                    var sender = parseInt(response[i]['sender']);
                    var msg    = response[i]['message'];
                    var time   = response[i]['timeSent'];
                    var title  = formatDate(new Date(time));
                    var message; var imageSrc;var imageMarkUp;
                    if(sender===loggedInUser){
                        imageSrc= $('#profile-img').attr('src');
                        imageMarkUp ='<img src='+imageSrc+' alt="" />';
                        message = '<li id="'+ id + '" class="sent" >'+ imageMarkUp +'<p title="'+title+'" >'+  msg+ '</p></li>';
                    }else{
                        imageSrc= $('#user-image').attr('src');
                        imageMarkUp ='<img src='+imageSrc+' alt="" />';
                        message = '<li  id="'+ id + '" class="replies" >'+imageMarkUp+'<p title="'+title+'" >'+  msg+ '</p></li>';
                    }
                    $("#messages-list").append(message);
                }
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

    $(".messages").animate({ scrollTop: $(document).height() }, "fast");

</script>

</body>
</html>