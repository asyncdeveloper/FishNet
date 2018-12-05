<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="assets/img/favicon1.ico">
<title>FishNet | Where Expert and Researchers Connect</title>
<meta name="description" content="Find any fish profiles / details">
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="assets/css/main.css" rel="stylesheet">
</head>
<script src="assets/js/jquery.3.2.1.min.js"></script>
<style>
  div{
    margin-bottom: 10px;
  }
</style>
<script>
  var dots = window.setInterval( function() {
    var wait = document.getElementById("wait");
    if(document.getElementById("wait") == null){
      clearInterval(dots);
    }
    if ( wait.innerHTML.length > 3 ) 
        wait.innerHTML = "";
    else 
        wait.innerHTML += ".";
    }, 1500);
  let arrayOfResult;
  fetch("https://fishbase.ropensci.org/species?limit=1000")
        .then(res => res.json())
        .then(res => {
          arrayOfResult = res.data;
          console.log("response is back!");
          for (ress of res.data) {
            if (ress.FBname == null) {
              continue;
            } else {
              document.getElementById("fishes").innerHTML +=
                `<option>${
                ress.FBname
              }</option>`;
            }
          }
          console.log("done");
          document.getElementById('infoMessage').innerHTML = "Done! , Now you can search";
        })
        .catch(err => {
          console.log(err);
        });
    function searchForSpecie(){
        var query = document.getElementById('searchName').value;
        $('#hideThis').css('display', 'none');
        $('#displaySearchResult').css('display', 'block');
        let result = arrayOfResult.filter(x => x.FBname == query);
        document.getElementById('name').innerHTML = result[0].FBname;
        document.getElementById('comments').innerHTML= result[0].Comments;
        document.getElementById('genius').innerHTML= result[0].Genus;
        document.getElementById('specie').innerHTML = result[0].Species;
        document.getElementById('length').innerHTML = result[0].Length;
        document.getElementById('dangerous').innerHTML= result[0].Dangerous;
        document.getElementById('ability').innerHTML = result[0].Electrogenic;
        document.getElementById('usedAsBait').innerHTML = result[0].UsedasBait;
        document.getElementById('usedForAquaculture').innerHTML = result[0].UsedforAquaculture;
    }
</script>
<body>
	<!--main-->
