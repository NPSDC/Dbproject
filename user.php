<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<body>
  <?php
 /* error_reporting(-1);
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);*/

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
  try
  {
  	$db = new PDO("mysql:host=localhost;dbname=KINDLE","root","123");
  	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
catch (PDOException $e) {
  printf("Unable to open database: %s\n", $e->getMessage());
	}
  if(! ereg("[[:alnum:]]+", $username))	{
  	echo "You did not enter a valid username.It must start with alphanumeric characters";
  	exit;
  }
  if(strlen($username)<5)
  {
  	echo "Username must be atleast 5 in length";
  	exit;
  }
  
  if($pass!=$repass)
  {
  	echo "Passwords do not match";
  	exit;
  }
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
  }
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
    }
    catch(PDOException $e) 
	{
  		printf("We had a problem: %s\n", $e->getMessage());
	}
	echo "Your account was successfully created."

  ?>

</body>
</html>
	
