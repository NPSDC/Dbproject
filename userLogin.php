<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">



  </head>
<?php 
session_start();
if(isset($_SESSION))
{
  session_unset();
  session_destroy();
}
?>
  <body>
    <div class="container">
      <div class="centered-logo" style="margin:1% 41%">
        <img src="images/amazon-logo.jpg" style="height:60px">
      </div>
      <div id="errorDiv" style="display:none; color:red">
        Invalid User/Password
      </div>
      <div class="form-container" background-color="black">
        <h2 class="piece-heading text-center"><b>Login</b></h2>
        <form method="POST" action="" class="form-horizontal" role="form"  >

          <div class="form-piece">
            <div class="form-group">
              <label class="control-label col-sm-2" for="email">Username:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="email" placeholder="Enter Username" name="user1" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Password:</label>
              <div class="col-sm-10">          
                <input type="password" class="form-control" id="pwd" placeholder="Enter Password" name="pass1" required>
              </div>
            </div>
          </div>

          <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" class="btn btn-default form-submit" value="Enter" name="submit">
            </div>
          </div>

        </form>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <?php
if(isset($_POST["submit"]))
{
 $username=$_POST["user1"];
 $password=$_POST["pass1"];
$username=addslashes($username);
$password=addslashes($password);

try {
  $db = new PDO("mysql:host=localhost;dbname=KINDLE", "root", "123");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  
catch (PDOException $e) {
  printf("Unable to open database: %s\n", $e->getMessage());
  }
  try
  {
    $sel1 = $db->prepare("select Password from Users where User_Name= :user");
    $sel1->bindParam(':user',$username);
    $sel1->execute();
    $ans=$sel1->fetchColumn();
    
    if($ans==$password)
      {
        
        session_start();
        $_SESSION['username'] = $username;
        header('Location: home.php');
      }
    else
      {
         echo "<script>
         div = document.getElementById('errorDiv');
         div.style.display = 'block';
         </script>";
      }
      
    }
    catch (PDOException $e) 
  {
      printf("We had a problem: %s\n", $e->getMessage());
  }
 } ?> 
  </body>

</html>




