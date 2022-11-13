<?php 

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user_accounts
                    WHERE mail = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["hash_password"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./styles.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">
    <title> Global </title>
</head>
<body>
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
    <header>
        <nav class="Platform">
            <p class="Global Xanh"> Global Finance inc. </p>
            <div class="manage">
                <p class="timestamp Xanh"> {{timestamp}} MSC </p>
                <img class="userAccountSite" src="./images/account.svg" />
            </div>
        </nav>
        <div class="center">
                <h1 class="h3 mb-5 fw-normal">Вход на сервер</h1>
                <form method="POST">
                <div class="form-floating">
                  <input type="text" class="form-control" id="floatingInput" placeholder="Ваш почтовый адрес" required name="email">
                </div>
                <div class="form-floating">
                  <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" required name="password">
                </div>
                <div class="checkbox mb-5"></div>
                <div class="displayFlex">
                    <button class="w-40 btn btn-lg btn-success" type="submit" >Вход</button>
                    </form>
                    <form action="signup.html">
                        <button class="w-40 btn btn-lg btn-danger" type="submit">Регистрация</button>
                    </form>
                </div>
        </div>
    </header>
</body>
</html>