<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
	Biztos, hogy vissza akarod állítani az adatokat az eredeti, Közlönyben megjelenek szerint?
<!--	<input type="button" name="test" id="test" value="IGEN"  onclick="<?php //echo $admin->feltolt(); ?>" /><br/> -->
	<form method="post">
	<input type="submit" name="submit">
							   </form>
 <?php if(isset($_POST["submit"])) {  $admin->feltolt(); 
		 echo '<meta http-equiv="refresh" content="1;url=index.php?menu=alap">';
								   }?>

</body>
</html>