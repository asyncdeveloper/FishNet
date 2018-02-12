
<nav class="navbar navbar-default navbar-fixed">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">FishFarm</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-dashboard"></i>
                        <p class="hidden-lg hidden-md">Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="fa fa-search"></i>
                        <p class="hidden-lg hidden-md">Search</p>
                    </a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="register.php">
                        <p>Register</p>
                    </a>
                </li>
                <li>
                    <a href="login.php">
                        <p>Login</p>
                    </a>
                </li>
                <li class="separator hidden-lg hidden-md"></li>
            </ul>
        </div>
    </div>
</nav>
<!--<div class="main-panel">
    <nav class="navbar navbar-default navbar-fixed">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">FishFarm</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-dashboard"></i>
                            <p class="hidden-lg hidden-md">Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="fa fa-search"></i>
                            <p class="hidden-lg hidden-md">Search</p>
                        </a>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="register.php">
                            <p>Register</p>
                        </a>
                    </li>
                    <li>
                        <a href="login.php">
                            <p>Login</p>
                        </a>
                    </li>
                    <li class="separator hidden-lg hidden-md"></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="header">
                            <h4 class="title text-center">Register on FishFarm </h4>
                        </div>
                        <div class="content">
                            <form action="register.php" method="POST">
                                <?php /*if(isset($_REQUEST['err'])): */?>
                                    <?php /*if($_REQUEST['err']='1'): */?>
                                        <div class="alert alert-danger">
                                            <?php /*echo  "Password must be equal "; */?>
                                        </div>
                                    <?php /*elseif($_REQUEST['err']='2'): */?>
                                        <div class="alert alert-danger">
                                            <?php /*echo  "Cannot save, check network status "; */?>
                                        </div>
                                    <?php /*endif; */?>
                                <?php /*elseif (isset($_REQUEST['success'])): */?>
                                    <div class="alert alert-success">
                                        <?php /*echo  "Account Created Successfully, Redirecting ..."; */?>
                                        <script>
                                            setTimeout( function(){
                                                window.location='login.php'
                                            }, 2500);
                                        </script>
                                    </div>
                                <?php /*endif; */?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" placeholder="Researcher" name="email" required minlength="6" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" class="form-control" placeholder="Username" name="username" minlength="6" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password" required minlength="6"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input type="password" class="form-control" name="cpassword" required minlength="6"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>User type</label>
                                            <select name="type" id="type" class="form-control" required>
                                                <option  selected disabled value="">Choose register type</option>
                                                <option value="researcher">Researcher</option>
                                                <option value="fisherman">Fisherman</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="submit" class="btn btn-info btn-fill">Register
                                    </button>
                                </div>

                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <?php /*require_once "includes/bottom.php"; */?>

</div>-->