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
    <div class="container">
      <div class="centered-logo" style="margin:1% 41%">
        <img src="images/amazon-logo.jpg" style="height:60px">
      </div>
      <div class="page-piece" id="error-piece" style="display:none; color:red">
      </div>
      <div class="form-container" background-color="black">
        <h2 class="piece-heading text-center" style="margin-bottom=12px"><b>Registration</b></h2>
        <form class="form-horizontal" role="form" action="userRegistration.php" method="POST">

          <div class="form-piece">
            <div class="form-group">
              <label class="control-label col-sm-2" for="email">Username:</label>
              <div class="col-sm-10">
                <input type="username" class="form-control" id="email" placeholder="Enter Username" name="username" autofocus required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Password:</label>
              <div class="col-sm-10">          
                <input type="password" class="form-control" id="pwd" placeholder="Enter Password" name="password" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Re-enter Password:</label>
              <div class="col-sm-10">          
                <input type="password" class="form-control" id="pwd" placeholder="Re-enter Password" name="repassword" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">First Name:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="pwd" placeholder="Enter First Name" name="firstname" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Middle Name:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="pwd" placeholder="Enter Middle Name" name="middlename">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Last Name:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="pwd" placeholder="Enter Last Name" name="lastname" required>
              </div>
            </div>
          </div>

          <h3 class="piece-heading" style="font-size:24px"><b>Contact Details</b></h3>
            <div class="form-piece">
            <div class="form-group">
              <label class="control-label col-sm-2" for="email">Email:</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Contact Number:</label>
              <div class="col-sm-10">          
                <input type="tel" class="form-control" id="pwd" placeholder="Enter Contact number" name="contact" required>
              </div>
            </div>
          </div>

          <h3 class="piece-heading" style="font-size:24px"><b>Delivery Details</b></h3>
            <div class="form-piece">
            <div class="form-group">
              <label class="control-label col-sm-2" for="email">House No:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="email" placeholder="Enter House No" name="house" required>
              </div>
            </div>
           <div class="form-group">
              <label class="control-label col-sm-2" for="email">Street:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="email" placeholder="Enter Street" name="street" required>
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="email">City:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="email" placeholder="Enter city" name="city">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="email">State:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="email" placeholder="Enter State" name="state">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="email">Country:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="email" placeholder="Enter country" name="country">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="email">Pin:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="email" placeholder="Enter Pin" name="pin">
              </div>
            </div>
          </div>
          </div>
          <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" class="btn btn-default form-submit" name="submit" value="submit">
            </div>
          </div>

        </form>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <?php
    session_start();
    if(isset($_SESSION['username'])){
      header('Location: home.php');
    }
    if(isset($_POST["submit"]))
    {
      $username = $_POST["username"];
  $pass = $_POST["password"];
  $repass = $_POST["repassword"];
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


  $error = 'false';

  try
  {
    $db = new PDO("mysql:host=localhost;dbname=KINDLE","root","123");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
catch (PDOException $e) {
  $error = "Unable to open database: " . $e->getMessage();
  }

  if(! ereg("[[:alnum:]]+", $username)) {
    $error = "You did not enter a valid username.It must start with alphanumeric characters";
    exit;
  }
  if(strlen($username)<5)
  {
    $error =  "Username must be atleast 5 in length";
    exit;
  }
  
  if($pass!=$repass)
  {
    $error = "Passwords do not match";
    exit;
  }/*
  if(strlen($pass)<7)
  {
    echo "Passwords must be atleast 7 digits long";
    exit;
  }
  
  if(!ereg("[0-9]+",$contact ))
  {
    echo "Contact number must contain only digits";
    exit;
  } 

  if(!ereg("[a-zA-Z]+",$firstname))
  {
    echo "Firstname must contain only alphabets";
    exit;
  }
  if($middlename and (!ereg("[a-zA-Z]+",$middlename)))
  {
    echo "middlename must contain only alphabets";
    exit;
  }
  if(!ereg("[a-zA-Z]+",$lastname))
  {
    echo "lastname must contain only alphabets";
    exit;
  }
  if(!ereg("[0-9]+",$pin))
  {
    echo "Pin must contain digits only";
    exit;
  }*/
  if($error != 'false'){
  echo "<script>
  document.getElementById('error-piece').innerHTML = " . $error . " ;
  document.getElementById('error-piece').style.display = 'block';
  </script>";
  };
  $username = addslashes($username);
  $pass = addslashes($pass);
  $repass = addslashes($repass);
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
  $personid = 0;
  $date = date("Y-m-d H:i:s");
  try
  {
    $sel2 = $db->prepare("select User_Name from Users");
    $sel2->execute();
    while($row = $sel2->fetch(PDO::FETCH_ASSOC))
    {
      if($username==$row["User_Name"])
      {

        echo "UserName already exists";
        exit;
        break;
      }
    }
    
  }
  catch (PDOException $e) 
  {
      printf("We had a problem: %s\n", $e->getMessage());
  }
    try
  {
    $sel3 = $db->prepare("select Email from Person");
    $sel3->execute();
    while($row = $sel3->fetch(PDO::FETCH_ASSOC))
    {
      if($email==$row["Email"])
      {
        echo "Email already exists";
        exit;
        break;
      }
    }
    // exit;
  }
  catch (PDOException $e) 
  {
      printf("We had a problem: %s\n", $e->getMessage());
  }

  try
  {
    $sel4 = $db->prepare("select Contact_No from Person");
    $sel4->execute();
    while($row = $sel4->fetch(PDO::FETCH_ASSOC))
    {
      if($contact==$row["Contact_No"])
      {
        echo "Contact Number already exists";
        exit;
        break;
      }
    }
    // exit;
  }
  catch (PDOException $e) 
  {
      printf("We had a problem: %s\n", $e->getMessage());
  }

  
  try
  {
    $qins = $db->prepare("insert into Person(Email,Contact_No,First_Name,Middle_Name,Last_Name,House_No,street,city,state,country,pin) values". "(:email,:contact,:first,:middle,:last,:house,:street,:city,:state,:country,:pin)");
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
  }
  catch (PDOException $e) 
  {
      printf("We had a problem: %s\n", $e->getMessage());
  }
    try
    {
      $qsel = $db->prepare("select Person_Id from Person where Email= :email");
      $qsel->bindParam(':email', $email);
      $qsel->execute();
      global $personid;
      while ($row = $qsel->fetch(PDO::FETCH_ASSOC)) {
          $personid = (int)$row["Person_Id"];
          break;
        } 
    }
     catch(PDOException $e) 
  {
      printf("We had a problem: %s\n", $e->getMessage());
  }
  try
    {
      $qins2 = $db->prepare("insert into Users(User_Id,User_Name,Password,Datecreated) values"."(:user,:name,:pass,:datecreated)");
      $qins2->bindParam(':user',$personid);
      $qins2->bindParam(':name',$username);
      $qins2->bindParam(':pass',$pass);
      $qins2->bindParam(':datecreated',$date);
      $qins2->execute();
      
      $_SESSION['username'] = $username;
      header('Location: home.php');
    }
    catch(PDOException $e) 
  {
      printf("We had a problem: %s\n", $e->getMessage());
  }
    }

    ?>
  </body>

</html>
