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
    $coach = trim($_POST['coach'] ?? '');
    $coachEmail = trim($_POST['coach_mail'] ?? '');
    $coachTel = trim($_POST['coach_tel'] ?? '');
    $players = array_map('trim', $_POST['players'] ?? []);
    $ids = array_map('trim', $_POST['ids'] ?? []);
    $classes = array_map('trim', $_POST['classes'] ?? []);
    $ages = array_map('trim', $_POST['ages'] ?? []);
    $captainIndex = intval($_POST['captain'] ?? 0);
    $captainEmail = trim($_POST['captain_email'] ?? '');
    $captainPhone = trim($_POST['captain_phone'] ?? '');
    
    if (!isSchoolAllowed($school)) {
        $formError = 'Wybrana szkoła nie jest na liście dozwolonych. Proszę wpisać nazwę zgodnie z podpowiedzią.';
    } else {
        $signups = loadSignups();
        $queue = getSchoolQueue($signups, $school);
        $status = count($queue) === 0 ? 'Zgłoszona (główna)' : 'Rezerwowa (' . (count($queue)+1) . ')';
        $signup = [
            'team'=>$teamName, 'school'=>$school, 'coach'=>$coach, 'coach_mail'=>$coachEmail, 'coach_tel'=>$coachTel,
            'players'=>$players, 'ids'=>$ids, 'classes'=>$classes, 'ages'=>$ages,
            'captain_index'=>$captainIndex, 'captain_email'=>$captainEmail, 'captain_phone'=>$captainPhone,
            'status'=>$status, 'timestamp'=>date('Y-m-d H:i:s')
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
            <?=$formError?>
        </div>
    <?php endif; ?>

    <form method="POST" autocomplete="off" class="signup-form">
        <div class="form-group">
            <label for="team">Nazwa drużyny</label>
            <input type="text" name="team" id="team" required placeholder="np. Warsaw Warriors">
        </div>

        <div class="form-group">
            <label for="school">Szkoła</label>
            <input type="text" name="school" id="school" list="schools-list" required placeholder="Wybierz swoją szkołę">
            <datalist id="schools-list">
                <?php foreach ($schools as $sch): ?><option><?= htmlspecialchars($sch) ?></option><?php endforeach; ?>
            </datalist>
        </div>

        <fieldset class="players-section">
            <legend>Zawodnicy podstawowi (5 osób)</legend>
            <?php for ($i=0; $i<5; $i++): ?>
                <div class="player-row">
                    <div class="form-group">
                        <label>Imię i nazwisko</label>
                        <input type="text" name="players[]" required placeholder="Jan Kowalski">
                    </div>
                    <div class="form-group">
                        <label>Nr legitymacji</label>
                        <input type="text" name="ids[]" required placeholder="12345">
                    </div>
                    <!-- Added class field -->
                    <div class="form-group">
                        <label>Klasa</label>
                        <input type="text" name="classes[]" required placeholder="3A">
                    </div>
                    <!-- Added age field -->
                    <div class="form-group">
                        <label>Wiek</label>
                        <input type="number" name="ages[]" required placeholder="16" min="10" max="25">
                    </div>
                </div>
            <?php endfor; ?>
        </fieldset>

        <fieldset class="players-section reserves">
            <legend>Zawodnicy rezerwowi (2 osoby)</legend>
            <?php for ($i=0; $i<2; $i++): ?>
                <div class="player-row">
                    <div class="form-group">
                        <label>Imię i nazwisko</label>
                        <input type="text" name="players[]" required placeholder="Jan Kowalski">
                    </div>
                    <div class="form-group">
                        <label>Nr legitymacji</label>
                        <input type="text" name="ids[]" required placeholder="12345">
                    </div>
                    <!-- Added class field for reserves -->
                    <div class="form-group">
                        <label>Klasa</label>
                        <input type="text" name="classes[]" required placeholder="3A">
                    </div>
                    <!-- Added age field for reserves -->
                    <div class="form-group">
                        <label>Wiek</label>
                        <input type="number" name="ages[]" required placeholder="16" min="10" max="25">
                    </div>
                </div>
            <?php endfor; ?>
        </fieldset>

        <!-- Added captain section -->
        <div class="captain-section">
            <h3>Kapitan drużyny</h3>
            
            <div class="form-group">
                <label for="captain">Który zawodnik jest kapitana?</label>
                <select name="captain" id="captain" required>
                    <option value="">Wybierz kapitana</option>
                    <option value="0">Zawodnik 1</option>
                    <option value="1">Zawodnik 2</option>
                    <option value="2">Zawodnik 3</option>
                    <option value="3">Zawodnik 4</option>
                    <option value="4">Zawodnik 5</option>
                </select>
            </div>

            <div class="form-group">
                <label for="captain_email">Email kapitana</label>
                <input type="email" name="captain_email" id="captain_email" required placeholder="kapitan@example.com">
            </div>

            <div class="form-group">
                <label for="captain_phone">Telefon kapitana</label>
                <input type="tel" name="captain_phone" id="captain_phone" required placeholder="+48 123 456 789">
            </div>
        </div>

        <div class="coach-section">
            <h3>Dane opiekuna drużyny</h3>
            
            <div class="form-group">
                <label for="coach">Imię i nazwisko opiekuna</label>
                <input type="text" name="coach" id="coach" required placeholder="Anna Nowak">
            </div>

            <div class="form-group">
                <label for="coach_mail">Email opiekuna</label>
                <input type="email" name="coach_mail" id="coach_mail" required placeholder="anna.nowak@szkola.edu.pl">
            </div>

            <div class="form-group">
                <label for="coach_tel">Telefon opiekuna</label>
                <input type="text" name="coach_tel" id="coach_tel" required placeholder="+48 123 456 789">
            </div>
        </div>

        <div class="info-box">
            <strong>Ważne informacje:</strong>
            <ul>
                <li>Zespół składa się z 5 graczy podstawowych i 2 rezerwowych</li>
                <li>Wszyscy zawodnicy muszą być uczniami wybranej szkoły</li>
                <li>Kapitan drużyny musi być jednym z 5 zawodników podstawowych</li>
                <li>Dozwolona jedna drużyna z każdej szkoły</li>
                <li>Kolejne zgłoszenia trafią na listę rezerwową</li>
            </ul>
        </div>

        <button type="submit" class="submit-button">Wyślij zgłoszenie</button>
    </form>
</div>

<?php
require_once "footer.php";
