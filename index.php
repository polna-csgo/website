<?php
require_once "header.php";
?>
<main class="main-content">
  <!-- Hero section with large image -->
  <section class="hero-section-full">
    <div class="hero-image-large">
      <img src="images/main.png" alt="Polna Cup CS2 Tournament" />
    </div>
    <div class="hero-overlay">
      <h1>Polna Cup CS2</h1>
      <p class="hero-subtitle">Turniej Szkół Warszawskich</p>
      <a href="form.php" class="btn btn-hero">
        <span>Przejdź do formularza</span>
      </a>
    </div>
  </section>

  <!-- Full-width content sections with landscape images -->
  <section class="content-section">
    <article class="content-block">
      <h2>Na czym polega Polna Cup?</h2>
      <div class="text-content">
        <p>Polna Cup to najbardziej prestiżowy turniej Counter-Strike 2 dla warszawskich szkół średnich. To wyjątkowa okazja, aby zmierzyć się z najlepszymi drużynami z całej Warszawy i pokazać swoje umiejętności na profesjonalnej scenie e-sportowej.</p>
        
        <ul class="feature-list">
          <li>Drużyny z warszawskich liceów i techników rywalizują o tytuł najlepszej szkolnej ekipy CS2</li>
          <li>Każda szkoła może zgłosić tylko jeden zespół główny</li>
          <li>Skład: 5 graczy podstawowych + 2 rezerwowych</li>
          <li>Faza grupowa, PLAYOFFS oraz stream finału na żywo</li>
          <li>Nagrody rzeczowe oraz prestiżowe trofea dla zwycięzców</li>
        </ul>
      </div>
      
      <div class="image-landscape">
        <img src="images/tournament.jpg" alt="CS2 Tournament Action" />
      </div>
    </article>

    <article class="content-block">
      <h2>Jak się zgłosić?</h2>
      <div class="text-content">
        <p>Proces zgłoszenia jest prosty i szybki. Wystarczy kilka kroków, aby Twoja drużyna mogła wziąć udział w turnieju:</p>
        
        <ol class="steps-list">
          <li>Zbierz drużynę — 5 podstawowych + 2 rezerwowych graczy ze swojej szkoły</li>
          <li>Ustal opiekuna drużyny (nauczyciel lub wychowawca z Twojej szkoły)</li>
          <li>Przygotuj dane wszystkich zawodników (imiona, nazwiska, numery legitymacji, adresy email, numery telefonów, ID kont na Steam, Discord)</li>
          <li>Wypełnij formularz zgłoszeniowy online i czekaj na potwierdzenie mailowe</li>
        </ol>
        
        <p>Po weryfikacji zgłoszeń otrzymasz kompletną listę uczestników oraz szczegółowy harmonogram rozgrywek. Pamiętaj, że tylko jedna drużyna z każdej szkoły może wziąć udział jako zespół główny!</p>
      </div>
      
      <div class="image-landscape">
        <img src="images/team.jpg" alt="School Esports Team" />
      </div>
    </article>

    <article class="content-block">
      <h2>Najczęściej zadawane pytania</h2>
      <div class="text-content">
        <dl class="faq-list">
          <dt>Czy zgłoszenie jest ważne od razu?</dt>
          <dd>Tak, jeśli Twoja szkoła nie ma jeszcze zgłoszonej drużyny głównej. W przeciwnym wypadku trafiasz na listę rezerwową i będziesz mógł zagrać, jeśli główna drużyna zrezygnuje.</dd>
          
          <dt>Kto może grać w turnieju?</dt>
          <dd>Tylko uczniowie danej szkoły z aktywną legitymacją szkolną. Wszyscy zawodnicy muszą być uczniami tej samej szkoły warszawskiej.</dd>
          
          <dt>Jaka jest opłata za udział?</dt>
          <dd>Turniej jest CAŁKOWICIE darmowy i tworzony przez społeczność graczy. Nie pobieramy żadnych opłat za zgłoszenie ani udział.</dd>
          
          <dt>Jak dowiem się, że moja drużyna gra?</dt>
          <dd>Po weryfikacji wszystkich zgłoszeń prześlemy mailowo kompletną listę uczestników oraz szczegółowy harmonogram rozgrywek na adres opiekuna drużyny.</dd>
          
          <dt>Co jeśli ktoś z drużyny się rozchoruje?</dt>
          <dd>Możecie skorzystać z graczy rezerwowych podanych w zgłoszeniu. Dlatego ważne jest, aby zgłosić pełny skład z rezerwowymi.</dd>
          
          <dt>Gdzie odbędą się rozgrywki?</dt>
          <dd>Szczegóły dotyczące lokalizacji oraz harmonogramu zostaną przesłane mailowo po zakończeniu rejestracji i weryfikacji zgłoszeń.</dd>
        </dl>
      </div>
      
      <div class="image-landscape">
        <img src="images/prize.jpg" alt="Tournament Prizes and Trophies" />
      </div>
    </article>

    <div class="cta-section">
      <h2>Gotowy na wyzwanie?</h2>
      <p>Nie czekaj! Zgłoś swoją drużynę już teraz i weź udział w największym szkolnym turnieju CS2 w Warszawie.</p>
      <a href="form.php" class="btn btn-large">
        <span>Wypełnij formularz zgłoszeniowy</span>
      </a>
      <p class="cta-secondary">
        <a href="signups.php" class="link-secondary">Zobacz już zgłoszone drużyny →</a>
      </p>
    </div>
  </section>
</main>
<?php
require_once "footer.php";
?>