<section class="main">
  <div class="overlay"></div>
  <div class="container">
      <nav class="navbar">
        <div class="container-fluid">
          <div class="navbar-header logo">
            <h1><a class="navbar-brand" href="index.php">FishNet</a></h1>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
            </button>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
          <!-- <div> -->
            <ul class="nav navbar-nav  navbar-right">
                <?php
                require_once "includes/database.php";
                session_start();
                if (!isset($_SESSION['id'])) :
                ?>
                          <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> <strong>Sign Up</strong> </a></li>
                          <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span><strong> Login</strong></a></li>
                    <?php else : ?>
                        <li>
                            <a href="dashboard.php"><span class="glyphicon glyphicon-user"></span>
                                <strong><?= ucwords($_SESSION['username']) ?></strong> </a>
                        </li>
                        <li>
                            <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>
                                <strong>Logout</strong> </a>
                        </li>

                    <?php endif; ?>
            </ul>
          </div>
        </div>
      </nav>
      <div class="row">
        <div class="col-md-12">
          <header class="welcome-message text-center">
            <h1 id="infoMessage"><span>Please wait while we Get Species data.</span><span id="wait">.</span></h1>
          </header>
          <div class="sub-form text-center">
            <div class="row" ng-app>
              <div class="col-md-5 center-block col-sm-8 col-xs-11">
                  <div class="input-group">
                    <input type="text" ng-model="name" list="fishes" id="searchName" class="form-control" placeholder="Name">
                    <datalist id="fishes"></datalist>
                    <span class="input-group-btn">
                    <button type="submit" class="btn btn-default" value="Search" name="search" onclick="searchForSpecie()">
                        Search
                        <i class="fa fa-search">

                        </i>
                    </button>
                    </span> </div>
                <p id="angular-component" class="alert">I am looking for {{name}}</p>
              </div>
            </div>
          </div>
          <!--sub-form end-->
                </div>
              </div>
            </div>
          </section>
          <!--main end-->

          <!--Fishes collection-->

          <section class="features section-spacing">
            <div class="container">
              <div id="displaySearchResult" class="textBig" style="display: none;">
                <h2 class="text-center">Result</h2>
                <div class="row">
                  <div class="col-md-4">
                    <strong>Name</strong>
                  </div>
                  <div class="col-md-8">
                    <p id="name"></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <strong>Description</strong>
                  </div>
                  <div class="col-md-8">
                    <p id="comments"></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <strong>Genius</strong>
                  </div>
                  <div class="col-md-8">
                    <p id="genius"></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <strong>Specie</strong>
                  </div>
                  <div class="col-md-8">
                    <p id="specie"></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <strong>Length</strong>
                  </div>
                  <div class="col-md-8">
                    <p id="length"></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <strong>Dangerous Status</strong>
                  </div>
                  <div class="col-md-8">
                    <p id="dangerous"></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <strong>Abilities</strong>
                  </div>
                  <div class="col-md-8">
                    <p id="ability"></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <strong>Used As Bait</strong>
                  </div>
                  <div class="col-md-8">
                    <p id="usedAsBait"></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <strong>Used for Aquaculture</strong>
                  </div>
                  <div class="col-md-8">
                    <p id="usedForAquaculture"></p>
                  </div>
                </div>
              </div>
              <div id="hideThis">
              	<div class="row">
              	  <div class="col-md-12 wow fadeInUp product-features row textBig">
              	        <h1>About Us&nbsp <i class="fa fa-info"></i></h1>
              	        <p>
              	          The FishNET is a knowledge sharing platform with premium news, analysis and resources for the aquaculture and commercial fishing industries. I
              	          Our international team of contributors are guided by our vision for aquaculture, reporting on the economics, environment and ethics of contemporary food chain challenges. We challenge the status quo to create understanding, opportunity and innovation for both user.
              	        </p>
              	  </div>
              	</div>
              	  <div class="row">
              	  <div class="col-md-12 wow fadeInUp product-features row textBig">
              	          <h1>AIM&nbsp <i class="fa fa-bullseye"></i></h1>
              	          <p>
              	            As the world wrestles with the challenge of feeding a vast and growing population, there is an urgent need to professionalise and modernise aquaculture. Oceans cover 70 percent of the world’s surface, but only produce two percent of our food, making the aquaculture industry the fastest growing form of protein production. It helps to control the mortality rate of fishes due to knowledge acquired from the platform  and also lead to new discovery of fishes.
              	          </p>
              	  </div>
              	</div>
              	<div class="row">
              	  <div class="col-md-12 wow fadeInUp product-features row textBig">
              	    <h1>Statistic&nbsp <i class="fas fa-chart-line"></i></h1>
              	    <p>
              	      According to the Food and Agriculture Organization (FAO), the world harvest  in 2005 consisted of 93.3 million tonnes captured by commercial fishing in wild fisheries, plus 48.1 million tonnes produced by fish farms. In addition, 1.3 million tons of aquatic plants (seaweed etc.) were captured in wild fisheries and 14.8 million tons were produced by aquaculture.The number of individual fish caught in the wild has been estimated at 0.97-2.7 trillion per year (not counting fish farms or marine invertebrates).
              	    </p>
              	  </div>
              	  </div>
              </div>

            </div>
          </section>

          <!--Fishes collection end-->
          <footer class="site-footer section-spacing">
            <div class="container">
              <div class="row">
                <div class="col-md-12 text-center">
                  <small class="wow fadeInUp">© 2018 All rights reserved. Made with <i class="fa fa-heart pulse"></i> by <a href="#">Team FishNet</a></small> </div>
              </div>
            </div>
          </footer>
          <!--site-footer end-->

          <!--PRELOAD-->
          <div id="preloader">
            <div id="status"></div>
          </div>
          <!--end PRELOAD-->

          <script src="assets/js/jquery-1.11.1.min.js"></script>
          <script src="assets/js/jquery.backstretch.min.js"></script>
          <script src="assets/js/wow.min.js"></script>
          <script src="assets/js/jquery.simple-text-rotator.min.js"></script>
          <script src="assets/js/main.js"></script>
          <script src="assets/js/bootstrap.min.js"></script>
          <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>
          </body>
          </html>