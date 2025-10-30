<?php
$title = "Formularz Zgłoszeniowy";
require_once "header.php";
require_once "utilities.php";

function loadSchools() {
    return loadSchoolsFromDraft();
}

function isSchoolAllowed($school) {
    $schools = loadSchools();
    return in_array($school, $schools, true);
}

function loadSignups() {
    $file = __DIR__ . '/signups.json';
    return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
}

function saveSignups($data) {
    file_put_contents(__DIR__ . '/signups.json', json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
}

function getSchoolQueue($signups, $school) {
    $queue = [];
    foreach ($signups as $signup) {
        if ($signup['school'] === $school) {
            $queue[] = $signup;
        }
    }
    return $queue;
}

$formMsg = null;
$formError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teamName = trim($_POST['team'] ?? '');
    $school = trim($_POST['school'] ?? '');
    $captainName = trim($_POST['captain_name'] ?? '');
    $captainPhone = trim($_POST['captain_phone'] ?? '');
    $captainDiscord = trim($_POST['captain_discord'] ?? '');
    
    // Collect all player data
    $players = [];
    for ($i = 1; $i <= 7; $i++) {
        $players[] = [
            'name' => trim($_POST["player{$i}_name"] ?? ''),
            'phone' => trim($_POST["player{$i}_phone"] ?? ''),
            'email' => trim($_POST["player{$i}_email"] ?? ''),
            'student_id' => trim($_POST["player{$i}_student_id"] ?? ''),
            'steam_id' => trim($_POST["player{$i}_steam_id"] ?? ''),
            'discord' => trim($_POST["player{$i}_discord"] ?? '')
        ];
    }
    
    // Collect coach data
    $coach = [
        'name' => trim($_POST['coach_name'] ?? ''),
        'position' => trim($_POST['coach_position'] ?? ''),
        'phone' => trim($_POST['coach_phone'] ?? ''),
        'email' => trim($_POST['coach_email'] ?? '')
    ];
    
    if (!isSchoolAllowed($school)) {
        $formError = 'Wybrana szkoła nie jest na liście dozwolonych. Proszę wpisać nazwę zgodnie z podpowiedzią.';
    } else {
        $signups = loadSignups();
        $queue = getSchoolQueue($signups, $school);
        $status = count($queue) === 0 ? 'Zgłoszona (główna)' : 'Rezerwowa (' . (count($queue)+1) . ')';
        
        $signup = [
            'team' => $teamName,
            'school' => $school,
            'captain_name' => $captainName,
            'captain_phone' => $captainPhone,
            'captain_discord' => $captainDiscord,
            'players' => $players,
            'coach' => $coach,
            'status' => $status,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        $signups[] = $signup;
        saveSignups($signups);
        
        if (count($queue) === 0) {
            $formMsg = 'Zgłoszenie przyjęte! Jesteście główną drużyną z tej szkoły.';
        } else {
            $formMsg = 'Jesteście na liście rezerwowej. Tylko jedna drużyna z każdej szkoły.';
        }
    }
}

$schools = loadSchools();
?>

<div class="form-container">
    <div class="form-header">
        <h1>Zgłoś drużynę do turnieju</h1>
        <p class="form-description">Wypełnij formularz, aby zgłosić swoją drużynę do Polna Cup CS2</p>
    </div>

    <?php if ($formMsg) : ?>
        <div class="success">
            <?= htmlspecialchars($formMsg) ?>
        </div>
    <?php endif; ?>
    <?php if ($formError): ?>
        <div class="error">
            <?= htmlspecialchars($formError) ?>
        </div>
    <?php endif; ?>

    <form method="POST" autocomplete="off" class="signup-form">
        
        <div class="form-group">
            <label for="school">Nazwa szkoły *</label>
            <input type="text" name="school" id="school" list="schools-list" required placeholder="Wybierz swoją szkołę z listy">
            <datalist id="schools-list">
                <?php foreach ($schools as $sch): ?>
                    <option value="<?= htmlspecialchars($sch) ?>"><?= htmlspecialchars($sch) ?></option>
                <?php endforeach; ?>
            </datalist>
            <!-- <p class="field-hint">Wybierz szkołę, do której przynieśliśmy plakaty</p> -->
        </div>

        <div class="form-group">
            <label for="team">Nazwa drużyny *</label>
            <input type="text" name="team" id="team" required placeholder="np. Warsaw Warriors">
        </div>

        <!-- Captain section with name, phone, and Discord -->
        <fieldset class="captain-section-new">
            <legend>Dane kapitana drużyny</legend>
            
            <div class="form-group">
                <label for="captain_name">Imię i nazwisko kapitana *</label>
                <input type="text" name="captain_name" id="captain_name" required placeholder="Jan Kowalski">
            </div>

            <div class="form-group">
                <label for="captain_phone">Numer telefonu kapitana *</label>
                <input type="tel" name="captain_phone" id="captain_phone" required placeholder="+48 123 456 789">
            </div>

            <div class="form-group">
                <label for="captain_discord">Discord kapitana *</label>
                <input type="text" name="captain_discord" id="captain_discord" required placeholder="kowalskijan">
                <p class="field-hint">Nazwa użytkownika Discord (organizatorzy będą mogli się z Tobą skontaktować)</p>
            </div>
        </fieldset>

        <!-- Individual player sections with all required fields -->
        <fieldset class="players-section-individual">
            <legend>Zawodnicy podstawowi (5 osób)</legend>
            
            <?php for ($i = 1; $i <= 5; $i++): ?>
            <div class="player-card">
                <h4>Zawodnik <?= $i ?></h4>
                
                <div class="player-row-individual">
                    <div class="form-group">
                        <label for="player<?= $i ?>_name">Imię i nazwisko *</label>
                        <input type="text" name="player<?= $i ?>_name" id="player<?= $i ?>_name" required placeholder="Jan Kowalski">
                    </div>

                    <div class="form-group">
                        <label for="player<?= $i ?>_phone">Numer telefonu *</label>
                        <input type="tel" name="player<?= $i ?>_phone" id="player<?= $i ?>_phone" required placeholder="+48 123 456 789">
                    </div>

                    <div class="form-group">
                        <label for="player<?= $i ?>_email">Adres email *</label>
                        <input type="email" name="player<?= $i ?>_email" id="player<?= $i ?>_email" required placeholder="jan.kowalski@example.com">
                    </div>
                </div>

                <div class="player-row-individual">
                    <div class="form-group">
                        <label for="player<?= $i ?>_student_id">Numer legitymacji *</label>
                        <input type="text" name="player<?= $i ?>_student_id" id="player<?= $i ?>_student_id" required placeholder="12345">
                    </div>

                    <div class="form-group">
                        <label for="player<?= $i ?>_steam_id">Steam ID *</label>
                        <input type="text" name="player<?= $i ?>_steam_id" id="player<?= $i ?>_steam_id" required placeholder="76561198052641370">
                    </div>

                    <div class="form-group">
                        <label for="player<?= $i ?>_discord">Discord *</label>
                        <input type="text" name="player<?= $i ?>_discord" id="player<?= $i ?>_discord" required placeholder="kowalskijan">
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </fieldset>

        <fieldset class="players-section-individual">
            <legend>Zawodnicy rezerwowi (2 osoby)</legend>
            
            <?php for ($i = 6; $i <= 7; $i++): ?>
            <div class="player-card">
                <h4>Zawodnik rezerwowy <?= $i - 5 ?></h4>
                
                <div class="player-row-individual">
                    <div class="form-group">
                        <label for="player<?= $i ?>_name">Imię i nazwisko *</label>
                        <input type="text" name="player<?= $i ?>_name" id="player<?= $i ?>_name" required placeholder="Jan Kowalski">
                    </div>

                    <div class="form-group">
                        <label for="player<?= $i ?>_phone">Numer telefonu *</label>
                        <input type="tel" name="player<?= $i ?>_phone" id="player<?= $i ?>_phone" required placeholder="+48 123 456 789">
                    </div>

                    <div class="form-group">
                        <label for="player<?= $i ?>_email">Adres email *</label>
                        <input type="email" name="player<?= $i ?>_email" id="player<?= $i ?>_email" required placeholder="jan.kowalski@example.com">
                    </div>
                </div>

                <div class="player-row-individual">
                    <div class="form-group">
                        <label for="player<?= $i ?>_student_id">Numer legitymacji *</label>
                        <input type="text" name="player<?= $i ?>_student_id" id="player<?= $i ?>_student_id" required placeholder="12345">
                    </div>

                    <div class="form-group">
                        <label for="player<?= $i ?>_steam_id">Steam ID *</label>
                        <input type="text" name="player<?= $i ?>_steam_id" id="player<?= $i ?>_steam_id" required placeholder="76561198052641370">
                    </div>

                    <div class="form-group">
                        <label for="player<?= $i ?>_discord">Discord *</label>
                        <input type="text" name="player<?= $i ?>_discord" id="player<?= $i ?>_discord" required placeholder="kowalskijan">
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </fieldset>

        <!-- Added guardian/supervisor section with all required fields -->
        <fieldset class="coach-section">
            <legend>Dane opiekuna drużyny</legend>
            
            <div class="form-group">
                <label for="coach_name">Imię i nazwisko opiekuna *</label>
                <input type="text" name="coach_name" id="coach_name" required placeholder="Jan Kowalski">
            </div>

            <div class="form-group">
                <label for="coach_position">Stanowisko *</label>
                <input type="text" name="coach_position" id="coach_position" required placeholder="np. Nauczyciel WF">
            </div>

            <div class="form-group">
                <label for="coach_phone">Numer telefonu opiekuna *</label>
                <input type="tel" name="coach_phone" id="coach_phone" required placeholder="+48 123 456 789">
            </div>

            <div class="form-group">
                <label for="coach_email">Adres email opiekuna *</label>
                <input type="email" name="coach_email" id="coach_email" required placeholder="jan.kowalski@szkola.edu.pl">
            </div>
        </fieldset>

        <div class="info-box">
            <strong>Ważne informacje:</strong>
            <ul>
                <li>Zespół składa się z 7 graczy: 5 podstawowych i 2 rezerwowych</li>
                <li>Wszyscy zawodnicy muszą być uczniami wybranej szkoły</li>
                <li>Podaj dane kontaktowe każdego zawodnika (telefon i email) na wypadek problemów z dostępnością</li>
                <li>Steam ID znajdziesz na stronie: <a href="https://tradeit.gg/steam-id-finder" target="_blank" rel="noopener">Steam ID Finder</a></li>
                <li>Dozwolona jedna drużyna z każdej szkoły</li>
                <li>Kolejne zgłoszenia trafią na listę rezerwową</li>
            </ul>
        </div>

        <button type="submit" class="submit-button">Wyślij zgłoszenie</button>
    </form>
</div>

<?php
require_once "footer.php";
?>
