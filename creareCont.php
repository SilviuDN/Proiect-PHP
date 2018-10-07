<?php
session_start();

include "constante.php";

//mesajul de intampinare din bara de MENIU
if(!isset($_SESSION['mesajIntampinare'])){
	$_SESSION['mesajIntampinare']= $mesajVid;
}	


if(!isset($_SESSION['nume']) && isset( $_POST['numeCreare'])){

$aiCont = 0;
//aici spun asa:
//	1. daca exista user-ul, ma opreesc
//	2. altfel, daca nu exista, copiez $_POST in $_SESSION

	$f = fopen($fisierStocare,"r");
		while ( $persoana = fscanf( $f, "%s\t%s\t%s\t%s\t%s\r\n" ) ){
			list ($nume, $user, $password, $admin, $cale_destinatie) = $persoana;
			if ($_POST['user'] == $user){
				$mesajEroare= "Salut, ".$user."! Ai deja cont sau username-ul ales nu este disponibil!!!<br>
						Pentru autentificare completeaza formularul de
						<a href= \"index.php\" >AICI </a>
						Pentru recuperare parola completeaza formularul de
						<a href= \"contact.php\" >AICI </a>";
				$aiCont = 1;
			}
		}
	fclose($f);
//aici se termina codul de interogare ListaAbonati


//validare date
	if($aiCont == 0){
//validare nume
		if( empty($_POST['numeCreare']) ||
				!PREG_MATCH($regexNume, $_POST['numeCreare']) ){
			$mesajEroare="Nume lipsa sau invalid";
		}			
//validare username
		elseif( empty($_POST['user']) ||
				!PREG_MATCH($regexUsername, $_POST['user']) ){
			$mesajEroare="Username lipsa sau invalid";
				}
//validare parola
		elseif( empty($_POST['passwordCreare']) ||
				!PREG_MATCH($regexPassword, $_POST['passwordCreare']) ){
			$mesajEroare="Parola lipsa sau invalida";
				}

		else{
			$_SESSION['nume'] = $_POST['numeCreare'];
			$_SESSION['user'] = $_POST['user'];
			$_SESSION['passwordHome'] = $_POST['passwordCreare'];
			
			$_SESSION['mesajIntampinare'] = "Esti logat ca ".$_SESSION['user'].". <a href= \"pfLinkLogout.php\" >Logout </a>";
			
			$_SESSION['admin'] = 'nu';
				
		//salvez datele de identificare in fisierul "ListaAbonati"
			$f = fopen($fisierStocare,"a+");
			fwrite($f, $_SESSION['nume']."\t".$_SESSION['user']."\t".$_SESSION['passwordHome']."\t".$_SESSION['admin']."\t" );
			fclose($f);
				
		//SALVEZ POZELE DE PROFIL IN DIRECTORUL "PozeProfil"					
			switch($_FILES['fisier']['error']){
				case UPLOAD_ERR_OK:
					$caleDestinatie = basename(tempnam($upload_dir, $prefixPozaProfil )); //$upload_dir.basename($_FILES['fisier']['name']);/*tmp_*/
					$cale_destinatie = $upload_dir.$caleDestinatie;
					if( move_uploaded_file( $_FILES['fisier']['tmp_name'], $cale_destinatie ) ){
						$mesajFinalizare="Fisier salvat cu succes!";
						
						$_SESSION['pozaProfil'] = "<img src = \"".$cale_destinatie."\" height = \"25\" width=\"25\">";
						$_SESSION['mesajIntampinare'] = "Esti logat ca ".$_SESSION['user'].$_SESSION['pozaProfil']." <a href= \"pfLinkLogout.php\" >Logout </a>";
						
						//scriu in lista adresa fisierului cu imaginea de profil
						$f = fopen($fisierStocare,"a+");
						fwrite($f, $cale_destinatie."\r\n" );
						fclose($f);
						
					}else{
						$f = fopen($fisierStocare,"a+");
						fwrite($f,"faraPoza\r\n" );
						fclose($f);
						$mesajEroare .= "Fisierul uploadat nu a putut fi salvat";
					}
					break;
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					$mesajEroare .=  "Fisierul uploadat depaseste dimensiunea maxima admisa!";
						$f = fopen($fisierStocare,"a+");
						fwrite($f,"faraPoza\r\n" );
						fclose($f);
					break;
				case UPLOAD_ERR_NO_FILE:
					$mesajEroare .=  "Nu ati selectat niciun fel de fisier";
						$f = fopen($fisierStocare,"a+");
						fwrite($f,"faraPoza\r\n" );
						fclose($f);
					break;
				default:
					$mesajEroare .=  "Eroare la uploadarea fisierului.";
						$f = fopen($fisierStocare,"a+");
						fwrite($f,"faraPoza\r\n" );
						fclose($f);
					break;
			}
		}				
	}
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ContNou PHP</title>
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
					<td>  <a href="index.php"> <i class="fa fa-home"></i> Home Page</a></td>
					<td class="active"> <a href="creareCont.php"><i class="fa fa-magic"></i> Creare cont</a></td>
					<td> <a href="contact.php"><i class="fa fa-envelope-o"></i> Contact</a></td>
					<td> <a href="rezervaCamera.php"><i class="fa fa-bed"></i> Rezerva camera</a></td>
					<td>
						  <?php
							echo $_SESSION['mesajIntampinare']; //$mesajIntampinare;
						  ?>
					</td>

				</tr>
            </table>
        </nav>

        <form action="".$_SERVER[PHP_SELF] method="post" enctype="multipart/form-data">
          <fieldset><legend>Completati Datele de Acces</legend>
          <table>
            <tr>
              <td>
                <label> Nume complet:</label>
              </td>
              <td>
                <input type="text" name="numeCreare" />
              </td>
            </tr>

            <tr>
              <td>
                <label>Username:</label>
              </td>
              <td>
                <input type="text" name="user"/>
              </td>
            </tr>

            <tr>
              <td>
                <label>Password:</label>
              </td>
              <td>
                <input type="password" name="passwordCreare"/>
              </td>
            </tr>
			
			<tr>
				<td>
					<input type="hidden" name="MAX_FILE_SIZE" value"16384">
					<label>Poza avatar:</label>
				</td>
				<td>					
					<input type="file" name="fisier" >
				</td>
			</tr>
          </table>

          <p>
              <input type="submit" value="CreareCont"/>
          </p>
        </fieldset>
        </form>

		<div class="eroare center"><?php echo "".$mesajEroare ?></div>
		<div class="finalizare center"><?php echo "".$mesajFinalizare ?></div>
		
        <footer class="c3b c3f">Pensiunea PHP</footer>
		
		
    </body>
</html>
