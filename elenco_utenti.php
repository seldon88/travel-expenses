<?php

include'CSS/utenti.css';

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["tipo_utente"] !== "admin"){
    header("location: index.php");
    exit;
}

require_once("connessione.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$_SESSION["dipendente_id_viaggi"] = $_POST["id_dipendente"];
    header("location: elenco_viaggi.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head >
    <meta charset="UTF-8">
    <title>Elenco utenti</title>
   	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif;
        }
    tbody{
      vertical-align: middle;
    }
        .wrapper{ width: 1000px; padding: 20px; }
    .btn{
      border: 1px solid black;
    }
    </style>
</head>
<body id="content">
    <div id="wrapper">
		<a class="btn btn-link" href="index.php">HOME</a>
		<a class="btn btn-link" href="insert_utente.php">Aggiungi utente</a>
		<a class="btn btn-danger" href="logout.php" >Esci</a>
		<br/>
		<hr/>
		<h3> Area Amministratore </h3>
		<h4> Elenco utenti </h4>
		<hr/>
		<br/>

    <table style="width:100%;">

      <thead>
      <tr>
        <td>PARTENZA</td>
        <td>DESTINAZIONE</td>
        <td>DISTANZA</td>
        <td></td>
        <td></td>
      </tr>
      </thead>


		<?php
		// Esempio inner join
		//$sql = "SELECT nome, cognome, destinazione, distanzaInKm, dataTrasferta FROM trasferte INNER JOIN utenti ON utenti.dipendente_id = trasferte.dipendente_id";

		$sql = "SELECT nome, cognome, username, dataDiNascita, dipendente_id FROM utenti WHERE tipo_utente = 'dipendente' ";
		if($stmt = $pdo->prepare($sql)){

			if($stmt->execute()){
				if($stmt->rowCount() > 0){
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$nome = $row["nome"];
					$cognome = $row["cognome"];
					?>

						<thead>
							<tr>
							</tr>
						</thead>
					<tr>
					<td><h5><?php echo $row['nome'] ?> <?php echo $row['cognome'] ?></h5></td>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<td><?php echo $row['username'] ?> </td>
						<td><?php echo $row['dataDiNascita'] ?> </td>
						<input type="hidden" name="id_dipendente" class="form-control" value="<?php echo $row['dipendente_id']; ?>" >
						<td><input type="submit" class="btn btn-primary" value="Vedi viaggi"></td>
						<td><button type="button" class="btn btn-danger">Rimuovi utente</td>
					</tr>
					</form>

					<?php
					$_SESSION["nome"] = $nome;
					$_SESSION["cognome"] = $cognome;
					}
				} else{
				echo "Non sono presenti utenti.";
				}
			} else {
                echo "Qualcosa è andato storto. Riprova più tardi.";
            }
			unset($stmt);
		}
        unset($pdo);
		?>
		</table>
    </div>
</body>
</body>
</html>
