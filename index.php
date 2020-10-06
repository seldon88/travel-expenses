<?php
include 'CSS/index.css';
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	if($_SESSION["tipo_utente"] == "admin"){
		header("location: elenco_utenti.php");
		exit;
	}else{
		header("location: elenco_viaggi.php");
		exit;
	}
}

require_once "connessione.php";

$username = "";
$password = "";
$username_err = "";
$password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["username"]))){
        $username_err = "Inserisci il nome utente.";
    } else{
        $username = trim($_POST["username"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Inserisci la password.";
    } else{
        $password = trim($_POST["password"]);
    }

    if(empty($username_err) && empty($password_err)){

		$sql = "SELECT dipendente_id, username, nome, cognome, password, tipo_utente FROM utenti WHERE username = :username";

        if($stmt = $pdo->prepare($sql)){

			$stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);

            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["dipendente_id"];
                        $username = $row["username"];
						$nome = $row["nome"];
						$cognome = $row["cognome"];
						$tipo_utente = $row["tipo_utente"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
						//if ($password = $row["password"]){
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["dipendente_id"] = $id;
                            $_SESSION["username"] = $username;
							$_SESSION["tipo_utente"] = $tipo_utente;

                            if($tipo_utente == "admin"){
								header("location: elenco_utenti.php");
							}else{
								header("location: elenco_viaggi.php");
								$_SESSION["nome"] = $nome;
								$_SESSION["cognome"] = $cognome;
							}
                        } else{
                            $password_err = "La password non è valida.";
						}
                    }
                } else{
                    $username_err = "Non esiste account con questo nome.";
                }
            } else{
                echo "Qualcosa è andato storto. Riprova più tardi.";
            }
        }
        unset($stmt);
    }
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">

<head class="content">
    <meta charset="UTF-8">
    <title>Login</title>
   	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>

<header>
	<img src="image.png" alt="Logo">
</header>

<body class="content">
    <div class="wrapper">
        <h2>Login</h2>
        <p>Compila i campi per il login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>

			<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

			<div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>

		</form>
    </div>
</body>
</html>
