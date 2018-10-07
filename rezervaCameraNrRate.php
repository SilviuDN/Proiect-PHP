<?php
session_start();
if(!isset($_SESSION['user'])){
	header('Location: eroareDeConectare.php');
}


include "constante.php";



//validez numarRate
if(isset($_POST['numarRate'])) {
		if( empty($_POST['numarRate']) ||
				!in_array($_POST['numarRate'], $numarRate) ){
			$mesajEroare = "<h4>numarRate '".$_POST['numarRate']."' lipsa sau invalid!</h4>";
				}
		else{
			$_SESSION['numarRate'] = $_POST['numarRate'];
			
			$f = fopen($fisierRezervari, "a");
			fwrite($f, "\t".$_SESSION['numarRate']."\r\n");
			fclose($f);
			
			
			header('Location: notaDePlata.php');
		}
}
		



?>

<!doctype html>
<html>
    <head>
        <title>Rezervari PHP</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="settings.css">

    </head>
    <body>
      <header class="c1b c1f">
        <object height="30"></object>
      </header>
        <nav class="c2b c2f center">
            <table>
                <tr>
                  <td>  <a href="index.php"><i class="fa fa-home"></i> Home Page</a></td>
                  <td> <a href="creareCont.php"><i class="fa fa-magic"></i> Creare cont</a></td>
                  <td> <a href="contact.php"><i class="fa fa-envelope-o"></i> Contact</a></td>
                  <td class="active"> <a href="rezervaCamera.php"><i class="fa fa-bed"></i> Rezerva camera</a></td>
                   
				   <td>
                      <?php
                        echo $_SESSION['mesajIntampinare'];
                      ?>
                    </td>

				</tr>
            </table>
        </nav>

        <form action="".$_SERVER[PHP_SELF] method="post">
          <fieldset><legend>Continuati completarea datele rezervarii dumneavoastra</legend>
            <table>
              <tr>
                <td>
                  <label> Tip camera:</label>
                </td>
                <td>
					<?php
                        echo $_SESSION['tipCamera'];
                     ?>
                </td>
              </tr>


              <tr>
                <td>
                  <label>Numar nopti:</label>
                </td>
 
				<td>
					<?php
                        echo $_SESSION['numarNopti'];
                     ?>
				 </td>
			</tr>

              <tr>
                <td>
                  <label>Modalitate de plata:</label>
                </td>
                <td>
					in rate
                  <?php
                        //echo $_SESSION['modalitatePlata'];
                   ?>
                </td>
              </tr>

			  
              <tr>
                <td>
                  <label>Numar rate</label>
                </td>
                <td>
                  <select name="numarRate" style="background-color:#ffff98;">
					<option value="2" select="selected" >2</option>
                    <option value="3">3</option>
                    <option value="6">6</option>
                    <option value="12">12</option>
                  </select>
                </td>
              </tr>
			  
			  
            </table>

			<p>
              <input type="submit" value="Trimite rezervarea"/>
			</p>
          </fieldset>
        </form>
		
		<div class="eroare center"><?php echo "".$mesajEroare ?></div>


        <footer class="c3b c3f">Pensiunea PHP</footer>
    </body>
</html>
