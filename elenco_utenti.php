<?php

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
<style>
#wrapper{
margin: auto;
	width: 60%;
    padding: 10px;
}
th, td {
  padding: 10px;
  text-align: left;
}
th {
	 font: 18px;
}
table, th, td {
  border: 1px solid black;
}
#content {
    margin: auto;
	width: 80%;
    padding: 10px;
}
</style>
<head >
    <meta charset="UTF-8">
    <title>Elenco utenti</title>
   	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 500px; padding: 20px;  }
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

		<?php

		$sql = "SELECT nome, cognome, username, dataDiNascita, dipendente_id FROM utenti WHERE tipo_utente = 'dipendente' ";
		if($stmt = $pdo->prepare($sql)){

			if($stmt->execute()){
				if($stmt->rowCount() > 0){
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$nome = $row["nome"];
					$cognome = $row["cognome"];
					?>
					<table>
						<thead>
							<tr>
							<th> </th>
							<th>Username</th>
							<th>Data di nascita</th>
							<th> </th>
							<th> </th>
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
					</table>
					</form>
					<hr/>
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

    </div>
</body>
</body>
</html>
