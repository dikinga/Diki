



        	<h1>REGISZTRÁCIÓ</h1>
        </div>

  <form name="urlap" method="POST" onSubmit="return ellenoriz()">
		
  <div class="form-group">
    <input type="text" name="bnev" class="form-control" id="bnev" placeholder="Becenév*" required >
  </div>
	  
	    <div class="form-group">
    <input type="email" name="email" class="form-control" id="email" placeholder="E-mail cím*" required >
  </div>

  
 <!-- cím rész eleje -->
 <p>Milyen jelszóval kívánja használni az alkalmazást?</p> 
 
  <div class="form-group">
    <input type="password" name="pwd1" class="form-control" id="pwd1" placeholder="Jelszó*" required >
  </div>
  <div class="form-group">
    <input type="password" name="pwd2" class="form-control" id="pwd2" placeholder="Jelszó újra*" required >
  </div>
  <button type="submit" name="go_reg" class="btn btn-default">REGISZTRÁLOK</button>
	 <button name="go_reg"  class="btn btn-default" onclick="window.location.href='index.php'">Mégsem</button>
</form>

<!-- A jelszó kitöltöttséget és egyezést vizsgáló javascript-->

<script>	
	var password = document.getElementById("pwd1"), confirm_password = document.getElementById("pwd2");
	function validatePassword(){  
  		if(password.value != confirm_password.value) {			
			confirm_password.setCustomValidity("A jelszó nem egyezik");
  		} 		
		else {			
			confirm_password.setCustomValidity('');
  		}
		}
	pwd1.onchange = validatePassword;
	pwd2.onkeyup = validatePassword;
</script>
<?php

if(isset($_POST['go_reg'])){

	$becenev = filter_input(INPUT_POST, 'bnev', FILTER_SANITIZE_SPECIAL_CHARS);
	
	$email = $_POST['email'];
	
	$pass = sha1($_POST['pwd1']);

	
	$result = mysqli_query($con,"SELECT email FROM users WHERE email = '$_POST[email]'");
		
		if($result->num_rows > 0){
			echo '<script> alert("Ez az e-mail cím már foglalt.")</script>';
			$sign = 1;	
		}
	
		if($sign != 1){

			$sql = "INSERT INTO users (name, email, password, status) VALUE ('$becenev', '$email', '$pass', '1')";
		echo "$pass";
		if ($con->query($sql) === TRUE) {

	echo '<meta http-equiv="refresh" content="1;url=index.php?menu=koszonet&user='.$email.'">';}
								
					}
		
			}
if(isset($_POST['go_megsem'])){	echo '<meta http-equiv="refresh" content="1;url=index.php">';}

$con->close();

	
	
?>
