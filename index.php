<?php
session_start();

include "constante.php";
elibereazaDateContact();

//mesajul de intampinare din bara de MENIU
if(!isset($_SESSION['mesajIntampinare'])){
	$_SESSION['mesajIntampinare']= $mesajVid;
}	


if(isset($_SESSION['user'])) {
	
	if( isset($_SESSION['pozaProfil']) ){
		$_SESSION['mesajIntampinare'] = "Esti logat ca ".$_SESSION['user'].$_SESSION['pozaProfil']." <a href= \"pfLinkLogout.php\" >Logout </a>";	
	}else{
		$_SESSION['mesajIntampinare'] = "Esti logat ca ".$_SESSION['user'].". <a href= \"pfLinkLogout.php\" >Logout </a>";
	}
}else
	if( isset( $_POST['user'] ) ){

		if( empty($_POST['user']) || strlen( $_POST['user'] )<3 ||
								!PREG_MATCH($regexUsername, $_POST['user']) ){
			$mesajEroare="Nume lipsa sau invalid";
			
		}elseif(empty($_POST['passwordHome']) || strlen( $_POST['passwordHome'] )<3 ||
								!PREG_MATCH($regexPassword, $_POST['passwordHome']) ){
			$mesajEroare="Parola lipsa sau invalida";
		}		
		else{			
//aici spun asa:
//	1. daca exista clientul si are parola indicata, continuu
//	2. altfel, daca nu exista perechea de date introdusa, cer reInregistrare

		$aiCont = 0;
		$f = fopen($fisierStocare,"r");
		while ( $persoana = fscanf( $f, "%s\t%s\t%s\t%s\t%s\r\n" ) ){
				list ($nume, $user, $password, $admin, $cale_destinatie) = $persoana;
				
				if ($_POST['user'] == $user && $_POST['passwordHome'] == $password){
					$aiCont = 1;
					$_SESSION['nume'] = $nume;
					$_SESSION['user'] = $user;
					$_SESSION['admin'] = $admin;
					if($cale_destinatie=="faraPoza"){
						$_SESSION['mesajIntampinare'] = "Esti logat ca ".$_SESSION['user']." <a href= \"pfLinkLogout.php\" >Logout </a>";
					}else{
						$_SESSION['pozaProfil'] = "<img src = \"".$cale_destinatie."\" height = \"25\" width=\"25\">";
						$_SESSION['mesajIntampinare'] = "Esti logat ca ".$_SESSION['user'].$_SESSION['pozaProfil']." <a href= \"pfLinkLogout.php\" >Logout </a>";	
					}					
				}
		}
		fclose($f);
//aici se termina codul de interogare ListaAbonati pentru verificare cont
			
			
		if( $aiCont==0 ){
			$mesajEroare= "Salut, ".$_POST['user']."! Ai introdus gresit datele de autentificare sau trebuie sa iti faci cont 
				<a href= \"creareCont.php\" >AICI </a>";
		}
		}
	}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home PHP</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="settings.css">

    </head>

    <body>

        <header class="c1b c1f">
          <object height="30"></object>
        </header>


        <!-- MENIU DE NAVIGARE -->
        <nav class="c2b c2f center">
            <table>
                <tr>
                    <td class="active">  <a href="index.php"><i class="fa fa-home"></i> Home Page</a></td>
                    <td> <a href="creareCont.php"><i class="fa fa-magic"></i> Creare cont</a></td>
                    <td> <a href="contact.php"><i class="fa fa-envelope-o"></i> Contact</a></td>
                    <td> <a href="rezervaCamera.php"><i class="fa fa-bed"></i> Rezerva camera</a></td>
                    <td>
                      <?php
                        echo $_SESSION['mesajIntampinare']; //$mesajIntampinare;
                      ?>
                </tr>
            </table>
        </nav>

              <form action="".$_SERVER[PHP_SELF] method="post">
                <fieldset><legend>Date Autentificare</legend>
                <table>
                  <tr>
                    <td>
                      <label> Username:</label>
                    </td>
                    <td>
                      <input type="text" name="user" />
                    </td>
                  </tr>

                  <tr>
                    <td>
                      <label>Password:</label>
                    </td>
                    <td>
                      <input type="password" name="passwordHome"/>
                    </td>
                  </tr>

                </table>

                <p>
                    <input type="submit" value="Autentificare"/>
                </p>
              </fieldset>
              </form>
			  
              <form action='creareCont.php' method="post">
                <fieldset><legend>Doresti Cont?</legend>
                <p>
                  <input type="submit" value="Creare cont"/>
                </p>
              </fieldset>
              </form>
			  
			  <?php
				if ( isset($_SESSION['admin']) && $_SESSION['admin'] == 'da'){
					echo $butonAdmin;
				}				
			  ?>
			  
		<div class="eroare center"><?php echo "".$mesajEroare ?></div>
		
        <footer class="c3b c3f">Pensiunea PHP</footer>
    </body>
</html>
