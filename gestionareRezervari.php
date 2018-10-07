<?php
session_start();
/*
if($_SESSION['admin'] == 'nu'){
	header('Location: eroareDeConectare.php');
}
*/

include "constante.php";

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


echo "<form action=\"gestionareRezervariTabel.php \" method=\"post\">";
echo "</table>";
echo "<table>";
			echo "<tr>";
				echo "<td>";
					echo "Pentru a salva informatia: ";
				echo "</td>";
				echo "<td>";
					echo "<input type=\"submit\" name=\"salveazaRezervari\" value=\"Salveaza rezervari\"/>";
				echo "</td>";			
			echo "</tr>";
			echo "<tr>";
				echo "<td>";
					echo "Pentru HomePage: ";
				echo "</td>";
				echo "<td>";
					echo "<a href=\"index.php\" >APASA AICI <i class=\"fa fa-home\"></i></a>";
				echo "</td>";			
			echo "</tr>";
echo "</table>";
echo "</form>";

?>

			