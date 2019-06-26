
<?php
	
require 'carbon/autoload.php';
use Carbon\Carbon;
use Carbon\CarbonInterval;

require('config.php');



	function szamol()
	{
		$_tanevVege="2019-06-14";
		$tanevVege=Carbon::parse($_tanevVege);
		$ma = Carbon::now()->addDay(0);
		
		$szamlalo=0;
		while($ma->isBefore($tanevVege)){
			if(!($ma->isSaturday()) && !($ma->isSunday())){	
			$szamlalo++;
		}
			$ma->addDay(1);
		}
			?>
		<div class="a"><div class=b> <?php echo $szamlalo ?></div> <?php echo " tanítási nap van hátra." ?></div>
		<?php
	}

class Oldal{
	
	function utolso(){
		
		if(isset($_POST['go2'])){

		$most=Carbon::now();
		$majd=Carbon::parse($_POST['ending']);
			
			if($most->isBefore($majd)){
				
			$sql="UPDATE end SET ending='$_POST[ending]' WHERE uid='$_SESSION[uid]'";
			$con = mysqli_connect("localhost:3307","root","","diki");
				
			if ($con->query($sql) === TRUE) {
				echo '<meta http-equiv="refresh" content="1;url=index.php?menu=alap">';
			} else {
				echo "Error updating record: " . $con->error;
			}
			}else {
				echo '<script> alert("A tanév végét nem állíthatod a múltba!")</script>';
			}
		}
	}
	
	function szunet(){		
			if (isset($_POST['go3'])){			
				
				$e=Carbon::parse($_POST['begin']);	
				$v=Carbon::parse($_POST['end']);
				if($e->isBefore($v)){	
			$sql="UPDATE holidays SET begin='$_POST[begin]', end='$_POST[end]' WHERE uid='$_SESSION[uid]' AND descr='$_POST[jelleg]'";
				echo $sql;
			$con = mysqli_connect("localhost:3307","root","","diki");
				$con->set_charset("utf8");
		if ($con->query($sql) === TRUE) {
			echo '<meta http-equiv="refresh" content="1;url=index.php?menu=halado">';
		} else {
    		echo "Hiba: " . $sql . "<br>" . $con->error;
		}
			$con->close();
			}else{
				echo '<script> alert("A szünet vége nem lehet a szünet kezdete előtt!")</script>';	
				}
			}
	}

	
	function szunnap(){		
			if (isset($_POST['go4'])){	
		$con = mysqli_connect("localhost:3307","root","","diki");
		$res=mysqli_query($con, "SELECT * FROM rl_day WHERE date='$_POST[date]'");
		$n=mysqli_num_rows($res);
			
		if ($n<1)
		{		
		$sql = "INSERT INTO rl_day (uid, jel, date, descr) VALUES ('$_SESSION[uid]', '3','$_POST[date]', '$_POST[descr]')";
					//$con = mysqli_connect("localhost:3307","root","","diki");
		if ($con->query($sql) === TRUE) {
			echo '<meta http-equiv="refresh" content="0;url=index.php?menu=szunnapok">';
		} else {
    		echo "Kapcsolódási hiba";
				}
			$con->close();
		}else{
			echo '<script> alert("Ez a dátum már szerpel a listán.")</script>';
		}
	}
		
			if (isset($_POST['go5'])){		
		$con = mysqli_connect("localhost:3307","root","","diki");
		$res=mysqli_query($con, "SELECT * FROM rl_day WHERE date='$_POST[date]'");
		$n=mysqli_num_rows($res);
			
		if ($n>0)
		{		
			echo '<script> alert("Biztos, hogy törölni akarod?")</script>';	
		$sql = "DELETE FROM rl_day WHERE date='$_POST[date]'";
					
		if ($con->query($sql) === TRUE) {
			echo '<meta http-equiv="refresh" content="0;url=index.php?menu=szunnapok">';
		} else {
    		echo "Kapcsolódási hiba";
				}
			$con->close();
		}else{
			echo '<script> alert("Nincs ilyen szünnap, így nem tudom törölni.")</script>';	
		}
	}
}

