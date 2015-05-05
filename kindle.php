<!DOCTYPE HTML>
<html>
<head>
<title>Kindles</title>
</head>
<body>
<h1>Enter Kindles</h1>
<form action="kindle.php" method="POST" enctype="multipart/form-data">
  <table>
  <tr>
      <td>
      Asin
      </td>
      <td>
      <input type="text" name="asin" required>
      </td>
    </tr>
    <tr>
      <td>
      Price
      </td>
      <td>
      <input type="text" name="price" required>
      </td>
    </tr>
    <tr>
      <td>
      Description
      </td>
      <td>
      <input type="text" name="desc" >
      </td>
    </tr>
    <tr>
      <td>
      Image
    </td>
    <td>
      <input type="file" name="uploadFile" required >
      </td>
    </tr>
    <tr>
      <td>
      Sold By
      </td>
      <td>
      <input type="text" name="sold" required>
      </td>
    </tr>
    <tr>
      <td>
      Name
      </td>
      <td>
       <input id="inf_custom_someDateField" name="name" required>
      </td>
    </tr>
    <tr>
      <td>
      Stock
      </td>
      <td>
      <input type="text" name="stock" required>
      </td>
    </tr>
    <tr>
      <td>
      Weight
      </td>
      <td>
      <input type="text" name="weight"  required>
      </td>
    </tr>
    <tr>
      <td>
      Resolution
      </td>
      <td>
      <input type="text" name="resolution" required>
      </td>
    </tr>
    <tr>
      <td>
      Dimension
      </td>
      <td>
      <input type="text" name="dimension" required>
      </td>
    </tr>
    <tr>
      <td>
      battery
      </td>
      <td>
      <input type="text" name="battery"  required>
      </td>
    </tr>
      <td>
      Storage
      </td>
      <td>
      <input type="text" name="storage"  required>
      </td>
    </tr>
    
    <tr>
      <td>
      Connectivity
      </td>
      <td>
      <input type="text" name="wifi"  required>
      </td>
    </tr>
    
    <tr>
      <td>
      4G
      </td>
      <td>
      <input type="radio" name="4g" checked="true" value="Y">Y
      <input type="radio" name="4g" value="N">N
      </td>
    </tr>
    <tr>
      <td>
      Camera
      </td>
      <td>
      <input type="text" name="camera" required>
      </td>
    </tr>
    <tr>
      <td>
      Customer Support
      </td>
      <td>
      <input type="text" name="custsupp" required>
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
$target_dir = "images/";
$target_dir = $target_dir . basename( $_FILES["uploadFile"]["name"]);
$uploadOk=1;
$i='1';

// Check if file already exists
if (file_exists($target_dir )) {
    echo "file already exists";
    exit;
}

// Check file size
if ($_FILES["uploadFile"]['size'] > 500000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Only GIF files allowed
if (!($_FILES["uploadFile"]['type'] == "image/jpeg" || $_FILES["uploadFile"]['type'] == "image/jpg" || $_FILES["uploadFile"]['type'] == "image/gif" || $_FILES["uploadFile"]['type'] == "image/png")) {
    echo "Sorry, only GIF,JP,JPEg,PNG files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    exit;
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_dir)) {
        
    } else {
        echo "Sorry, there was an error uploading your file.";
        exit;
    }
}
  $asin = $_POST["asin"];
  $price = $_POST["price"];
  $desc = $_POST["desc"];
  $image = $target_dir;
  $sold = $_POST["sold"];
  $name = $_POST["name"];
  $stock = $_POST["stock"];
  $weight = $_POST["weight"];
  $dimension = $_POST["dimension"];
  $resolution = $_POST["resolution"];
  $storage = $_POST["storage"];
  $battery = $_POST["battery"];
  $wifi = $_POST["wifi"];
  $g = $_POST["4g"];
  $camera = $_POST["camera"];
  $custsupp = $_POST["custsupp"];
  if(strlen($asin)!=10)
  {
  	echo "Asin must be exactly 10 in length";
  	exit;
  }
  try
  {
    $db = new PDO("mysql:host=localhost;dbname=KINDLE","root","99isthebest");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
catch (PDOException $e) {
  printf("Unable to open database: %s\n", $e->getMessage());
  }
  $asin = addslashes($asin);
  $price = addslashes($price);
  $desc = addslashes($desc);
  $image = addslashes($image);
  $sold = addslashes($sold);
  $name = addslashes($name);
  $stock = addslashes($stock);
  $weight = addslashes($weight);
  $resolution = addslashes($resolution);
  $dimension = addslashes($dimension);
  $storage = addslashes($storage);
  $battery = addslashes($battery);
  $wifi = addslashes($wifi);
  $g = addslashes($g);
  $camera = addslashes($camera);
  $custsupp = addslashes($custsupp);
  
 	 try
  {
    $sel3 = $db->prepare("select Asin from Product");
    $sel3->execute();
    while($row = $sel3->fetch(PDO::FETCH_ASSOC))
    {
      if($asin==$row["Asin"])
      {
        echo "Asin already exists";
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
    $sel1 = $db->prepare("select name from Kindle");
    $sel1->execute();
    while($row = $sel1->fetch(PDO::FETCH_ASSOC))
    {
       //echo "Yes";
      if($name==$row["name"])
      {
        echo "Name already exists";
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
    $qins = $db->prepare("insert into Product(Asin,Price,Description,Image,Sold_By) values". "(:asin,:price,:desc,:image,:sold)");
    $qins->bindParam(':asin', $asin);
    $qins->bindParam(':price', $price);
    $qins->bindParam(':desc', $desc);
    $qins->bindParam(':image', $image);
    $qins->bindParam(':sold', $sold);
    
    $qins->execute();
  }
  catch (PDOException $e) 
  {
      printf("We had a problem: %s\n", $e->getMessage());
  }
  /* 	 try
    {
      $qsel2 = $db->prepare("select Asin from Product where Image =":image);
      echo 'img'.$image;
      //$qsel2->bindParam(':image', $image);
      $qsel2->execute();
      global $asn;
      while ($row = $qsel2->fetch(PDO::FETCH_ASSOC)) {
          $asn = $row["Asin"];
          break;
        } 
    }
     catch(PDOException $e) 
  {
      printf("We had a problem: %s\n", $e->getMessage());
  }*/
    //echo $dob;
try
    {
      
      $qins2 = $db->prepare("insert into Kindle(Asin,name,stock,weight,dimension,resolution,battery,storage,wifi,4G,camera,customer_support)values". 
      	"(:asin,:name,:stock,:weight,:dimension,:resolution,:battery,:storage,:wifi,:4g,:camera,:cust)");
      $qins2->bindParam(':asin',$asin);
      $qins2->bindParam(':name',$name);
      $qins2->bindParam(':stock',$stock);
      $qins2->bindParam(':weight',$weight);
      $qins2->bindParam(':dimension',$dimension);
      $qins2->bindParam(':resolution',$resolution);
      $qins2->bindParam(':battery',$battery);
      $qins2->bindParam(':storage',$storage);
      $qins2->bindParam(':wifi',$wifi);
      $qins2->bindParam(':4g',$g);
      $qins2->bindParam(':camera',$camera);
      $qins2->bindParam(':cust',$custsupp);
      $qins2->execute();
      echo "Kindle was successfully added.";
    }

    catch(PDOException $e) 
  {
      printf("We had a problem: %s\n", $e->getMessage());
  }
  

}

?>