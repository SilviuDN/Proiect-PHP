<?php

$butonLogout = <<<LOGOUT
	<td>
	<form action='$_SERVER[PHP_SELF]' method="delete">
		<input type="submit" value = "Logout"
	</form>
	</td>

LOGOUT;




$uploadPhoto = <<<UPLOAD
		<form method="post" action="upload.php" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="16384">
			<table>
				<tr>
					<td>
						Alegeti poza de profil:
					</td>
				</tr>
				<tr>
					<td>
						<input type="file" name="fisier" size="40">
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" name="Submit"
					</td>
				</tr>
			</table>		
		</form>

UPLOAD;




$butonAdmin = <<<ADMIN

		<form action='gestionareRezervari.php' method="get">
            <fieldset><legend>Vizionezi rezervarile?</legend>
            <p>
				<input type="submit" value="Vizionare rezervari"/>
            </p>
            </fieldset>
        </form>

ADMIN;




$fisierStocare = "ListaAbonati.txt";

$fisierRezervari = "Rezervari.txt";

$upload_dir = "PozeProfil/";

$prefixPozaProfil = "img-";



$pretPeNoapte = array('single' => '50', 'double' => '75');

$regexNume = '/^[a-zA-Z][A-Za-z\-\. ]{2,}$/' ;

$regexUsername = '/^[a-zA-Z][a-zA-Z\d_]*$/';

$regexPassword2 = '/^\w{4,}$/';

$regexPassword = '/(?=^.{4,}$)(?=.*\W+)/';

$regexEmail = '/^[a-zA-Z\d_\-\.]{1,}@[a-zA-Z\-]{1,}[\.][a-zA-Z]{2,4}$/';

$regexPhone = '/^[0]\d{9}$|^[4][0]\d{9}$/';

$regexPhone = '/^(0|40)\d{9}$/';

$regexNumarNopti = '/^[0-9]{1,2}$/';

$regexIntrebare = '/^.{2,}$/';

$izvor = ['prieteni', 'google', 'alteSurse'];

$tipCamera = ['double', 'single'];

$modalitatePlata = ['integral', 'inRate'];

$numarRate = ['1','2', '3','6','12'];

$mesajVid = "";

$gestionareRezervari = "";

$mesajEroare = "";

$test = 0;



$mesajFinalizare = "";

$mesajIntampinare = "";

$stilAfisare = "";

$numeContactPrecompletat = "";

$mailContactPrecompletat = "";

$telefonContactPrecompletat = "";

$sursaContactPrecompletat = "";

$intrebareContactPrecompletat = "";


//functia pentru eliberarea datelor coresp formularului de contact din tabloul $_SESSION
function elibereazaDateContact(){
		unset($_SESSION['numeContact']);
		unset($_SESSION['mailContact']);
		unset($_SESSION['telefonContact']);
		unset($_SESSION['sursaContact']);
		unset($_SESSION['intrebareContact']);
		unset($_SESSION['reseteazaDateContact']);
}

//functia pentru eliberarea datelor coresp formularului de contact din tabloul $_POST
function elibereazaDateContactPOST(){
		unset($_POST['numeContact']);
		unset($_POST['mailContact']);
		unset($_POST['telefonContact']);
		unset($_POST['sursaContact']);
		unset($_POST['intrebareContact']);
		unset($_POST['reseteazaDateContact']);
}

//functie pentru verificarea formatului datelor introduse in formularul de contact
function completareDateContact($rubrica, $regex, &$mesaj, &$test){
	if( isset( $_POST[$rubrica] ) ){
	if( empty($_POST[$rubrica]) ||
			!PREG_MATCH($regex, $_POST[$rubrica]) ){
		$mesaj .= "<h4>".$rubrica."'".$_POST[$rubrica]."' lipsa sau invalid!</h4>";
		$_SESSION[$rubrica] = "";
		$test = '0';
	}else{
		$_SESSION[$rubrica] = $_POST[$rubrica];
	}	
}else{
	$_SESSION[$rubrica] = "";
	$test = '0';
}
}

//functie pentru pastrarea datelor de contact valide in formularul de contact
//pentru numeContact, mailContact, telefonContact, intrebareContact
function pastreazaDateContact($rubrica){
	if(  isset($_SESSION[$rubrica])  ) echo "".$_SESSION[$rubrica];
}

?>
