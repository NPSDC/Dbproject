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
      if(!$_SESSION["username"])
        header("Location:home.php");
     
            
    ?>
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

    <div class="container">
    <?php
     
    if(isset($_GET['Person_Id']))
    {

    function decrypt($text)
            {
               return base64_decode($text);
            }
            $arr = array_map("decrypt", $_GET) ;
            
     //       if($arr){
      echo'<div class="form-container" background-color="black">
        <h2 class="piece-heading text-center" style="margin-bottom=12px"><b>Registration</b></h2>
        <form class="form-horizontal" role="form" action="editAccount.php" method="POST">

          <h3 class="piece-heading" style="font-size:24px"><b>Delivery Details</b></h3>
          <div class="form-piece">
          <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">First Name:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="First_Name" value="'.$arr['First_Name'].'" name="firstname" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Middle Name:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="Middle_Name" value="'.$arr['Middle_Name'].'" name="middlename" >
              </div>
            </div>

          <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Last Name:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="Last_Name" value="'.$arr['Last_Name'].'" name="lastname" required>
              </div>
            </div>
             <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Email:</label>
              <div class="col-sm-10">          
                <input type="email" class="form-control" id="Email" value="'.$arr['Email'].'" name="email" required>
              </div>
            </div>
             <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Contact Number:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="Contact_No" value="'.$arr['Contact_No'].'" name="contact" required>
              </div>
            </div>          
          <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">House Number:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="House_No" value="'.$arr['House_No'].'" name="house" required>
              </div>
            </div>
          

          <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Street:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="street" value="'.$arr['street'].'" name="street" required>
              </div>
            </div>
         

          <div class="form-group">
              <label class="control-label col-sm-2" for="city">City:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="pwd" value="'.$arr['city'].'" name="city" required>
              </div>
            </div>
          

          <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">State:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="state" value="'.$arr['state'].'" name="state" required>
              </div>
            </div>
          

          <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Country:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="country" value="'.$arr['country'].'" name="country" required>
              </div>
            </div>
          
          <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Pin:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="pin" value="'.$arr['pin'].'" name="pin" required>
                <input type="hidden" value="'.$arr['Person_Id'].'" name="id">
              </div>
            </div>
            </div>
          <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" class="btn btn-default form-submit name="submit" value="Update" >
            </div>
          </div>

        </form>
      </div>';

      if(isset($arr["Error"]))
      {
        echo'
      <script>
      document.getElementById("'.$arr["Error"].'").class = "error-input";
      document.getElementById("'.$arr["Error"].'").style.border = "3px solid red";
      </script>';}
      echo'</div>';
    }
            function encrypt($text)
            {
               return base64_encode($text);
            }
        if(isset($_POST["email"]))
        {
              
              $email = $_POST["email"];
              $contact = $_POST["contact"];
              $firstname = $_POST["firstname"];
              $middlename = $_POST["middlename"];
              $lastname = $_POST["lastname"];
              $house = $_POST["house"];
              $street = $_POST["street"];
              $city = $_POST["city"];
              $state = $_POST["state"];
              $country = $_POST["country"];
              $pin = $_POST["pin"];
              $id = $_POST["id"];
              $new_get=["Email" => $_POST["email"],"Contact_No" => $_POST["contact"],"First_Name" => $_POST["firstname"],
                    "Middle_Name" => $_POST["middlename"],"Last_Name" =>$_POST["lastname"], "House_No" => $_POST["house"],
                    "street" => $_POST["street"],"city" => $_POST["city"], "state" => $_POST["state"],"country" => $_POST["country"],
                    "pin" => $_POST["pin"],"Person_Id" => $_POST["id"]];

             try {
            $db = new PDO("mysql:host=localhost;dbname=KINDLE", "root", "99isthebest");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            
          catch (PDOException $e) {
            printf("Unable to open database: %s\n", $e->postMessage());
            }         
           function Enc($Field,$arr)  
          {
              $arr+=["Error"=>$Field];            
              $encr=array_map("encrypt",$arr);
              $url="editAccount.php?".http_build_query($encr);
              return $url;
          }
             try
            {
              $sel3 = $db->prepare("select Email,Person_Id from Person");
              $sel3->execute();
              while($row = $sel3->fetch(PDO::FETCH_ASSOC))
              {
                if($email==$row["Email"] and $id!=$row["Person_Id"])
                {
                  echo "Email already exists";
                  $url=Enc("Email",$new_get);
                  echo '<br><a href="'.$url.'">Try Again</a>';

                  exit;
                  break;
                }
              }
              // exit;
            }
            catch (PDOException $e) 
            {
                printf("We had a problem: %s\n", $e->postMessage());
            }
          if(!ereg("[0-9]+",$contact ))
          {
            echo "Contact number must contain only digits";
            $url=Enc("Contact_No",$new_get);
            echo '<br><a href="'.$url.'">Try Again</a>';
             exit;
          } 
          try
            {
              $sel4 = $db->prepare("select Contact_No,Person_Id from Person");
              $sel4->execute();
              while($row = $sel4->fetch(PDO::FETCH_ASSOC))
              {
                if($contact==$row["Contact_No"] and $id!=$row["Person_Id"])
                {
                  echo "Contact Number already exists";
                  $url=Enc("Contact_No",$new_get);
                echo '<br><a href="'.$url.'">Try Again</a>';
                  exit;
                  break;
                }
              }
              // exit;
            }
            catch (PDOException $e) 
            {
                printf("We had a problem: %s\n", $e->postMessage());
            }

          if(!ereg("[a-zA-Z]+",$firstname))
          {
            echo "Firstname must contain only alphabets";
            $url=Enc("First_Name",$new_get);
            echo '<br><a href="'.$url.'">Try Again</a>';
            exit;
          }
          if($middlename and (!ereg("[a-zA-Z]+",$middlename)))
          {
            echo "middlename must contain only alphabets";
            $url=Enc("Middle_Name",$new_get);
            echo '<br><a href="'.$url.'">Try Again</a>';
            exit;
          }
          if(!ereg("[a-zA-Z]+",$lastname))
          {
            echo "lastname must contain only alphabets";
            $url=Enc("Last_Name",$new_get);
            echo '<br><a href="'.$url.'">Try Again</a>';
            exit;
          }
          if(!ereg("[0-9]+",$pin))
          {
            echo "Pin must contain digits only";
            $url=Enc("pin",$new_get);
            echo '<br><a href="'.$url.'">Try Again</a>';
            exit;
          }

          $email = addslashes($email);
          $contact = addslashes($contact);
          $firstname = addslashes($firstname);
          $middlename = addslashes($middlename);
          $lastname = addslashes($lastname);
          $house = addslashes($house);
          $street = addslashes($street);
          $city = addslashes($city);
          $state = addslashes($state);
          $country = addslashes($country);
          $pin = addslashes($pin);
          $id = addslashes($id);
             

            
                      try
            {
              $qins = $db->prepare("update Person set Email=:email,Contact_No=:contact,First_Name=:first,Middle_Name=:middle,Last_Name=:last,
                House_No=:house,street=:street,city=:city,state=:state,country=:country,pin=:pin where Person_Id=:id");
              $qins->bindParam(':id', $id);
              $qins->bindParam(':email', $email);
              $qins->bindParam(':contact', $contact);
              $qins->bindParam(':first', $firstname);
              $qins->bindParam(':middle', $middlename);
              $qins->bindParam(':last', $lastname);
              $qins->bindParam(':house', $house);
              $qins->bindParam(':street', $street);
              $qins->bindParam(':city', $city);
              $qins->bindParam(':state', $state);
              $qins->bindParam(':country', $country);
              $qins->bindParam(':pin', $pin);
              $qins->execute();
              header('Location:userProfile.php');
            }
            catch (PDOException $e) 
            {
                printf("We had a problem: %s\n", $e->postMessage());
            }


        }
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </body>

</html>