	function szombat(){		
			if (isset($_POST['go4'])){			
		$res=mysqli_query($con, "SELECT * FROM rl_day WHERE date='$_POST[date]'");
		$n=mysqli_num_rows($res);
		if ($n<1)
		{		
		$sql = "INSERT INTO rl_day (uid, jel, date, changed, descr) VALUES ('$_SESSION[uid]', '4','$_POST[changed]', '$_POST[date]', '$_POST[descr]')";
					$con = mysqli_connect("localhost:3307","root","","diki");
		if ($con->query($sql) === TRUE) {
			echo '<meta http-equiv="refresh" content="0;url=index.php?menu=szombatok">';
    		echo '<div class="alert-box">A dátumot sikeresen feltöltötted. </div>';
		} else {
    		echo "Kapcsolódási hiba";
				}
			$con->close();
		}else{
			echo "Ez a dátum már szerpel a listán";
		}
	}
		
			if (isset($_POST['goSzombat'])){			
		$res=mysqli_query($con, "SELECT * FROM rl_day WHERE date='$_POST[date]'");
		$n=mysqli_num_rows($res);
		if ($n<1)
		{		
			
		$sql = "UPDATE rl_day SET date='$_POST[date]' WHERE uid='$_SESSION[uid]' AND changed='$_POST[changed]'";
					$con = mysqli_connect("localhost:3307","root","","diki");
		if ($con->query($sql) === TRUE) {
			echo $sql;
			echo '<meta http-equiv="refresh" content="20;url=index.php?menu=szombatok">';
    		echo '<div class="alert-box">A dátumot sikeresen feltöltötted. </div>';
		} else {
    		echo "Kapcsolódási hiba";
				}
			$con->close();
		}
	}
	}	
}

class Felhasznaló{
		
