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