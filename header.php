<?php
require_once "init.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? "$title - Polna Cup" : "Polna Cup" ?></title>
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600,700,800|Poppins:400,500,700|Roboto:400,500,700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<!-- Added navigation bar with links -->
<nav class="navbar">
    <div class="navbar-container">
        <a href="index.php" class="navbar-brand">Polna Cup CS2</a>
        <ul class="navbar-menu">
            <li><a href="index.php" class="navbar-link">Strona główna</a></li>
            <li><a href="form.php" class="navbar-link">Zgłoś się</a></li>
            <li><a href="contact.php" class="navbar-link">Kontakt</a></li>
        </ul>
    </div>
</nav>
