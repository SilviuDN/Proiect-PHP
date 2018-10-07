<?php
session_start();

include "constante.php";
if(!isset($_SESSION['mesajIntampinare'])){
	$_SESSION['mesajIntampinare']= $mesajVid;
}

if(isset($_POST['reseteazaDateContact']) && $_POST['reseteazaDateContact'] == '1'){
	elibereazaDateContact();
	elibereazaDateContactPOST();
}
$test = '1'; //se anuleaza la primul mesaj de eroare generat de completarea  incorecta a campurilor din formular. 

$mesajEroare = "";


//la prima vizita ca user logat pe pagina, numele de contact devine numele userului
if(isset($_SESSION['nume']) && !isset( $_POST['numeContact']) ) {
	$_SESSION['numeContact'] = $_SESSION['nume'];
	$mesajFinalizare = "Va multumim pentru interes, $_SESSION[numeContact]! Veti fi contactat in cel mai scurt timp...";
	}

	
//CERINTA SUPLIMENTARA: campurile corect completate sa ramana completate
//pe langa $_SESSION['nume'] exista si $_SESSION['numeContact'] deoarece putem primi si mesaje de la clienti neinregistrati
elseif( isset( $_POST['numeContact'] ) ){
//validez numele
			if( empty($_POST['numeContact']) ||
					!PREG_MATCH($regexNume, $_POST['numeContact']) ){
				$mesajEroare .= "<h4>Nume lipsa sau invalid!</h4>";
				$_SESSION['numeContact'] = "";
				$test = '0';
			}else{
				$_SESSION['numeContact'] = $_POST['numeContact'];
				$mesajFinalizare = "Va multumim pentru interes,". $_SESSION['numeContact']."! Veti fi contactat in cel mai scurt timp...";
			}
}


completareDateContact('mailContact', $regexEmail, $mesajEroare, $test);//validare mailContact

completareDateContact('telefonContact', $regexPhone, $mesajEroare, $test);//validare telefonContact

	
	
if( isset( $_POST['sursaContact'] ) ){
//validez rubrica "Cum ati aflat despre noi?"
	if( empty($_POST['sursaContact']) ||
			!in_array($_POST['sursaContact'], $izvor) ){
		$mesajEroare .= "<h4>Sursa de informatie neselectat sau invalid!</h4>";
		$_SESSION['sursaContact'] = "";
		$test = '0';
	}else{
		$_SESSION['sursaContact'] = $_POST['sursaContact'];

	}
}
	
completareDateContact('intrebareContact', $regexIntrebare, $mesajEroare, $test);//validare intrebareContact

?>






<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Contact PHP</title>
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
                  <td class="active"> <a href="contact.php"><i class="fa fa-envelope-o"></i> Contact</a></td>
                  <td> <a href="rezervaCamera.php"><i class="fa fa-bed"></i> Rezerva camera</a></td>
					
					<td>
                      <?php
                        echo $_SESSION['mesajIntampinare']; //echo $_SESSION['mesajIntampinare'];
                      ?>
                    </td>
					
				</tr>
            </table>
        </nav>

        <form action="".$_SERVER[PHP_SELF] method="post">
          <fieldset><legend>Contactati-ne!</legend>
          <table>
            <tr>
              <td>
                <label> Nume Complet:</label>
              </td>
              <td>
                <input type="text" name="numeContact" size="40"  value="<?php pastreazaDateContact('numeContact'); /*if(  isset($_SESSION['numeContact'])  ) echo "".$_SESSION['numeContact'];*/ ?>" placeholder= "Introduceti numele de contact" />
              </td>
            </tr>

            <tr>
              <td>
                <label>Adresa de email:</label>
              </td>
              <td>
                <input type="text" name="mailContact"  size="40" value="<?php pastreazaDateContact('mailContact');/*if(  isset($_SESSION['mailContact'])  ) echo "".$_SESSION['mailContact'];*/ ?>" placeholder="Introduceti adresa de mail"/>
              </td>
            </tr>

            <tr>
              <td>
                <label>Telefon:</label>
              </td>
              <td>
                <input type="text" name="telefonContact"  size="40" value="<?php pastreazaDateContact('telefonContact');/*if(  isset($_SESSION['telefonContact'])  ) echo "".$_SESSION['telefonContact'];*/ ?>" placeholder="Introduceti numarul de telefon"/>
              </td>
            </tr>
            <tr>
              <td>
                  <label>Cum ati aflat despre noi?</label>
              </td>
              <td>
                  <select name="sursaContact">
                    <option value="neselectat" selected>...</option>
                    <option value="prieteni" <?php if(isset($_SESSION['sursaContact']) && $_SESSION['sursaContact']=="prieteni") echo"selected";?> >Prieteni</option>			
                    <option value="google" <?php if(isset($_SESSION['sursaContact']) && $_SESSION['sursaContact']=="google") echo"selected";?> >Google</option>
                    <option value="alteSurse" <?php if(isset($_SESSION['sursaContact']) && $_SESSION['sursaContact']=="alteSurse") echo"selected";?> >Alte surse</option>
                  </select>
              </td>
            </tr>
              <td>
                <label>Intrebarea dumneavoastra:</label>
              </td>
              <td>
                <textarea name="intrebareContact" rows="5" cols="37"  placeholder="Scrieti aici intrebarile sau sugestiile dumneavoastra"><?php pastreazaDateContact('intrebareContact');?></textarea>
				<input type="hidden" name="reseteazaDateContact" value=<?php echo "\"".$test."\""; ?>/>
			  </td>
            <tr>

            </tr>
          </table>


          <p>
				<input type="submit" value="Trimite intrebarea"/>
          </p>
        </fieldset>
        </form>
		
		<div class="eroare center"><?php echo "".$mesajEroare ?></div>
		<div class="finalizare center">
			<?php 
				if ($test == 1 /*$mesajEroare==""*/){
					echo "".$mesajFinalizare;
				}
			?>
		</div>

        <footer class="c3b c3f">Pensiunea PHP</footer>
    </body>
</html>





