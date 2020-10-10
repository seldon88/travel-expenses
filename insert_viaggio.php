<?php

// campo con rimborso totale su tabella
// http://html.cita.illinois.edu/nav/form/date/index.php?example=6

// PARAMETRO COSTO BENZINA

// inserire si o no rimborso effettuato
// riga con totale
// pulsante stampa


session_start();

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
    header("location: index.php");
    exit;
}

require_once "connessione.php";

$partenza = "";
$destinazione = "";
$distanza = "";
$autostrada = "";
$motivazione = "";
$trasportoPubblico = "";
$altreSpese = "";
$data = "";

$partenza_err = "";
$destinazione_err = "";
$distanza_err = "";
$autostrada_err = "";
$motivazione_err = "";
$trasportoPubblico_err = "";
$altreSpese_err = "";
$data_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

	if(empty(trim($_POST["partenza"]))){
		$partenza_err = "Inserisci partenza.";
	} else{
		$partenza = trim($_POST["partenza"]);
	}

	if(empty(trim($_POST["destinazione"]))){
		$destinazione_err = "Inserisci destinazione.";
	} else{
		$destinazione = trim($_POST["destinazione"]);
	}

	if(empty(trim($_POST["distanza"]))){
		$distanza_err = "Inserisci distanza in chilometri.";
	} else{
		$distanza = trim($_POST["distanza"]);
	}

	if(empty(trim($_POST["autostrada"]))){
		$autostrada = 0;
	} else{
		$autostrada = trim($_POST["autostrada"]);
	}

	if(empty(trim($_POST["motivazione"]))){
		$motivazione_err = "Inserisci motivazione.";
	} else{
		$motivazione = trim($_POST["motivazione"]);
	}

	if(empty(trim($_POST["trasportoPubblico"]))){
		$trasportoPubblico = 0;
	} else{
		$trasportoPubblico = trim($_POST["trasportoPubblico"]);
	}

	if(empty(trim($_POST["altreSpese"]))){
		$altreSpese = 0;
	} else{
		$altreSpese = trim($_POST["altreSpese"]);
	}

	if(empty(trim($_POST["data"]))){
		$data_err = "Inserisci data";
	} else{
		$data = trim($_POST["data"]);
	}

	if(empty($destinazione_err && $distanza_err && $autostrada_err && $motivazione_err && $trasportoPubblico_err && $altreSpese_err && $data_err )){

		$sql = "INSERT INTO Trasferte (destinazione, distanzaInKm, dataTrasferta, dipendente_id, motivazione, partenza, autostrada, trasportoPubblico, altreSpese, rimborsoTotale) VALUES (:destinazione, :distanzaInKm, :dataTrasferta, :dipendente_id, :motivazione, :partenza, :autostrada, :trasportoPubblico, :altreSpese, :rimborsoTotale)";

		if($stmt = $pdo->prepare($sql)){

			$stmt->bindParam(":partenza", $param_partenza, PDO::PARAM_STR);
			$param_partenza = trim($_POST["partenza"]);

			$stmt->bindParam(":destinazione", $param_destinazione, PDO::PARAM_STR);
			$param_destinazione = trim($_POST["destinazione"]);

			$stmt->bindParam(":distanzaInKm", $param_distanza, PDO::PARAM_INT);
			$param_distanza = trim($_POST["distanza"]);

			$stmt->bindParam(":autostrada", $param_autostrada, PDO::PARAM_INT);
			$param_autostrada = trim($_POST["autostrada"]);

			$stmt->bindParam(":motivazione", $param_motivazione, PDO::PARAM_STR);
			$param_motivazione = trim($_POST["motivazione"]);

			$stmt->bindParam(":trasportoPubblico", $param_trasportoPubblico, PDO::PARAM_INT);
			$param_trasportoPubblico = trim($_POST["trasportoPubblico"]);

			$stmt->bindParam(":altreSpese", $param_altreSpese, PDO::PARAM_INT);
			$param_altreSpese = trim($_POST["altreSpese"]);

			$stmt->bindParam(":dataTrasferta", $param_data, PDO::PARAM_STR);
			$param_data = trim($_POST["data"]);

			$stmt->bindParam(":rimborsoTotale", $rimborsoTotale, PDO::PARAM_INT);
			$rimborsoTotale = ($param_distanza * 2 * 0.4228) + $param_autostrada + $param_trasportoPubblico + $param_altreSpese;

			$stmt->bindParam(":dipendente_id", $param_id, PDO::PARAM_INT);
			$param_id =  $_SESSION["dipendente_id"];

			if($stmt->execute()){
				header("location: elenco_viaggi.php");
				exit;
			} else{
				echo "Qualcosa è andato storto.";
			}
			unset($stmt);
		}
		unset($pdo);
	}

}

