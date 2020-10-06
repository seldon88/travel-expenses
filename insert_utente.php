<?php

// data di nascita con campi divisi

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

require_once("connessione.php");

$nome = "";
$cognome = "";
$username = "";
$password = "";
$conferma_password = "";
$datadinascita = "";
$sesso = "";

$nome_err = "";
$cognome_err = "";
$username_err = "";
$password_err = "";
$conferma_password_err = "";
$datadinascita_err = "";
$sesso_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	if(empty(trim($_POST["username"]))){
		$username_err = "Inserisci username.";
	} else{
		$sql = "SELECT * FROM utenti WHERE username = :username";
		
		if($stmt = $pdo->prepare($sql)){
			$stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
			$param_username=trim($_POST["username"]);
			
			if($stmt->execute()){
				if($stmt->rowCount == 1){
					$username_err = "Username già presente. Consigliato username coincidente con il cognome";
				} else{
					$username = trim($_POST["username"]);
				}
			} else{
				echo "Qualcosa è andato storto";
			}
		}
		unset($stmt);
	}
	
	 if(empty(trim($_POST["password"]))){
        $password_err = "Inserisci una password.";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "La password deve avere almeno 8 caratteri.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["conferma_password"]))){
        $conferma_password_err = "Conferma password.";     
    } else{
        $conferma_password = trim($_POST["conferma_password"]);
        if(empty($password_err) && ($password != $conferma_password)){
            $conferma_password_err = "La password non coincide.";
        }
    }
	
	if(empty(trim($_POST["nome"]))){
        $nome_err = "Inserisci un nome.";     
    } else{
        $nome = trim($_POST["nome"]);
    }
	
	if(empty(trim($_POST["cognome"]))){
        $cognome_err = "Inserisci un cognome.";     
    } else{
        $cognome = trim($_POST["cognome"]);
    }
	
	if(empty(trim($_POST["datadinascita"]))){
        $datadinascita_err = "Inserisci una data di nascita.";     
    } else{
        $datadinascita = trim($_POST["datadinascita"]);
    }
	
	if(empty(trim($_POST["sesso"]))){
        $sesso_err = "Inserisci il sesso della persona.";     
    } else{
        $sesso = trim($_POST["sesso"]);
    }
	
	if(empty($nome_err &&  $cognome_err && $username_err &&	$password_err && $conferma_password_err && $datadinascita_err && $sesso_err)){
	
		$sql = "INSERT INTO utenti (username, password, nome, cognome, dataDiNascita, sesso, tipo_utente) VALUES (:username, :password, :nome, :cognome, :dataDiNascita, :sesso, :tipo_utente)";
		
		if($stmt = $pdo->prepare($sql)){
			
			$stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
			$param_username = trim($_POST["username"]);
			
			$stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
			$param_password = password_hash($password, PASSWORD_DEFAULT);
			
			$stmt->bindParam(":nome", $param_nome, PDO::PARAM_STR);
			$param_nome = trim($_POST["nome"]);

			$stmt->bindParam(":cognome", $param_cognome, PDO::PARAM_STR);
			$param_cognome = trim($_POST["cognome"]);

			$stmt->bindParam(":dataDiNascita", $param_dataDiNascita, PDO::PARAM_STR);
			$param_dataDiNascita = trim($_POST["datadinascita"]);

			$stmt->bindParam(":sesso", $param_sesso, PDO::PARAM_STR);
			$param_sesso = trim($_POST["sesso"]);
			
			$stmt->bindParam(":tipo_utente", $param_tipo_utente, PDO::PARAM_STR);
			$param_tipo_utente = "dipendente";

			if($stmt->execute()){
				header("location: elenco_utenti.php");
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
  max-width: 500px;
  margin: auto;
}
</style>
<head class="content">
    <meta charset="UTF-8">
    <title>Inserisci utente</title>
   	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body class="content">
    <div class="wrapper">
        <h2>Nuovo utente</h2>
        <p>Compila i campi.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		
            <div class="form-group <?php echo (!empty($nome_err)) ? 'has-error' : ''; ?>">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control" value="<?php echo $nome; ?>">
                <span class="help-block"><?php echo $nome_err; ?></span>
            </div>    
        
			<div class="form-group <?php echo (!empty($cognome_err)) ? 'has-error' : ''; ?>">
                <label>Cognome</label>
                <input type="text" name="cognome" class="form-control" value="<?php echo $cognome; ?>">
                <span class="help-block"><?php echo $cognome_err; ?></span>
            </div>  
		
			<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div> 
			
			<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div> 
            
			<div class="form-group <?php echo (!empty($conferma_password_err)) ? 'has-error' : ''; ?>">
                <label>Conferma Password</label>
                <input type="password" name="conferma_password" class="form-control" value="<?php echo $conferma_password; ?>">
                <span class="help-block"><?php echo $conferma_password_err; ?></span>
            </div> 

			<div class="form-group <?php echo (!empty($datadinascita_err)) ? 'has-error' : ''; ?>">
                <label>Data di nascita (aaaa-mm-gg)</label>
                <input type="text" name="datadinascita" class="form-control" value="<?php echo $datadinascita; ?>">
                <span class="help-block"><?php echo $datadinascita_err; ?></span>
            </div> 
			
			<div class="form-group <?php echo (!empty($sesso_err)) ? 'has-error' : ''; ?>">
                <label>Sesso</label>
                <input type="text" name="sesso" class="form-control" value="<?php echo $sesso; ?>">
                <span class="help-block"><?php echo $sesso_err; ?></span>
            </div> 
			
			<div class="form-group">
                <input type="submit" class="btn btn-primary" value="Aggiungi">
				<input type="reset" class="btn btn-default" value="Reset">
            </div>
            
		<a href="elenco_utenti.php">Torna all'elenco utenti</a>
        
		</form>
    </div>
</body>
</html>
