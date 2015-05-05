$arr=array("1","2","3");
function encrypt($text)
{
	return base64_encode($text);
}
function decrypt($text)
{
	return base64_decode($text);
}
$encr=array_map("encrypt",$arr);
echo $encr