	    function __construct($felh) {
			$this->x=$felh;
			
			//->lekéri az utolsó napot, és kiszámolja hány hétfő, kedd,... össz nap van a tanévben
			
		$result=mysqli_query(mysqli_connect("localhost:3307","root","","diki"), "SELECT * FROM end WHERE uid=$this->x");		
				while ($rows = mysqli_fetch_array($result)) 
				{					
					$this->vege=$rows['ending'];
				}
					
		$tv=Carbon::parse($this->vege)->addDay(1);
		$m = Carbon::now()->addDay(1);
		
		$szaml=0;
		
		$hetfo=0;
	    $kedd=0;
		$szerda=0;
		$csutortok=0;
		$pentek=0;
					
		while($m->isBefore($tv)){
			if(!($m->isSaturday()) && !($m->isSunday())){	
			$szaml++;
				if($m->isMonday()){
					$hetfo++;
				}
				if($m->isTuesday()){
					$kedd++;
				}
				if($m->isWednesday()){
					$szerda++;
				}
				if($m->isThursday()){
					$csutortok++;
				}
				if($m->isFriday()){
					$pentek++;
				}
		}
			$m->addDay(1);
		}

				//->lekéri az szüneteket, levonja a hétfő, kedd,... ,össz nap-ot csökkenti
		$m = Carbon::now();	
		$link=mysqli_connect("localhost:3307","root","","diki");
	    $link->set_charset("utf8");
		$result=mysqli_query($link, "SELECT * FROM holidays WHERE uid=$this->x");		
			
			$talalatok_szama= mysqli_num_rows($result);			
				while ($rows = mysqli_fetch_assoc($result)) 
				{						
					$this->tomb1[] = Array('szEleje' => $rows['begin'],'szVege' => $rows['end'], 'leiras'=>$rows['descr']);
		
		
		$e=Carbon::parse($rows['begin']);

		$v=Carbon::parse($rows['end'])->addDay(1);
				
		while($e->isBefore($v)){
			if(!($e->isSaturday()) && !($e->isSunday()) && $m->isBefore($e)){
			$levon++;	
				if($e->isMonday()){
					$hetfo--;
				}
				if($e->isTuesday()){
					$kedd--;
				}
				if($e->isWednesday()){
					$szerda--;
				}
				if($e->isThursday()){
					$csutortok--;
				}
				if($e->isFriday()){
					$pentek--;
				}
		}
			$e->addDay(1);
		}	
					$levonas+=$levon;					
				}

					//->lekéri az szünnapokat, levonja a hétfő, kedd,... ,össz nap-ot csökkenti
		$result=mysqli_query($link, "SELECT * FROM rl_day WHERE uid=$this->x ");

			
				while ($rows = mysqli_fetch_array($result)) 
				{			
					$this->szunnap[]=Array('nap'=>$rows['date'], 'ok'=>$rows['descr']);					
					
					$f=Carbon::parse($rows['date']);
					//echo "szabadnap: ".$f."levonva összesen: ".$levon."<br>";
					//ez az új
					$dupla=0;					
					foreach($this->tomb1 as $a)						
					{
						$bbbb=Carbon::parse($a['szEleje']);
						$cccc=Carbon::parse($a['szVege']);

						while($bbbb->isBefore($cccc)){
						$bbbb->addDay(1);
							if ($f==$bbbb){
								//echo "VAN TALÁLAT!";
								$dupla=1;
							}
					}
					}				
					
				if(!($f->isSaturday()) && !($f->isSunday()) && $m->isBefore($f) && $dupla==0){
					$levon++;				
				if($f->isMonday()){
					$hetfo--;
				}
				if($f->isTuesday()){
					$kedd--;
				}
				if($f->isWednesday()){
					$szerda--;
				}
				if($f->isThursday()){
					$csutortok--;
				}
				if($f->isFriday()){
					$pentek--;
				}
					$dupla==0;
				}
					
				}

						$this->hetfok=$hetfo;
						$this->keddek=$kedd;
						$this->szerdak=$szerda;
						$this->csutortokok=$csutortok;
						$this->pentekek=$pentek;
			
			//szombatok, a nap a szünnapoknál intézve lett, a nap2, ha hátravan, hozzáad egy munkanapot			
		$result=mysqli_query($link, "SELECT * FROM rl_day WHERE uid=$this->x AND jel=4");			
				while ($rows = mysqli_fetch_array($result)) 
				{					
					$this->szombat[]=Array('nap'=>$rows['date'], 'ok'=>$rows['descr'],'nap2'=>$rows['changed'],);	
					//új:
					$sk=Carbon::parse($rows['changed']);//a szombat
					$skk=Carbon::parse($rows['date']);//a ledolgozandó nap

					$dupla=0;					
					foreach($this->tomb1 as $a)						
					{
						$bbbb=Carbon::parse($a['szEleje']);
						$cccc=Carbon::parse($a['szVege']);

						while($bbbb->isBefore($cccc)){
						$bbbb->addDay(1);
							if ($sk==$bbbb){
								$dupla=1;
							}
					}
					}				
					
				if($m->isBefore($sk) && $dupla==0){
					$szaml++;	
					$dupla==0;
					
					$this->szomatokkiirni[]=Array('ledolgozni'=>$skk);
				}
				}
			$this->oszzesMunkanap=$szaml;

			$this->levonas=$levon;
			$this->hatralevo=$this->oszzesMunkanap-$this->levonas;
		}
	
	
			
    function szamol(){		

		
		
			?>
	 <div class="a">A main kívül: <div class=b> <?php  echo /*$this->oszzesMunkanap."-".$this->levonas."=".*/$hatralevo ?></div> <?php echo " tanítási nap van hátra." ?></div>
		<?php
				return $hatralevo;
	}
	
