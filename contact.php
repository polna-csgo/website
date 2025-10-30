<?php
$title = "Kontakt";
require_once "header.php";
?>

<main class="contact-page">
  <div class="contact-hero">
    <h1>Skontaktuj się z nami</h1>
    <p class="hero-subtitle">Masz pytania? Chętnie odpowiemy!</p>
  </div>

  <div class="contact-content">
    <div class="contact-grid">
      <!-- Contact Information -->
      <div class="contact-info-section">
        <h2>Informacje kontaktowe</h2>
        
        <div class="contact-card">
          <div class="contact-icon">✉</div>
          <h3>Email</h3>
          <p><a href="mailto:kontakt@polnacup.pl">polnacup@technikumpolna.pl</a></p>
          <p class="contact-description">Odpowiadamy na wszelkie pytania</p>
        </div>

        <div class="contact-card">
          <div class="contact-icon">📱</div>
          <h3>Social Media</h3>
          <div class="social-links-contact">
            <a href="https://www.twitch.tv/tkkpolnacup" target="_blank" rel="noopener">Twitch</a>
            <a href="https://www.instagram.com/polna.cup" target="_blank" rel="noopener">Instagram</a>
            <a href="https://www.tiktok.com/@polna.cup" target="_blank" rel="noopener">TikTok</a>
          </div>
        </div>

        <div class="contact-card">
          <div class="contact-icon">📍</div>
          <h3>Lokalizacja</h3>
          <p>Ul. Polna 7, 00-625 Warszawa, Polska</p>
          <p class="contact-description">Turniej dla warszawskich szkół średnich</p>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="contact-form-section">
        <h2>Wyślij wiadomość</h2>
        <form class="contact-form" method="post" action="">
          <div class="form-group">
            <label for="name">Imię i nazwisko</label>
            <input type="text" id="name" name="name" placeholder="Jan Kowalski" required>
          </div>

          <div class="form-group">
            <label for="email">Adres email</label>
            <input type="email" id="email" name="email" placeholder="jan.kowalski@example.com" required>
          </div>

          <div class="form-group">
            <label for="subject">Temat</label>
            <input type="text" id="subject" name="subject" placeholder="W jakiej sprawie piszesz?" required>
          </div>

          <div class="form-group">
            <label for="message">Wiadomość</label>
            <textarea id="message" name="message" rows="6" placeholder="Twoja wiadomość..." required></textarea>
          </div>

          <button type="submit" class="btn btn-primary">
            <span>Wyślij wiadomość</span>
          </button>
        </form>
      </div>
    </div>

    <!-- FAQ Section -->
    <div class="faq-section">
      <h2>Najczęściej zadawane pytania</h2>
      
      <dl class="faq-list">
        <dt>Kiedy odbędzie się turniej?</dt>
        <dd>Dokładne daty turnieju zostaną ogłoszone wkrótce. Śledź nasze social media, aby być na bieżąco!</dd>

        <dt>Czy mogę zgłosić drużynę z innej szkoły?</dt>
        <dd>Turniej jest przeznaczony wyłącznie dla warszawskich szkół średnich. Każda drużyna musi reprezentować jedną szkołę.</dd>

        <dt>Ile kosztuje udział w turnieju?</dt>
        <dd>Udział w turnieju jest całkowicie darmowy! Wystarczy wypełnić formularz zgłoszeniowy.</dd>

        <dt>Czy potrzebujemy opiekuna?</dt>
        <dd>Tak, każda drużyna musi mieć opiekuna - nauczyciela lub inną osobę dorosłą związaną ze szkołą.</dd>

        <dt>Jakie są nagrody?</dt>
        <dd>Szczegóły dotyczące nagród zostaną ogłoszone wkrótce. Przygotowujemy atrakcyjne nagrody dla najlepszych drużyn!</dd>

        <dt>Jak mogę śledzić wyniki turnieju?</dt>
        <dd>Wszystkie wyniki będą publikowane na naszej stronie oraz na social mediach. Transmisje z meczów będą dostępne na YouTube.</dd>
      </dl>
    </div>
  </div>
</main>

<?php require_once "footer.php"; ?>
