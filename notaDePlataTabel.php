<?php
session_start();
if(!isset($_SESSION['user'])){
	header('Location: eroareDeConectare.php');
}


include "constante.php";

		header("Content-type: text/html");		
		header("Content-disposition: attachement; filename=notaDePlataTabel.html");

?>

<table>
	  <tr>
		<td>
		  <label> Tip camera:</label>
		</td>
		<td>
		  <?php echo "".$_SESSION['tipCamera']; ?>
		</td>
	  </tr>

	  <tr>
		<td>
		  <label>Numar nopti:</label>
		</td>
		<td>
		  <?php echo $_SESSION['numarNopti']; ?>
		</td>
	  </tr>

	  <tr>
		<td>
		  <label>Modalitate de plata:</label>
		</td>
		<td>
		  <?php echo $_SESSION['modalitatePlata']; ?>
		</td>
	  </tr>

	  <tr>
		<td>
		  <label>Numar rate:</label>
		</td>
		<td>
		  <?php echo $_SESSION['numarRate']; ?>
		</td>
	  </tr>
	  <tr>
		<td>
		  <label>Total de plata:</label>
		</td>
		<td>
		  <?php echo $total = $_SESSION['numarNopti']*$pretPeNoapte[ $_SESSION['tipCamera'] ]." \$"; ?>
		</td>
	  </tr>
	  
	  <tr>
		<td>
		  <label>Rata:</label>
		</td>
		<td>
		  <?php echo $total/$_SESSION['numarRate']." \$" ; ?>
		</td>
	  </tr>
	  
	  
	  
</table>