	function feltolt(){
	
		$con = mysqli_connect("localhost:3307","root","","diki");
		$con->set_charset("utf8");

			$sql = "DELETE FROM end WHERE uid=$this->x";
			if ($con->query($sql) === TRUE) {
				echo "Record deleted successfully_1";
			} else {
				echo "Error deleting record: " . $con->error;
			}

			$sql = "DELETE FROM holidays WHERE uid=$this->x";
			if ($con->query($sql) === TRUE) {
				echo "Record deleted successfully_2";
			} else {
				echo "Error deleting record: " . $con->error;
			}

			$sql = "DELETE FROM rl_day WHERE uid=$this->x";
			if ($con->query($sql) === TRUE) {
				echo "Record deleted successfully_3";
			} else {
				echo "Error deleting record: " . $con->error;
			}
		

        $file = fopen("baz.csv", "r");
          while (($getData = fgetcsv($file, 10000, ";")) !== FALSE)
           {				   
			  if($getData[0]=="end")
			  {			  
             $sql = "INSERT into end (jel,ending,uid) 
                   values ('1','".$getData[1]."','$this->x')";			  
                   $result = mysqli_query($con, $sql);  
           	  }
			  			  
			  if($getData[0]=="holidays")
			  {			  
             $sql = "INSERT into holidays (jel,begin,end,descr,uid) 
                   values ('2','".$getData[2]."','".$getData[3]."','".$getData[1]."','$this->x')";			  
                   $result = mysqli_query($con, $sql);  
           	  }			 
			  
			  if($getData[0]=="rl_day")
			  {		
             $sql = "INSERT into rl_day (jel,date,descr,uid) 
                   values ('3','".$getData[2]."','".$getData[1]."','$this->x')";			 
                   $result = mysqli_query($con, $sql);  
           	  }			 
			  
			  if($getData[0]=="saturday")		
			  {			  
             $sql = "INSERT into rl_day (jel,date,descr,changed,uid) 
                   values ('4','".$getData[2]."','".$getData[1]."','".$getData[3]."','$this->x')";			 
                   $result = mysqli_query($con, $sql);  
           	  }
		  }
        fclose($file);  
		
	}

	function lekerUtolsoNap($con)
	{		

		?>
			
			  <h3 class="col-xs-12">UTOLSÓ TANÍTÁSI NAP</h3>
			  <p>Always Look on the Bright Side of Life</p>
			  <table class="table">
				<thead>
					
				  <tr>
					<th>TANÉV</th>
					<th>ÁTTEKINTŐ</th>
				  </tr>
					
				</thead>
				<tbody>  
					
				  <tr >
				
					<td><?php echo $this->vege." <br>( ".Carbon::parse($this->vege)->locale('hu')->isoFormat('dddd')." )-ig" ?></td>
					  <td class="m"><?php echo $this->hatralevo."<br>munkanap" ?></td>
				  </tr>
				

				<tr class="table-success">
					<td >
						HÁTRALÉVŐ HÉTFŐK SZÁMA:
					</td>					
					<td class="m">
						<?php echo $this->hetfok ?>
					</td>
				</tr>
				<tr class="table-primary">
					<td>
						HÁTRALÉVŐ KEDDEK SZÁMA:
					</td>					
					<td class="m">
						<?php echo $this->keddek ?>
					</td>
				</tr>
				<tr class="table-success">
					<td >
						HÁTRALÉVŐ SZERDÁK SZÁMA:
					</td>					
					<td class="m">
						<?php echo $this->szerdak ?>
					</td>
				</tr>
				<tr class="table-primary">
					<td>
						HÁTRALÉVŐ CSÜTÖRTÖKÖK SZÁMA:
					</td>					
					<td class="m">
						<?php echo $this->csutortokok ?>
					</td>
				</tr>
				<tr class="table-success">
					<td>
						HÁTRALÉVŐ PÉNTEKEK SZÁMA:
					</td>					
					<td class="m">
						<?php echo $this->pentekek ?>
					</td>
				</tr>
				<tr class="table-primary">
					<td>
						És még a szombatok:
					</td>
					<td>
						<?php 
						$in=1;
					foreach($this->szomatokkiirni as $sz){						
					echo "EGY SZOMBAT MÉG : <b>".Carbon::parse($sz['ledolgozni'])->locale('hu')->isoFormat('dddd')."</b> LESZ<br>";
						$in++;
					}
						?>
					</td>
				 </tr>	
					<td colspan="2">Módosíthatod a tanév végét: (katt!)</td>
					<tr>
					</tr>
				  <tr class="table-danger">
					<td>
						<form name="urlap" method="post">	
					<input class="admin-input" name="ending" type="date" value="<?php echo $this->vege ?>" placeholder="Az utolsó nap:" required >
					<input name="jel" type="hidden" value="<?php $_SESSION['uid'] ?>">		
					</td>
					
					 <td>		
					<input class="admin-button" type="submit" value="KÜLD" name="go2">
    					</form>
					</td>
				  </tr>
			</tbody>
		</table>
			
			
	<?php
				
	}
	
