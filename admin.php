<?php
require_once "header.php";
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
    $password = sha1(trim($_POST["password"]));
    if ($username != $_ENV["AdminUser"] || $password != $_ENV["AdminPasswordHash"]) {
        echo "hackermaster z ciebie ale nie tym razem";
        require_once "footer.php";
        die();
    }
    $_SESSION["adminLogin"] = $username;
}
?>
<main class="main-content">
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