?>



<!DOCTYPE html>
<html lang="en">
<style>
.content {
	margin: auto;
	width: 70%;
    padding: 10px;
}
.wrapper{
margin: auto;
	width: 70%;
    padding: 10px;
}
</style>
<head class="content">
    <meta charset="UTF-8">
    <title>Inserisci trasferta</title>
   	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 400px; padding: 20px; }
    </style>
</head>
<body class="content">
    <div class="wrapper">
        <h2>Nuova trasferta</h2>
        <p>Compila i campi.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

			 <div class="form-group <?php echo (!empty($partenza_err)) ? 'has-error' : ''; ?>">
                <label>Partenza</label>
                <input type="text" name="partenza" class="form-control" value="<?php echo $partenza; ?>">
                <span class="help-block"><?php echo $partenza_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($destinazione_err)) ? 'has-error' : ''; ?>">
                <label>Destinazione</label>
                <input type="text" name="destinazione" class="form-control" value="<?php echo $destinazione; ?>">
                <span class="help-block"><?php echo $destinazione_err; ?></span>
            </div>

			<div class="form-group <?php echo (!empty($distanza_err)) ? 'has-error' : ''; ?>">
                <label>Distanza in chilometri</label>
                <input type="text" name="distanza" class="form-control" value="<?php echo $distanza; ?>">
                <span class="help-block"><?php echo $distanza_err; ?></span>
            </div>

			<div class="form-group <?php echo (!empty($autostrada_err)) ? 'has-error' : ''; ?>">
                <label>Costi autostrada</label>
                <input type="text" name="autostrada" class="form-control" value="<?php echo $autostrada; ?>">
                <span class="help-block"><?php echo $autostrada_err; ?></span>
            </div>

			<div class="form-group <?php echo (!empty($motivazione_err)) ? 'has-error' : ''; ?>">
                <label>Motivazione</label>
                <input type="text" name="motivazione" class="form-control" value="<?php echo $motivazione; ?>">
                <span class="help-block"><?php echo $motivazione_err; ?></span>
            </div>

			<div class="form-group <?php echo (!empty($trasportoPubblico_err)) ? 'has-error' : ''; ?>">
                <label>Costi trasporto pubblico</label>
                <input type="text" name="trasportoPubblico" class="form-control" value="<?php echo $trasportoPubblico; ?>">
                <span class="help-block"><?php echo $trasportoPubblico_err; ?></span>
            </div>

			<div class="form-group <?php echo (!empty($altreSpese_err)) ? 'has-error' : ''; ?>">
                <label>Altre Spese</label>
                <input type="text" name="altreSpese" class="form-control" value="<?php echo $altreSpese; ?>">
                <span class="help-block"><?php echo $altreSpese_err; ?></span>
            </div>

			<div class="form-group <?php echo (!empty($data_err)) ? 'has-error' : ''; ?>">
            <label>Data</label>
            <input type="text" id="datepicker" class="form-control">
            <span class="help-block"><?php echo $data_err; ?></span>
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <link rel="stylesheet" href="/resources/demos/style.css">
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script>
            $( function() {
              $( "#datepicker" ).datepicker({
                dateFormat: "yy-mm-dd"
              });
            } );
            </script>
      </div>

		<div class="form-group">
                <input type="submit" class="btn btn-primary" value="Aggiungi trasferta">
            </div>

		<a href="elenco_viaggi.php">Torna all'elenco viaggi</a>

		</form>
    </div>
</body>
</html>
