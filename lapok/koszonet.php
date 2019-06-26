<?php
$res=mysqli_query($con, "SELECT * FROM users WHERE email='$_GET[user]'");

while($row=mysqli_fetch_assoc($res)){
	$uid=$row['uid'];
	$nev=$row['name'];
	$email=$row['email'];
}
?>
<div class="container">
	<div class="row">
        <div class="col-sm-12">
        	<h1>KÖSZÖNJÜK A REGISZTRÁCIÓT</h1>
        </div>
		
		<div class="col-sm-8">
            <h3>Ön az imént regisztrált oldalunkon az alábbi adatokkal:</h3>
            <ul>
            	<li><b>Név:</b> <?php echo $nev; ?></li>
                <li><b>E-mail:</b> <?php echo $email; ?></li>
                <li><b>... és az Ön által megadott jelszó.</b></li>
            </ul>
            <h3>A regisztráció befejezéséhez erősítse meg azt a gomb megnyomásával!</h3>
            <form method="POST">
            	<input type="hidden" name="status" value="0">
                <input type="hidden" name="uid" value="<?php echo $uid ?>">
            	<button type="submit" class="btn btn-primary" name="go_meg">MEGERŐSÍTÉS</button>
            </form>
		</div>
        
       <?php
	   if(isset($_POST['go_meg'])){
		$sql = "UPDATE users SET status = '$_POST[status]' WHERE uid = '$_POST[uid]'"; 
			if($con->query($sql)=== TRUE){
				$_SESSION['new_uid'] = $_POST['uid'];
				echo '<meta http-equiv="refresh" content="1;url=http://index.php">';
			}  
		$con->close();
	   }
	   ?>
	
	</div>
</div>