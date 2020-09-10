<?php include_once("../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
     $Db = new dbInvestments();
//$file ="importfiles/peinvestmentsexport.txt";
//	$file = $_POST['txtfilepath'];
//echo "<br>----------------" .$file;
$currentdir=getcwd();
$target = $currentdir . "/importfiles/" . basename($_FILES['txtfilepath']['name']);

//$target = "www.ventureintelligence.com/adminvi/importfiles/";
//$target="importfiles/";
//$target = $target.basename( $_FILES['txtfilepath']['name']);

echo "<br>Target-" .$target;
echo "<Br>Source-" .$_FILES['txtfilepath']['tmp_name'];
$sources="C:\peinvestmentsexport.txt";
$ok=1;
if(move_uploaded_file($_FILES['txtfilepath']['tmp_name'], $target))
{
	echo "<Br>The file ". basename( $_FILES['txtfilepath']['name']). " has been uploaded";
	$file = "importfiles/" . basename($_FILES['txtfilepath']['name']);
	echo "<br>----------------" .$file;

}
else
{
	echo "<br>Sorry, there was a problem uploading your file.";
}


?>