<?php
function ReadEnv(): void {
     $file = file(".env", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
     foreach ($file as $line) {
          if (strpos(trim($line), "#") === 0) continue;

          [$name, $value] = array_map('trim', explode('=', $line, 2));
          $value = trim($value, "\"'");
          $_ENV[$name] = $value;
          putenv("$name=$value");
     }
}

function loadSchoolsFromDraft($draft = 'draft.txt') {
    $lines = file(__DIR__ . '/' . $draft);
    $schools = [];
    $forbidden = [
        'branżowa', 'specjalne', 'specjalna', 'dla głuchych', 'specjalny', 'słabowidzących', 'głuchych', 'psych',
        'rehabilitacyj', 'szkoła branżowa', 'szkoła specjalna', 'dzieci głuchych', 'w chmurze', 'szkoła podstawowa', 'przysposabia', 'sobie', 'II stopnia', 'ośrodek', 'dzieci niesłyszących', 'społeczna szkola', 'integracyjne', 'specjalne' // dublowanie dla bezpieczeństwa
    ];
    foreach ($lines as $l) {
        $l = trim($l);
        if (
            (str_contains($l, 'Liceum') || str_contains($l, 'Technikum')) &&
            !preg_match('/(' . implode('|', $forbidden) . ')/iu', $l)
        ) {
            // check for keywords like "dla głuchych" etc.
            $schools[] = $l;
        }
    }
    return array_values(array_unique($schools));
}

function loadSchools() {
    return loadSchoolsFromDraft();
}

function isSchoolAllowed($school) {
    $schools = loadSchools();
    return in_array($school, $schools, true);
}

function loadSignups() {
    $file = $_ENV["DataPath"];
    if (!file_exists($file)) return [];

    $key = base64_decode($_ENV["EncKey"]);
    $json = json_decode(file_get_contents($file), true);

    $iv = base64_decode($json['iv']);
    $tag = base64_decode($json['tag']);
    $ciphertext = base64_decode($json['data']);

    $decrypted = openssl_decrypt(
        $ciphertext,
        "aes-256-gcm",
        $key,
        OPENSSL_RAW_DATA,
        $iv,
        $tag
    );

    return $decrypted ? json_decode($decrypted, true) : [];
}

function saveSignups($data) {
    $key = base64_decode($_ENV["EncKey"]);
    $iv = random_bytes(12);

    $plaintext = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $tag = "";
    $ciphertext = openssl_encrypt(
        $plaintext,
        "aes-256-gcm",
        $key,
        OPENSSL_RAW_DATA,
        $iv,
        $tag
    );

    $json = json_encode([
        "iv" => base64_encode($iv),
        "tag" => base64_encode($tag),
        "data" => base64_encode($ciphertext)
    ], JSON_PRETTY_PRINT);

    file_put_contents($_ENV["DataPath"], $json);
}