<?php
session_start();
require_once('database.php');

$msg = '';

if (isset($_POST['register'])) {
   
    $username = $_POST['user'];
    $password = $_POST['psw'];
    $password2 = $_POST['password2'];

    // Validazione dell'username
    $isUsernameValid = filter_var(
        $username,
        FILTER_VALIDATE_REGEXP, [
            "options" => [
                "regexp" => "/^[a-z\d_]{3,20}$/i"
            ]
        ]
    );

    // Lunghezza della password
    $pwdLength = mb_strlen($password);

    // Verifica se tutti i campi sono stati compilati
    if (empty($username) || empty($password) || empty($password2)) {
        $msg = 'Compila tutti i campi';
    } elseif (false === $isUsernameValid) {
        $msg = 'Lo username non è valido. Sono ammessi solamente caratteri alfanumerici e l\'underscore. Lunghezza minima 3 caratteri. Lunghezza massima 20 caratteri';
    } elseif ($pwdLength < 8 || $pwdLength > 20) {
        $msg = 'La password deve avere una lunghezza minima di 8 caratteri e massima di 20 caratteri';
    } elseif ($password !== $password2) {
        $msg = 'Le password non corrispondono';
    } else {
        // Hash della password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Verifica se lo username è già in uso
        $query = "SELECT id FROM users WHERE username = :username";
        $check = $pdo->prepare($query);
        $check->bindParam(':username', $username, PDO::PARAM_STR);
        $check->execute();
        $user = $check->fetchAll(PDO::FETCH_ASSOC);

        if (count($user) > 0) {
            $msg = 'Username già in uso';

    
    header("Location: home.php");
    exit(); 
        } else {
            $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $insert = $pdo->prepare($query);
            $insert->bindParam(':username', $username, PDO::PARAM_STR);
            $insert->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $insert->execute();

            if ($insert->rowCount() > 0) {
                $msg = 'Registrazione eseguita con successo';
                location: header('home.php');
            } else {
                $msg = 'Problemi con l\'inserimento dei dati';
            }
        }
    }
}

?>

    <title>Glassmorphism login Form Tutorial in html css</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Registration Form</title>
  <style>
    *,
    *:before,
    *:after{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
    body{
        background-color: #080710;
        font-family: 'Poppins', sans-serif;
        color: #ffffff;
    }
    .background{
        width: 430px;
        height: 520px;
        position: absolute;
        transform: translate(-50%,-50%);
        left: 50%;
        top: 50%;
    }
    .background .shape{
        height: 200px;
        width: 200px;
        position: absolute;
        border-radius: 50%;
    }
    .shape:first-child{
        background: linear-gradient(
            #1845ad,
            #23a2f6
        );
        left: -80px;
        top: -80px;
    }
    .shape:last-child{
        background: linear-gradient(
            to right,
            #ff512f,
            #f09819
        );
        right: -30px;
        bottom: -80px;
    }
    form{
        min-height: 620px;
        width: 400px;
        background-color: rgba(255,255,255,0.13);
        position: absolute;
        transform: translate(-50%,-50%);
        top: 50%;
        left: 50%;
        border-radius: 10px;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255,255,255,0.1);
        box-shadow: 0 0 40px rgba(8,7,16,0.6);
        padding: 50px 35px;
    }
    form *{
        font-family: 'Poppins',sans-serif;
        color: #ffffff;
        letter-spacing: 0.5px;
        outline: none;
        border: none;
    }
    form h3{
        font-size: 32px;
        font-weight: 500;
        line-height: 42px;
        text-align: center;
    }
    label{
        display: block;
        margin-top: 30px;
        font-size: 16px;
        font-weight: 500;
    }
    input{
        display: block;
        height: 50px;
        width: 100%;
        background-color: rgba(255,255,255,0.07);
        border-radius: 3px;
        padding: 0 10px;
        margin-top: 8px;
        font-size: 14px;
        font-weight: 300;
    }
    ::placeholder{
        color: #e5e5e5;
    }
    button[type="submit"]{
        margin-top: 50px;
        width: 100%;
        background-color: #ffffff;
        color: #080710;
        padding: 15px 0;
        font-size: 18px;
        font-weight: 600;
        border-radius: 5px;
        cursor: pointer;
    }

    .nothave{
margin-top: 16px;
}
.error{
color: #ffccda;
margin-top: 4px;
}

  </style>
</head>
<body>
  <div class="background">
      <div class="shape"></div>
      <div class="shape"></div>
  </div>
  <form method="post" action="">
    <h3>Register</h3>
    
    <label for="username">Username</label>
    <input name="user" type="text" placeholder="Username" id="username">

    <label for="password">Password</label>
    <input name="psw" type="password" placeholder="Password" id="password">

    <label for="password2">Repeat password</label>
    <input name="password2" type="password" placeholder="Repeat password" id="password2">

    <button type="submit" name="register">Register</button>
    <p class="nothave">Hai già un account? <a href="login.php">Accedi</a></p>

    <?php if(isset($msg)): ?>
      <p class="error"><?php echo $msg; ?></p>
      <span id="username-feedback"></span>

    <?php endif; ?>
  </form>
</body>
</html>