	function lekerSzunet($con){
 echo  "<h2>SZÜNETEK</h2>
  		 <p>Család, kirándulás, barátok, jókedv, lazulás</p>
		 	<table class=\"table\">
			   <thead>
			     <tr>
				   <th>név</th>
				   <th>KEZDETE</th>
				   <th>VÉGE</th>
			     </tr>
			   </thead>
			   
			<tbody>
	 
	 ";
		  foreach($this->tomb1 as $a)
{
echo "<tr>"."<td class=\"table-warning\">".$a['leiras']."</td>"."<td>".$a['szEleje']."<br>( ".Carbon::parse($a['szEleje'])->locale('hu')->isoFormat('dddd')." )</td>"."<td>".$a['szVege']." <br>( ".Carbon::parse($a['szVege'])->locale('hu')->isoFormat('dddd')." )</td>"."</tr>";
} 

		echo "<tr class=\"table-danger\">
        			
					<td colspan=\"3\">
				<form name=\"urlap\" method=\"post\">
				<input name=\"jel\" type=\"hidden\" value=\"".$_SESSION['uid']."/>
					<div class=\"admin-input\">
		<select class=\"table-warning\" name=\"jelleg\" id=\"fokategoria\"  required>
			<option value=\"a\" disabled selected hidden>jellege</option>
			<option value=\"őszi\">ŐSZI SZÜNET</option>
			<option value=\"téli\">TÉLI  SZÜNET</option>
			<option value=\"tavaszi\">TAVASZI  SZÜNET</option>
		</select>
		</div>
			
	<input name=\"begin\" type=\"date\" placeholder=\"Kezdete\" required />
	
	<input name=\"end\" type=\"date\" placeholder=\"Vége\" required />

	<input type=\"submit\" value=\" MÓDOSÍTÁS \" name=\"go3\">
				</form>
						</td>
					
				</tr>
 			</tbody>
  		</table>
	</div>";
}
	
