<?php
$isCsv = false;

if(isset($_GET["form"]) && ($_GET["form"] === "csv" || $_GET["form"] === "csvp"))
    $isCsv = true;

if (isset($_POST["admin-action-drop-database"])) {
    header("Location: ");
    die();
}

if (!$isCsv) require_once "header.php";
else require_once "init.php";
if (isset($_SESSION["adminLogin"]) && $_SESSION["adminLogin"] != $_ENV["AdminUser"]) {
    unset($_SESSION["adminLogin"]);
}

if (!isset($_SESSION["adminLogin"])) {
    if (empty($_POST["username"]) || empty($_POST["password"])) {
?>
<form method="post">
    <input type="text" name="username" id="in-username">
    <input type="password" name="password" id="in-password">
    <input type="submit" value="Cos" />
</form>
<?php
        require_once "footer.php";
        die();
    }
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    if (strtolower($username) === "admin" && strtolower($password) == "admin") {
?>
<h1>ADMIN PANEL</h1>
<form method="post">
    <input class="delete-database" type="submit" value="USUŃ BAZĘ DANYCH" name="admin-action-drop-database">
</form>
<?php
        require_once "footer.php";
        die();
    }
    if ($username != $_ENV["AdminUser"] || sha1($password) != $_ENV["AdminPasswordHash"]) {
        echo "hackermaster z ciebie ale nie tym razem";
        require_once "footer.php";
        die();
    }
    $_SESSION["adminLogin"] = $username;
}
if ($isCsv) {
    [$teamCSV, $playersCSV] = signupsToCSVWithPlayers();

    if ($_GET["form"] === "csvp") {
        header("Content-Type: text/csv; charset=utf-8");
        header('Content-Disposition: attachment; filename="players.csv"');
        echo $playersCSV;
    } else {
        header("Content-Type: text/csv; charset=utf-8");
        header('Content-Disposition: attachment; filename="teams.csv"');
        echo $teamCSV;
    }
    die();
}

?>
<main class="main-content">
  <a href="?form=csv">Pobierz zespoły (CSV)</a>
  <a href="?form=csvp">Pobierz graczy (CSV)</a>
  <table>
    <tr>
        <th></th>
        <th>Zespół</th>
        <th>Szkoła</th>
        <th>Kapitan</th>
        <th>Opiekun</th>
        <th>Gracze</th>
        <th>Status</th>
    </tr>
    <?php
    $data = loadSignups();
    $next = 0;
    foreach ($data as $signup): ?>
        <tr>
            <th>#<?= $next++ ?></th>
            <td><?= $signup["team"] ?></td>
            <td><?= $signup["school"] ?></td>
            <td><?= $signup["captain_name"] ?></td>
            <td><?= $signup["coach"]["name"] ?></td>
            <td>
                <ul>
                    <? foreach ($signup["players"] as $player): ?>
                        <li><?= $player["name"] ?></li>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td><?= $signup["status"] ?></td>
        </tr>
    <?php endforeach; ?>
  </table>
</main>
<?php
require_once "footer.php";
?>
