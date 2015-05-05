<?php
ob_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
  </head>
  
 
  
  <body>

    <?php
    session_start();
    if(!isset($_SESSION["username"]))
    {
      header("Location:home.php");
    }
    ?> <div class="header">
      <div id="amazon-logo">
        <img src="images/amazon-logo.jpg" style="height:60px">
      </div>
      <div id="user">
        <!-- user is already signed in then the username will be that username,
         else username will be "Sign In" 
        -->
    </div>

      <div class="centered-logo" style="margin:1% 41%">
        <img src="images/amazon-logo.jpg" style="height:60px">
      </div>
       <div class="navbar">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-tab"><a href="home.php">Buy a Kindle</a></li>
        <li class="nav-tab"><a href="books.php">Kindle eBooks</a></li>
        <li class="nav-tab"><a href="search.php">Advanced Search</a></li>
        <li class="nav-tab"><a href="about.php">About</a></li>        
      </ul>
    </div>
        <div class="container">
      <div id="errorDiv" style="display:none; color:red; text-align:center;">
      </div>
      <div class="form-container" id="form-container" background-color="black">
        <h2 class="piece-heading text-center"><b>Change Password</b></h2>
        <form class="form-horizontal" role="form" action="changePassword.php" method="Post">

          <div class="form-piece">
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Current Password:</label>
              <div class="col-sm-10">          
                <input type="password" class="form-control" id="pwd" placeholder="Enter Password" name="curpass" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">New Password:</label>
              <div class="col-sm-10">          
                <input type="password" class="form-control" id="pwd" placeholder="Enter Password" name="pass" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Retype Password:</label>
              <div class="col-sm-10">          
                <input type="password" class="form-control" id="pwd" placeholder="Enter Password" name="repass" required>
              </div>
            </div>
          </div>

          <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" class="btn btn-default" value="Submit" >
            </div>
          </div>

        </form>
      </div>
    </div>
    <?php
      session_start();
      if(isset($_POST["curpass"]) and isset($_SESSION["username"]))
      {
      $curpass=$_POST["curpass"];
      $username=$_SESSION["username"];
              try
              {
                 $db = new PDO("mysql:host=localhost;dbname=KINDLE", "root", "99isthebest");

              }
              catch(PDOException $e) {
          printf("We had a problem: %s\n", $e->getMessage());
                  }
              try
              {
                $sel1 = $db->prepare("select Password from Users where User_Name= '".$username."'");
                $sel1->execute();
                $actpass=$sel1->fetchColumn();
                if($actpass!=$curpass)
                {
                  echo "<script>
                  a=document.getElementById('errorDiv');
                  a.innerHTML='Wrong password';
                  a.style.display='block';
                  </script>";
                  exit;
                }
              }

              catch(PDOException $e) {
          printf("We had a problem: %s\n", $e->getMessage());
                  }

        $pass=$_POST["pass"];
        $repass=$_POST["repass"];
                if($pass!=$repass)
            {
              
                  echo "<script>
                  a=document.getElementById('errorDiv');
                  a.innerHTML='Passwords do not match';
                  a.style.display='block';
                  </script>";
              exit;
            }
            if(strlen($pass)<7)
            {
              
                  echo "<script>
                  a=document.getElementById('errorDiv');
                  a.innerHTML='Password must be atleast 7 digits long';
                  a.style.display='block';
                  </script>";;
              exit;
            }
            try
              {
                 $up1 = $db->prepare("update Users set Password= '".$pass."' where User_Name= '".$username."'");
                 $up1->execute();                 
                  session_unset();
                  session_destroy();
                 echo "<script>
                   a=document.getElementById('errorDiv');
                  a.innerHTML='Password successully changed';
                  a.style.color='green';
                  a.style.display='block';
                  </script>";
                  echo "<div style='width=100%; text-align:center;'><a href='userLogin.php'>Please Log In</a></div>";
              exit;


              }
              catch(PDOException $e) {
          printf("We had a problem: %s\n", $e->getMessage());
                  }


    }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </body>

</html>
