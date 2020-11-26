<?php

include'CSS/viaggi.css';

session_start();


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

require_once("connessione.php");

if($_SESSION["tipo_utente"] == "admin"){
	$id = $_SESSION["dipendente_id_viaggi"];
}else{
	$id = $_SESSION["dipendente_id"];
}

$rimborso = "";
$month = "";
$year = "";


$mesi = array(1=>'gennaio', 'febbraio', 'marzo', 'aprile',
                'maggio', 'giugno', 'luglio', 'agosto',
                'settembre', 'ottobre', 'novembre','dicembre');

list($month,$year) = explode('-',date('n-Y'));

if($_SERVER["REQUEST_METHOD"] == "POST"){

	if($_SESSION["tipo_utente"] == "admin"){

		if($_POST["rimborso"]){
			$rimborso = trim($_POST["rimborso"]);

			// Imposto il viaggio rimborsato - solo per amministratore
			$sql = "UPDATE Trasferte SET rimborsato='si' WHERE trasferte_id = :rimborso_id ";

			if($stmt = $pdo->prepare($sql)){
				$stmt->bindParam(":rimborso_id", $param_rimborso, PDO::PARAM_STR);
				$param_rimborso = trim($_POST["rimborso"]);
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
}
?>


<!DOCTYPE html>
<html lang="en">

<head >
    <meta charset="UTF-8">
    <title>Elenco viaggi</title>
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
		<?php if($_SESSION["tipo_utente"] == "admin"){ ?>
			<a class="btn btn-link" >Gestisci trasferte</a>
		<?php }else{ ?>
			<a class="btn btn-link" href="insert_viaggio.php">Aggiungi trasferta</a>
		<?php } ?>
		<a class="btn btn-link" href="logout.php" >Esci</a>
		<br/>
		<hr/>

		<?php

    // Visualizza il nome e il cognome e il mese anno corrente
		$sql1 = "SELECT nome, cognome, dipendente_id FROM utenti WHERE dipendente_id = :dipendente_id";

    if($stmt = $pdo->prepare($sql1)){
      if($stmt->execute(array(':dipendente_id' => $id))){
        if($stmt->rowCount() > 0){
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <h2>Trasferte di <?php echo $row["nome"] ?> <?php echo $row["cognome"] ?> </h2>
          <h3> <?php echo $mesi[$month],' ',$year; ?> </h3>

          <!--
		  	<input type="checkbox" name="rimborso" value =?php echo $row["trasferte_id"] ?>" >Rimborso
			<input type="submit" value="Eseguito" >
          -->

          <form action="" method="post">
          <div class="form-group">
             <select id="month_start" name="mese" />
             <option value="" selected="selected" hidden="hidden">Seleziona mese</option>
             <option value="1" >Gennaio</option>
             <option value="2" >Febbraio</option>
             <option value="3" >Marzo</option>
             <option value="4" >Aprile</option>
             <option value="5" >Maggio</option>
             <option value="6" >Giugno</option>
             <option value="7" >Luglio</option>
             <option value="8" >Agosto</option>
             <option value="9" >Settembre</option>
             <option value="10">Ottobre</option>
             <option value="11" >Novembre</option>
             <option value="12" >Dicembre</option>
             </select> -
             <select id="year_start"   name="anno" />
             <option value="" selected="selected" hidden="hidden">Seleziona anno</option>
             <option>2018</option>
             <option>2019</option>
             <option>2020</option>
             <option>2021</option>
             <option>2022</option>
             <option>2023</option>
             <option>2024</option>
             <option>2025</option>
             </select>
             </fieldset>
             <span class="form-group">
               <input id="bottone_vedi" type="submit" class="btn btn-primary" value="Vedi">
             </span>
           </div>
         </form>
          <?php
        }
      }
    } else {
      echo "Qualcosa è andato storto. Riprova più tardi.";
    }
      unset($stmt);
    }


    // Visualizza i viaggi per il mese corrente
		$sql3 = "SELECT utenti.nome, utenti.cognome, trasferte_id, partenza, destinazione,
    distanzaInKm, autostrada, motivazione, trasportoPubblico, altreSpese, dataTrasferta,
    rimborsato, rimborsoTotale FROM trasferte
    INNER JOIN utenti ON utenti.dipendente_id = trasferte.dipendente_id
    WHERE trasferte.dipendente_id = :id_dipendente
    AND MONTH(trasferte.dataTrasferta) = ".(isset($_GET["month"]) ? $_GET["month"] : "MONTH(CURDATE())")."
    AND YEAR(trasferte.dataTrasferta) = ".(isset($_GET["year"]) ? $_GET["year"] : "YEAR(CURDATE())")."
    ORDER BY dataTrasferta DESC";

    if($stmt = $pdo->prepare($sql3)){
			if($stmt->execute(array(':id_dipendente' => $id))){
				if($stmt->rowCount() > 0){
          ?>

          <hr/>
          <table>
            <thead>
            <tr>
              <td>PARTENZA</td>
              <td>DESTINAZIONE</td>
              <td>DISTANZA</td>
              <td>AUTOSTRADA</th>
              <td>MOTIVAZIONE</td>
              <td>TRASPORTI</td>
              <td>ALTRE SPESE</td>
              <td>DATA TRASFERTA</td>
              <td>RIMBORSO TOTALE</td>
              <td>SITUAZIONE RIMBORSO</td>
            </tr>
            </thead>
            <tbody>

              <?php
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$rimborsato= $row["rimborsato"];
						?>
						<tr>
						<td> <?php echo $row['partenza'] ?> 	</td>
						<td> <?php echo $row['destinazione'] ?> </td>
						<td> <?php echo $row['distanzaInKm'] ?> km </td>
						<td> <?php echo $row['autostrada'] ?>  € </td>
						<td> <?php echo $row['motivazione'] ?>  </td>
						<td> <?php echo $row['trasportoPubblico'] ?> € </td>
						<td> <?php echo $row['altreSpese'] ?>  € </td>
						<td> <?php echo $row['dataTrasferta'] ?> </td>

						<td id="totale"> <?php echo $row['rimborsoTotale'] ?> € </td>

						<?php if(($rimborsato != "si") AND ($_SESSION["tipo_utente"] == "admin")) { ?>
						<td> <form action="" method="post">
							<input type="checkbox" name="rimborso" value ="<?php echo $row["trasferte_id"] ?>" >Rimborso
							<input type="submit" value="Eseguito" >
						</form></td>
						<?php } elseif($rimborsato == "si") { ?>
						<td><div id="rimborsato">Rimborsato</div></td>
						<?php } elseif(($rimborsato != "si") AND !($_SESSION["tipo_utente"] == "admin")) { ?>
						<td><div id="norimborsato">Non rimborsato</div></td>
						<?php
						} ?>
						</tr>
						<?php
					}
				} else{
          echo "Non sono presenti viaggi.";
				}
			} else {
          echo "Qualcosa è andato storto. Riprova più tardi.";
            }
			unset($stmt);
		}
    unset($pdo);
		?>

			</tbody>
		</table>
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script>
    $( "#bottone_vedi" ).click(function() {
      var month = $("#month_start").val();
      var year = $("#year_start").val();
      if(month!="" && year!=""){
      //window.open("?month="+$("#month_start").val()+"&year="+$("#year_start").val());
      window.open("?month="+$("#month_start").val()+"&year="+$("#year_start").val());
    } else {
      alert("Sei un mona!");
    }
    });
  </script>
  <button onclick="window.print()">Stampa</button>
</body>
</body>
</html>
