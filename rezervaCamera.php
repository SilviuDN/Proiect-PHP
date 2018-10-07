<?php
session_start();
if(!isset($_SESSION['user'])){
	header('Location: eroareDeConectare.php');
}


include "constante.php";


//validez tipCamera
if(isset($_POST['tipCamera'])) {

		if( empty($_POST['tipCamera']) ||
				!in_array($_POST['tipCamera'], $tipCamera) ){
			$mesajEroare =  "<h4>Tip camera lipsa sau invalid!</h4>";
		}
//validez numarNopti
		elseif( empty($_POST['numarNopti']) ||
				!PREG_MATCH($regexNumarNopti, $_POST['numarNopti']) ) {
			$mesajEroare =  "<h4>Numar nopti '".$_POST['numarNopti']."' lipsa sau invalid!</h4>";
				}
//validez modalitatePlata
		elseif( empty($_POST['modalitatePlata']) ||
				!in_array($_POST['modalitatePlata'], $modalitatePlata) ){
			$mesajEroare = isset($_POST['modalitatePlata']) ? "<h4>modalitatePlata '".$_POST['modalitatePlata']."' lipsa sau invalid!</h4>" 
						: "<h4>Nu a fost selectata Modalitatea de plata! </h4>";
				}
				
/*				
//validez numarRate
		elseif( empty($_POST['numarRate']) ||
				!in_array($_POST['numarRate'], $numarRate) ){
			$mesajEroare = "<h4>numarRate '".$_POST['numarRate']."' lipsa sau invalid!</h4>";
				}
*/				
				
		else{
		$_SESSION['tipCamera'] = $_POST['tipCamera'];
		$_SESSION['numarNopti'] = $_POST['numarNopti'];
		$_SESSION['modalitatePlata'] = $_POST['modalitatePlata'];
		
		$f = fopen($fisierRezervari, "a");
		fwrite($f, $_SESSION['user']."\t".$_SESSION['tipCamera']."\t".$_SESSION['numarNopti']."\t".$_SESSION['modalitatePlata']);
		fclose($f);
		
		
		if( $_POST['modalitatePlata'] == "integral" ){
			$stilAfisare = "style=\"display:none\"";
			header('Location: notaDePlata.php');
			$_SESSION['numarRate'] = 1;
			
			$f = fopen($fisierRezervari, "a");
			fwrite($f, "\t".$_SESSION['numarRate']."\r\n");
			fclose($f);
		
		
		}else{
			header('Location: rezervaCameraNrRate.php');
		}
		
		

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
          <fieldset><legend>Completati datele rezervarii dumneavoastra</legend>
            <table>
              <tr>
                <td>
                  <label> Tip camera:</label>
                </td>
                <td>
                  <div>
                    <input type="radio" name="tipCamera" value="double" checked>double <!-- (75$ / noapte)--></input>
                  </div>
                  <div>
                    <input type="radio" name="tipCamera" value="single">single <!-- (50$ / noapte)--></input>
                  </div>
                </td>
              </tr>


              <tr>
                <td>
                  <label>Numar nopti:</label>
                </td>
 
				<td>

                  <select name="numarNopti">
                    <option value="0" checked>...</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
					<option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
					<option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9<o/ption>
					<option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                  </select>
				 </td>
			</tr>
				

<!--	
				<input type="text" list="numarNopti" />
						<datalist>
							<option value="0" checked>...</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3<option>
						</datalist>
-->

                
              

              <tr>
                <td>
                  <label>Modalitate de plata</label>
                </td>
                <td>
                  <div>
                    <input type="radio" name="modalitatePlata" value="integral">integral</input>
                  </div>
                  <div>
                    <input type="radio" name="modalitatePlata" value="inRate">in rate</input>
                  </div>
                </td>
              </tr>

			  
<!--
              <tr>
                <td>
                  <label>Numar rate</label>
                </td>
                <td>
                  <select name="numarRate" >
					<option value="1" select="selected" >1</option>
                    <option value="3">3</option>
                    <option value="6">6</option>
                    <option value="12">12</option>
                  </select>
                </td>
              </tr>
-->
			  
			  
            </table>

			<p>
              <input type="submit" value="Continuare"/>
			</p>
          </fieldset>
        </form>
		
		<div class="eroare center"><?php echo "".$mesajEroare ?></div>


        <footer class="c3b c3f">Pensiunea PHP</footer>
    </body>
</html>
