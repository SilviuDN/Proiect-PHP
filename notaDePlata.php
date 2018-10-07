<?php
session_start();
if(!isset($_SESSION['user'])){
	header('Location: eroareDeConectare.php');
}

include "constante.php";

if(isset($_POST['salveazaInformatii'])) {	
		header('Location: notaDePlataTabel.php');			///NU MERGE!!!
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
                  <label>Numar rate:</label>
                </td>
                <td>
                  <?php
                        echo $_SESSION['numarRate']
                  ?>
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
                  <?php echo number_format($total/$_SESSION['numarRate'],2)." \$" ; ?>
                </td>
              </tr>
			  
			  <tr>
				<td>
					Pentru a salva informatia:
				</td>
				<td>
					<input type="submit" name="salveazaInformatii" value="Salveaza informatii"/>
				</td>
			  </tr>
			  
			  <tr>
				<td style="word-wrap: break-word">
					Pentru HomePage:
				</td>
				<td>					
					<a href="index.php" >APASA AICI <i class="fa fa-home"></i></a>
				</td>
			  </tr>
			  
			  
            </table>

          </fieldset>
        </form>
		
		<div class="eroare center"><?php echo "".$mesajEroare ?></div>


        <footer class="c3b c3f">Pensiunea PHP</footer>
    </body>
</html>