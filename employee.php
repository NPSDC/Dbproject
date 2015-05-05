<!DOCTYPE HTML>
<html>
<head>
<script src="jqueryCalendar/jquery-1.6.2.min.js"></script>
<script src="jqueryCalendar/jquery-ui-1.8.15.custom.min.js"></script>
<link rel="stylesheet" href="jqueryCalendar/jqueryCalendar.css">
  <title>Employees</title>
<script>
                jQuery(function() {
                                jQuery( "#inf_custom_someDateField" ).datepicker({ dateFormat: "yyyy-mm-dd" });
                });
                </script>
</head>
<body>
<h1>Enter Employees</h1>
<form action="employee.php" method="POST">
  <table>
  <tr>
      <td>
      First Name
      </td>
      <td>
      <input type="text" name="firstname" required  >
      </td>
    </tr>
    <tr>
      <td>
      Middle Name
      </td>
      <td>
      <input type="text" name="middlename" >
      </td>
    </tr>
    <tr>
      <td>
      Last Name
      </td>
      <td>
      <input type="text" name="lastname" required>
      </td>
    </tr>
    <tr>
      <td>
      Email
      </td>
      <td>
      <input type="email" name="email"  required>
      </td>
    </tr>
    <tr>
      <td>
      Password
    </td>
    <td>
      <input type="password" name="password" required >
      </td>
    </tr>
    <tr>
      <td>
      Retype Password
      </td>
      <td>
      <input type="password" name="repassword" required >
      </td>
    </tr>
    <tr>
      <td>
      Sex
      </td>
      <td>
       <input type="radio" name="sex" checked="true" value="m">M
      <input type="radio" name="sex" value="f ">F
  
      </td>
    </tr>
    <tr>
      <td>
      Date of birth
      </td>
      <td>
       <input id="inf_custom_someDateField" name="dob" required>
      </td>
    </tr>
    <tr>
      <td>
      Married
      </td>
      <td>
      <input type="radio" name="mar" checked="true" value="y">Y
      <input type="radio" name="mar" value="n">N
      </td>
    </tr>
    <tr>
      <td>
      Designation
      </td>
      <td>
      <input type="text" name="desig"  required>
      </td>
    </tr>
    <tr>
      <td>
      Department
      </td>
      <td>
      <select name="dept">
        <option value="Products">Products</option>
        <option value="Sales">Sales</option>
      </select>
      </td>
    </tr>
    <tr>
      <td>
      Account Number
      </td>
      <td>
      <input type="text" name="account"  required>
      </td>
    </tr>
      <td>
      IFSC Code
      </td>
      <td>
      <input type="text" name="ifsc"  required>
      </td>
    </tr>
    
    <tr>
      <td>
      Contact Number
      </td>
      <td>
      <input type="tel" name="contact"  required>
      </td>
    </tr>
    
    <tr>
      <td>
      House No
      </td>
      <td>
      <input type="text" name="house" required>
      </td>
    </tr>
    <tr>
      <td>
      Street
      </td>
      <td>
      <input type="text" name="street" required>
      </td>
    </tr>
    <tr>
      <td>
      City
      </td>
      <td>
      <input type="text" name="city" required>
      </td>
    </tr>
    <tr>
      <td>
      State
      </td>
      <td>
      <input type="text" name="state" required>
      </td>
    </tr>
    <tr>
      <td>
      Country
      </td>
      <td>
      <input type="text" name="country" required>
      </td>
    </tr>
    <tr>
      <td>
      Pin
      </td>
      <td>
      <input type="text" name="pin"   required>
      </td>
    </tr>
    
    <tr>
      <td>
      <input type="submit" value="Submit" name="submit">
      </td>
    </tr>
  </table>  
</form>

<?php
if(isset($_POST["submit"]))
{
  
 /* error_reporting(-1);
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);*/
  $sex = $_POST["sex"];
  $dept = $_POST["dept"];
  $desig = $_POST["desig"];
  $dob = $_POST["dob"];
  $ifsc = $_POST["ifsc"];
  $account = $_POST["account"];
  $married = $_POST["mar"];
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
    $db = new PDO("mysql:host=localhost;dbname=KINDLE","root","99isthebest");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
catch (PDOException $e) {
  printf("Unable to open database: %s\n", $e->getMessage());
  }
  if(!ereg("[0-9]+",$account ))
  {
    echo "Account number must contain only digits";
    exit;
  }
   if(strlen($ifsc)!=11)
   {
    echo "IFSC code must be 11 digits long";
    exit; 
   }
   if(!ereg("[[:alnum:]]+", $ifsc ))
    {
    echo "IFSC code must be alphanumeric";
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
  $sex = addslashes($sex);
  $desig = addslashes($desig);
  $dept = addslashes($dept);
  $married = addslashes($married);
  $dob = addslashes($dob);
  $account = addslashes($account);
  $ifsc = addslashes($ifsc);
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
  $array = explode('/', $dob); 
  $a1 = $array[0];//m
  $a2 = $array[1];//d
  $a3 = $array[2];
  //echo $a1." ".$a2;
  $dob = $a3."/".$a1.'/'.$a2;
  $personid = 0;

  
  
  
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
    $sel2 = $db->prepare("select Account_No from Employee");
    $sel2->execute();
    while($row = $sel2->fetch(PDO::FETCH_ASSOC))
    {
      if($account==$row["Account_No"])
      {

        echo "Account Number already exists";
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
    //echo $dob;
  try
    {
      $qins2 = $db->prepare("insert into Employee(Emp_ID,Password,Sex,Dob,Maritial_Status,Designation,Department,Account_No,IFSC) 
        values". "(:user,:pass,:sex,:dob,:married,:desig,:dept,:acct,:ifsc)");
      $qins2->bindParam(':user',$personid);
      $qins2->bindParam(':pass',$pass);
      $qins2->bindParam(':sex',$sex);
      $qins2->bindParam(':dob',$dob);
      $qins2->bindParam(':married',$married);
      $qins2->bindParam(':desig',$desig);
      $qins2->bindParam(':dept',$dept);
      $qins2->bindParam(':acct',$account);
      $qins2->bindParam(':ifsc',$ifsc);
      $qins2->execute();
    }
    catch(PDOException $e) 
  {
      printf("We had a problem: %s\n", $e->getMessage());
  }
  echo "Employee was successfully created.";

  

}
?>
</body>
</html>