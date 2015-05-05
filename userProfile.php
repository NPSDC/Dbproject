	<!DOCTYPE html>

<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <?php
  session_start();
  if(!$_SESSION["username"])
    header("Location:home.php");
  ?>

  <body>
    <div class="header">
      <div id="amazon-logo">
        <img src="images/amazon-logo.jpg" style="height:60px">
      </div>
      <div id="user">
        <!-- user is already signed in then the username will be that username,
         else username will be "Sign In" 
        -->
        <?php
        echo'<div class="dropdown" id="name-menu">
          <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Welcome'.$_SESSION['username'].'
          <span class="caret"></span></button>
          <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
            <!-- for logged in, would be something else-->
            <li role="presentation"><a role="menuitem" tabindex="-1" href="userProfile.php">Your Profile</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="checkLogin.php">Sign Out</a></li>
          </ul>
        </div>
      </div>';?>
    </div>

    <div class="navbar">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-tab"><a href="home.php">Buy a Kindle</a></li>
        <li class="nav-tab"><a href="books.php">Kindle eBooks</a></li>
        <li class="nav-tab"><a href="search.php">Advanced Search</a></li>
        <li class="nav-tab"><a href="about.php">About</a></li>        
      </ul>
    </div>

    <div class="container" id="profile-container">
      <h2 class="piece-heading">Your Account</h2>
      <div class="page-piece">
        <div class="inline-piece">
          <div class="orange-heading">Account</div>
        </div>

        <div class="inline-piece">
          <?php
          			function encrypt($text)
						{
						   return base64_encode($text);
							}

						
				          try {
				  $db = new PDO("mysql:host=localhost;dbname=KINDLE", "root", "99isthebest");
				  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				  }
				  
				catch (PDOException $e) {
				  printf("Unable to open database: %s\n", $e->getMessage());
				  }
				  try
				  {
				  	$sel1 = $db->prepare("select User_Id from Users where User_Name = :user");
				  	$sel1->bindParam(':user',$_SESSION["username"]);
				  	$sel1->execute();
				  	global $id;
				  	$id=$sel1->fetchColumn();
				  }

        		catch (PDOException $e) {
				  printf("Unable to open database: %s\n", $e->getMessage());
				  }
		  		try	  
		  		{
		  			$sel2 = $db->prepare("select * from Person where Person_Id=:id");
		  			$sel2->bindParam(':id',$id);
				  	$sel2->execute();
		  		    $rows=$sel2->fetchAll();
		  		    $row=$rows[0];
		  		    $encr=array_map("encrypt",$row);
		  		    $url="editAccount.php?".http_build_query($encr);
          echo'<div>First Name &nbsp'.$row['First_Name'].'</div>
          <div> Middle Name &nbsp'.$row['Middle_Name'].'</div>
          <div> Last Name &nbsp'.$row['Last_Name'].'</div>
          <div> Contact Number &nbsp'.$row['Contact_No'].'</div>
          <div> Email &nbsp'.$row['Email'].'</div>
          <div>House Number &nbsp'.$row['House_No'].'</div>
          <div> Street &nbsp'.$row['street'].'</div>
          <div> City &nbsp'.$row['city'].'</div>
          <div> State &nbsp'.$row['state'].'</div>
          <div> Country &nbsp'.$row['country'].'</div>
          <div> Pin &nbsp'.$row['pin'].'</div>
        </div>

        <div class="inline-piece">
          <b>Edit Account</b><br>
          <a href="changePassword.php">Change Password</a><br>
          <a href="'.$url.'">Edit Account Details</a><br>
        </div>';
        		
        	
        		}
        		catch (PDOException $e) {
				  printf("Unable to open database: %s\n", $e->getMessage());
				  }
		?>   

      </div>
      
      <div class="page-piece">
        <div class="inline-piece">
          <div class="orange-heading">Purchases</div>
        </div>
        <div class="inline-piece">
          <b>Purchase History</b><br>
          <a href="purchases.php">Your Purchases</a>
        </div>
        <form class="inline-piece form">
          <label for="search-purchases"><b>Search Purchases</b></label><br>
          <input type="text" class="form-control" id="search-purchases" />
          <button type="submit" class="btn btn-default">Go</button>
        </form>
      </div>
    </div>
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </body>

</html>