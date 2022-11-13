<?php

if (empty($_POST["firstName"])) {
    die("Name is required");
}

if (empty($_POST["lastName"])) {
    die("LastName is required");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if (strlen($_POST["tax"]) < 12) {
    die("Inn must be at least 12 characters");
}

if (strlen($_POST["phone"]) < 11) {
    die("Phone number must be at least 11 characters");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user_accounts (name, lastname, tag, password, mail, inn, phone, hash_password)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("ssssssss",
                  $_POST["firstName"],
                  $_POST["lastName"],
                  $_POST["nick"],
                  $_POST["password"],
                  $_POST["email"],
                  $_POST["tax"],
                  $_POST["phone"],
                  $password_hash
                );

                if ($stmt->execute()) {

                    header("Location: signup-success.html");
                    exit;
                    
                } else {
                    
                    if ($mysqli->errno === 1062) {
                        die("email already taken");
                    } else {
                        die($mysqli->error . " " . $mysqli->errno);
                    }
                }
