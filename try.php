<?php
$db = new PDO("mysql:host=localhost;dbname=KINDLE", "root", "99isthebest");
$sel=$db->query("show columns from books");
$sel->execute();
$rows = $sel->fetchAll();
foreach ($rows as $row) {
	echo $row['Field'];
}

?>