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