	function lekerSzabad($con){
echo  "<h2>SZÜNETEK</h2>
		  <p>JUHÉ!!</p>
          
<script>

		function validate(form) 
 {
        var r=confirm('Biztosan törölni akarod?');
        if (r == true) {
  return true;
  
	} else {
  return false;
	}
    
 }
</script>

  		  <table class=\"table\" style=\"width:100%\">
			<thead>
			  <tr>
				
				<th>OKA</th>
				<th>DÁTUM</th>
				<th><button77>TÖRLÉS?<br><h6><small>katt ide!</small></h6><div id=\"div77\"></div></button></th>				 
			  </tr>
			</thead>
			
			<tbody>";	
	
	$i=1;
		foreach($this->szunnap as $b){	

			echo 
		"<tr>
			
			<td width=\"30%\" >".$i.".".$b['ok']."</td>
			<td width=\"30%\" >".$b['nap']." <br>( ".Carbon::parse($b['nap'])->locale('hu')->isoFormat('dddd')." )</td>
			<td width=\"30%\" >
			
					<form onsubmit=\"return validate(this);\" method=\"post\">
						<div id=\"div\" style=\"background:#82CCFB;height:30px;width:80px;position:absolute;\"></div>
						<div><input name=\"date\" type=\"hidden\" value=\"".$b['nap']."\" required/></div>
						<div><input type=\"submit\" value=\"TÖRLÉS\" name=\"go5\"></div>
					</form>
			</td>
			
		</tr>
		<tr> 
			";
			$i++;
		}
		
		echo "<tr class=\"table-success\">
		
				<td colspan=\"3\">
					<form name=\"urlap\" method=\"post\">
						<div><input name=\"date\" type=\"date\" value=".Carbon::now()." required /></div>
						<div><input name=\"descr\" type=\"text\" placeholder=\"leírás*\" /></div>
						<div><input type=\"submit\" value=\"DÁTUM FELTÖLTÉSE\" name=\"go4\"></div>
					</form>
				</td>				
				
		</tr>
			</tbody>
  			</table>";
	}
	
	function lekerSzombat($con){
echo "  <h2>SZOMBATOK</h2>
		  <p>Ajaj...</p>
		  <table class=\"table\">
				<thead>
			  	  <tr>				   
				  
				    <th>SZÜNNAP</th>
					<th>SZOMBAT</th>
			      </tr>
			    </thead>
				
				<tbody>";
		
			$i=1;
		foreach($this->szombat as $b){			
			echo "<tr class=\"m\"  ><td class=\"table-success\" colspan=\"2\" >$i.</td></tr>
			<tr class=\"table-success\">
			
			<td class=\"m\">".$b['nap']." <br>( ".Carbon::parse($b['nap'])->locale('hu')->isoFormat('dddd')." )</td>
			<td class=\"m\"> ".$b['nap2']." <br>( ".Carbon::parse($b['nap2'])->locale('hu')->isoFormat('dddd')." )</td>
				</tr>
				
				<tr class=\"table-success\">
				<td colspan=\"2\" class=\"m\ \"table-success\>MÁSKOR DOLGOZOD LE az $i.-t?</td>
				</tr>
			
			<tr>
			<td colspan=\"2\">
					<form method=\"post\">					
						<input name=\"date\" type=\"date\" value=\"".$b['nap']."\" required />
						<input name=\"changed\" type=\"hidden\" value=\"".$b['nap2']."\" required/>
						<input type=\"submit\" value=\"IGEN, EKKOR!\" name=\"goSzombat\">
					</form>
			</td>
			</tr>

			";
			$i++;
		}
		
			echo "
			
			<tr class=\"table-danger\">
				<td colspan=\"3\">VAN MÁSIK IS? Ha, igen:</td>
			</tr>
			
			<form name=\"urlap\" method=\"post\">
			
			<tr class=\"table-danger\">
				<td><b>A SZOMBAT:</b></td>
				<td colspan=\"2\"><input name=\"date\" type=\"date\" required /></td>
			</tr>			
			
			<tr class=\"table-danger\">
				<td><b>AMIKOR LEDOLGOZOD:</b></td>
				<td colspan=\"2\"><input name=\"changed\" type=\"date\" required /></td>
			</tr>
			
			<tr class=\"table-danger\">
			<td colspan=\"2\">		
				<input name=\"descr\" type=\"text\" placeholder=\"leírás*\" />
				<input type=\"submit\" value=\"DÁTUM FELTÖLTÉSE\" name=\"go4\">
			</td>			
			</tr>
			</form>
			  </tbody>
          </table>";
	}
	
	
}

?>