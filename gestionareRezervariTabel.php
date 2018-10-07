<?php
session_start();
if(!isset($_SESSION['user'])){
	header('Location: eroareDeConectare.php');
}


include "constante.php";

		header("Content-type: text/html");		
		header("Content-disposition: attachement; filename=gestionareRezervariTabel.html");



echo "<table>";
$f = fopen($fisierRezervari,"r");
	while ( $rezervare = fscanf( $f, "%s\t%s\t%s\t%s\t%s\r\n" ) ){
		list ($user, $tipCamera, $numarNopti, $modalitatePlata, $nrRate) = $rezervare;
		

			echo "<tr>";
				echo "<td>";
					echo $user;
				echo "</td>";
				echo "<td>";
					echo $tipCamera;
				echo "</td>";
				echo "<td>";
					echo $numarNopti;
				echo "</td>";
				echo "<td>";
					echo $modalitatePlata;
				echo "</td>";
				echo "<td>";
					echo $nrRate;
				echo "</td>";			
			echo "</tr>";		
		
		}
fclose($f);

echo "</table>";


?>