<?php
$title = "Zgłoszenia";
require_once "header.php";
?>

<h1>Zgłoszone drużyny CS2</h1>
<?php
$signupsFile = __DIR__ . '/signups.json';
$signups = file_exists($signupsFile) ? json_decode(file_get_contents($signupsFile), true) : [];
if (empty($signups)) {
    echo '<div class="info">Brak zgłoszonych drużyn.</div>';
} else {
    echo '<div class="table-card"><table>';
    echo '<tr><th>Szkoła</th><th>Drużyna</th><th>Status</th><th>Zawodnicy podstawowi</th><th>Rezerwowi</th><th>Opiekun</th><th>Email</th><th>Tel</th><th>Czas</th></tr>';
    foreach ($signups as $s) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($s['school']) . '</td>';
        echo '<td>' . htmlspecialchars($s['team']) . '</td>';
        echo '<td>' . htmlspecialchars($s['status']) . '</td>';
        // 5 podstawowych
        echo '<td>';
        for ($ix=0; $ix<5 && isset($s['players'][$ix]); $ix++) {
            echo htmlspecialchars($s['players'][$ix]) . ' (nr ' . htmlspecialchars($s['ids'][$ix]) . ')<br>';
        }
        echo '</td>';
        // 2 rezerwowych
        echo '<td class="rezerwowy">';
        for ($ix=5; $ix<7 && isset($s['players'][$ix]); $ix++) {
            echo htmlspecialchars($s['players'][$ix]) . ' (nr ' . htmlspecialchars($s['ids'][$ix]) . ')<br>';
        }
        echo '</td>';
        echo '<td>' . htmlspecialchars($s['coach']) . '</td>';
        echo '<td>' . htmlspecialchars($s['coach_mail']) . '</td>';
        echo '<td>' . htmlspecialchars($s['coach_tel']) . '</td>';
        echo '<td>' . htmlspecialchars($s['timestamp']) . '</td>';
        echo '</tr>';
    }
    echo '</table></div>';
}
require_once "footer.php";
?>
