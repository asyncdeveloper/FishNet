<?php require_once "database.php"; ?>
<div class="sidebar-wrapper">
    <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text">
            <?=$loggedInUser['username']?>
        </a>
    </div>

    <ul class="nav">

        <li <?php if(basename($_SERVER['PHP_SELF'])=='dashboard.php') echo"class='active'";?>>
            <a href="dashboard.php">
                <i class="pe-7s-graph"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li <?php if(basename($_SERVER['PHP_SELF'])=='user.php') echo"class='active'";?>>
            <a href="user.php">
                <i class="pe-7s-user"></i>
                <p>User Profile</p>
            </a>
        </li>
        <li <?php if(basename($_SERVER['PHP_SELF'])=='invitereceived.php') echo"class='active notification-link flex space-between items-center no-column no-wrap'";?>>

            <a href="invitereceived.php">
                <i class="pe-7s-note2"></i>
                <p>
                    Invitation Received
                   &nbsp;<span style="color: red">
                        <?php
                        $notif = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM invites WHERE reciepient_id='{$_SESSION['id']}'"));
                        if($notif){
                            echo $notif;
                        }
                        ?>
                    </span>
                </p>
            </a>
        </li>
        <li <?php if(basename($_SERVER['PHP_SELF'])=='invitesent.php') echo"class='active'";?>>
            <a href="invitesent.php">
                <i class="pe-7s-note2"></i>
                <p>Invitation Sent</p>
            </a>
        </li>


    </ul>
</div>