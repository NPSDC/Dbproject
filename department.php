<!DOCTYPE html>
<html>
<head>
	<title>Department</title>
</head>
<body>
<?php
	$deptname = $_POST["deptname"];
	
	try
  {
  	$db = new PDO("mysql:host=localhost;dbname=KINDLE","root","123");
  	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
catch (PDOException $e) {
  printf("Unable to open database: %s\n", $e->getMessage());
	}
	try
  {
  	$sel1 = $db->prepare("select Dept_Name from Department");
  	$sel1->execute();
  	while($row = $sel1->fetch(PDO::FETCH_ASSOC))
  	{
  		if($deptname==$row["Dept_Name"])
  		{
  			echo "Department already exists";
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
		$qins1 = $db->prepare("insert into Department(Dept_Name) values"."(:deptname)");
		$qins1->bindParam(':deptname',$deptname);
		$qins1->execute();
	}
	catch (PDOException $e) 
	{
  		printf("We had a problem: %s\n", $e->getMessage());
	}
	echo("Department added");

?>
</body>
</html>
