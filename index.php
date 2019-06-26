<?php
session_start();
require('config.php');
require('szamol.php');
require 'carbon/autoload.php';
use Carbon\Carbon;
use Carbon\CarbonInterval;
if($_POST['kijelentkezes']== 'true'){
	$_SESSION['admin']='';
	$_SESSION['user']='';
	$_SESSION['uid']='';
	$_SESSION['new_uid']='';
	$_SESSION['szin']='#7ca0d8';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Diki's</title>
	
	<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>	
	
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,latin-ext" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="bootstrap.css" type="text/css">

		<script>//1
$(document).ready(function(){	
	$("button77").click(function(){
     $("div").animate({right: '4em'});
	
	});
});
	</script>
	
		<style>
			body {
 				<?php echo "background-color:".$_SESSION['szin'];?>
						}
			
			.table > tbody > tr > td  {
			vertical-align: middle;
				
			}
			
			.m{
				text-align: center;
			}
			
			.right {
  				position: relative;
  				 left: 3em;
  			}
			
			.right2 {								
  				position: relative;
  				 left: 1em;
  			}
			
			.szel{
				  width: 1em;
			}

			}
			

		</style>	
	
	</head>
<body>
<?php 
	
	if(isset($_POST['bejelentkezes'])){
			
			$pass = sha1($_POST['pwd']);

			$result = mysqli_query($con, "SELECT * FROM users WHERE name = '$_POST[name]' AND password = '$pass' ");
					$count = 0;
				while ($rows = mysqli_fetch_array($result)) {
					$_SESSION['user'] = $rows['name'];
					$_SESSION['uid'] = $rows['uid'];
					$count++;
				}
	
			if($count > 0){
				$_SESSION['admin'] = 1;				
				echo '<meta http-equiv="refresh" content="1;url=index.php">';	 
				}else {
				?> <script type="text/javascript">
			alert("A bejelentkezés sikertelen. Ilyen nevű felhasználó ezzel a jelszóval nem regisztrált. Próbálkozz újra!");
					</script> <?php }
				}?>
	
			<?php if($_SESSION['new_uid']){						
			$result = mysqli_query($con, "SELECT * FROM users WHERE uid = '$_SESSION[new_uid]'");
				while ($rows = mysqli_fetch_array($result)) {
					$_SESSION['uid'] = $rows['uid'];
					$_SESSION['user'] = $rows['name'];
					$_SESSION['email'] = $rows['email'];
					$_SESSION['szin']='#7ca0d8';
				$admin=new Felhasznaló($_SESSION['uid']);
				$oldal=new Oldal();
				$admin->feltolt();	
				$_SESSION['new_uid']="";	
				}						
			$_SESSION['admin'] = 1;
				}?>
	
<div class="container-fluid">
	<div class="row">
		<div class="container">
	   		<div class="row">

  			<?php 
		if (!$_SESSION['admin']){ ?>
				
			 <form method="POST" action="">	
				 
				 <div class="col-xs-2">
					<?php	echo '<h3>Diki\'s DATE</h3>'; ?> 			
				</div>
					
				<div class="col-xs-2">
					<a href="?menu=regisztracio" >REGISZTÁCIÓ</a> 
				
      				</div>
				 
				<div class="col-xs-3">	
				<label for="nev">NÉV:</label>
        		<input class="form-control" name="name" type="name" placeholder="becenév is elég" required>
				</div>
		   	
		   
			  	  
				<div class="col-xs-3" href="?menu=szunnapok" class="btn btn-info">
				<label for="pwd">JELSZÓ:</label>
                <input class="form-control" name="pwd" type="password" placeholder="bármi" required></div>
			  
 
		     	  
				<div class="col-xs-2" href="?menu=szombatok" class="btn btn-info">		 		
				<label for="bejelentkezes">BELÉPÉS:</label>
  				<button type="submit" class="btn btn-primary" name="bejelentkezes" value="true"><img src="img/enter2.png"></button> </div>
             
		    </form> 
		<?php } 
				
		if($_SESSION['admin'] == 1){
					$admin=new Felhasznaló($_SESSION['uid']);
					$oldal=new Oldal();	
						
			?>
				<div class="col-xs-4">
					<?php	echo '<h3>'.$_SESSION['user'].'\'s DATA</h3>'; ?> 			
				</div>			

				 <form class="col-xs-4 right2" method="post">		
    	 	<input name="valami" id="test" type="color" value="#7ca0d8">
				
			<input type="submit" name="go8" class="btn btn-info" value="színez">
				</form> 
				
				<form class="col-xs-4 right"  method="POST" action="">
  					<button type="submit" class="btn btn-primary" name="kijelentkezes" value="true"><img src="img/out2.png"></button>   
			    </form>
			
		<?php	
						if(isset($_POST['go8'])){
							$_SESSION['szin']=$_POST['valami'];
							echo '<meta http-equiv="refresh" content="0;url=index.php?menu=alap">';
						} 
					
					
			}?>
		</div>
	   </div>
	  </div>
	</div>	
	
	
		<?php if($_SESSION['admin'] == 1){?>
	
<div class="container-fluid">
	<div class="row">
		<div class="container">
	   		<div class="row">
				
  			<div class="col-xs-2"> <a href="?menu=alap" class="btn btn-outline-light text-dark">UTOLSÓ: </a></div>

		   
			
  			<div class="col-xs-2">	<a  href="?menu=halado" class="btn btn-outline-light text-dark">SZÜNETEK: </a></div>
		   	
		   
			  	  
			<div class="col-xs-2">	<a  href="?menu=szunnapok" class="btn btn-outline-light text-dark">SZÜNNAPOK: </a></div>
			  
 
		     	  
			<div class="col-xs-2">	<a  href="?menu=szombatok" class="btn btn-outline-light text-dark">SZOMBATOK: </a></div>
             
		   
		  
			<div class="col-xs-2">	<a  href="?menu=ujra" class="btn btn-outline-light text-dark">VISSZAÁLLÍT:</a></div>
             
		   
		   	  <a class="col-xs-2" name="elso">
				  

				  
    		  </a>	
				
		</div>
	  </div>
	</div>
</div>	
	
	<?php	
} ?>
	
<div class="container-fluid">
	<div class="row">
		<div class="container">
	   		<div class="row">
		   	  <div class="col-xs-12" >	
        		<?php  
				 if($_SESSION['admin'] != 1){
				  $lap =($_GET['menu'] ? $_GET['menu'] : 'alap2');
				include('lapok/'.$lap.'.php'); 
				  }
				  else {
					   $lap =($_GET['menu'] ? $_GET['menu'] : 'alap');
					  include('lapok/'.$lap.'.php');
					   }
				  ?>
			 </div>
		  </div>
		</div>   
	 </div>
</div>	

	
</body>
</html>

	
</body>
</html>